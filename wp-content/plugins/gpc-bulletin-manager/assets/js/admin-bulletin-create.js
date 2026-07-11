jQuery(document).ready(function($) {
    if ($('#gpc-bulletin-create-form').length === 0) return;

    // 라이브러리 동적 로드 (html2canvas, jspdf)
    const loadScript = (url) => {
        return new Promise((resolve, reject) => {
            if (document.querySelector(`script[src="${url}"]`)) return resolve();
            const script = document.createElement('script');
            script.src = url;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    };

    Promise.all([
        loadScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'),
        loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js')
    ]).then(() => {
        console.log('PDF libraries loaded');
    });

    // 실시간 미리보기 바인딩 (Debounce)
    let previewTimer;
    $('.gpc-preview-trigger').on('input change', function() {
        clearTimeout(previewTimer);
        previewTimer = setTimeout(() => {
            updatePreview();
        }, 300);
    });

    // 줄바꿈 보존을 위해 텍스트 치환
    function escapeHtmlAndNl(text) {
        if (!text) return '';
        return text.replace(/&/g, "&amp;")
                   .replace(/</g, "&lt;")
                   .replace(/>/g, "&gt;")
                   .replace(/"/g, "&quot;")
                   .replace(/'/g, "&#039;")
                   .replace(/\n/g, "<br>");
    }

    function updatePreview() {
        $('#gpc-bulletin-create-form').find('input, textarea').each(function() {
            const name = $(this).attr('name');
            const val = $(this).val();
            
            if (name) {
                const target = $(`#gpc-preview-container [data-bind="${name}"]`);
                if (target.length) {
                    if ($(this).is('textarea')) {
                        target.html(escapeHtmlAndNl(val));
                    } else {
                        target.text(val);
                    }
                }
            }
        });
    }

    // 사업계획서 데이터 불러오기
    $('#btn-load-plan').on('click', function() {
        const date = $('#publish_date').val();
        if (!date) {
            alert('날짜를 먼저 선택해 주세요.');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).text('불러오는 중...');

        $.ajax({
            url: gpcBulletin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'gpc_bulletin_load_plan',
                nonce: gpcBulletin.nonce,
                date: date
            },
            success: function(res) {
                if (res.success && res.data) {
                    // 데이터 폼에 채우기
                    $.each(res.data, function(key, val) {
                        const el = $(`#${key}`);
                        if (el.length && !el.val()) { // 빈칸일 때만 채움 (수동 수정한 내용 덮어쓰기 방지)
                            el.val(val);
                        }
                    });
                    updatePreview();
                    alert('사업계획서에서 데이터를 성공적으로 불러왔습니다.');
                } else {
                    alert(res.data || '해당 날짜의 사업계획서 데이터를 찾을 수 없습니다.');
                }
            },
            error: function() {
                alert('서버 통신 오류가 발생했습니다.');
            },
            complete: function() {
                btn.prop('disabled', false).text('사업계획서 불러오기');
            }
        });
    });

    // PDF 내보내기
    $('#btn-download-pdf').on('click', async function() {
        const btn = $(this);
        btn.prop('disabled', true).text('PDF 생성 중...');

        const target = document.querySelector('#gpc-bulletin-template');
        
        try {
            const canvas = await html2canvas(target, {
                scale: 2, // 고해상도
                useCORS: true,
                backgroundColor: '#ffffff'
            });

            const imgData = canvas.toDataURL('image/jpeg', 1.0);
            
            // A4 landscape (297 x 210 mm)
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });

            pdf.addImage(imgData, 'JPEG', 0, 0, 297, 210);
            const dateStr = $('#publish_date').val() || 'bulletin';
            pdf.save(`가평교회_주보_${dateStr}.pdf`);

        } catch (error) {
            console.error('PDF 생성 에러:', error);
            alert('PDF 생성 중 오류가 발생했습니다.');
        } finally {
            btn.prop('disabled', false).text('PDF 인쇄본 다운로드');
        }
    });

    // 이미지 생성 후 워드프레스 저장 및 KBoard 연동
    $('#btn-save-bulletin').on('click', async function() {
        const btn = $(this);
        const date = $('#publish_date').val();
        
        if (!date) {
            alert('발행 날짜를 입력해 주세요.');
            return;
        }

        btn.prop('disabled', true).text('이미지 생성 및 저장 중...');
        const target = document.querySelector('#gpc-bulletin-template');

        try {
            // 이미지 캡처
            const canvas = await html2canvas(target, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            });
            const imgData = canvas.toDataURL('image/jpeg', 0.9);

            // 폼 데이터 수집
            const formData = new FormData($('#gpc-bulletin-create-form')[0]);
            formData.append('image_base64', imgData); // 생성된 이미지 첨부

            // 서버로 전송
            $.ajax({
                url: gpcBulletin.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        alert('성공적으로 저장 및 웹 발행되었습니다!');
                        window.location.href = gpcBulletin.adminUrl + '?page=gpc-bulletin';
                    } else {
                        alert('저장 실패: ' + (res.data || '알 수 없는 오류'));
                        btn.prop('disabled', false).text('저장 및 웹 발행');
                    }
                },
                error: function() {
                    alert('서버 통신 오류가 발생했습니다.');
                    btn.prop('disabled', false).text('저장 및 웹 발행');
                }
            });

        } catch (error) {
            console.error('이미지 생성 에러:', error);
            alert('이미지 캡처 중 오류가 발생했습니다.');
            btn.prop('disabled', false).text('저장 및 웹 발행');
        }
    });
});

    // 사업계획서 CSV 업로드
    $('#gpc-bulletin-plan-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btn-upload-plan');
        const fileInput = $('#plan_file')[0];

        if (fileInput.files.length === 0) {
            alert('파일을 선택해 주세요.');
            return;
        }

        btn.prop('disabled', true).text('업로드 중...');
        
        const formData = new FormData(this);

        $.ajax({
            url: gpcBulletin.ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    $('#plan-upload-result').html('<div class="notice notice-success is-dismissible"><p>' + res.data + '</p></div>');
                    $('#gpc-bulletin-plan-form')[0].reset();
                } else {
                    $('#plan-upload-result').html('<div class="notice notice-error is-dismissible"><p>' + res.data + '</p></div>');
                }
            },
            error: function() {
                alert('서버 통신 오류가 발생했습니다.');
            },
            complete: function() {
                btn.prop('disabled', false).text('업로드 및 데이터 갱신');
            }
        });
    });
