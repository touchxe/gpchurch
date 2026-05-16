/**
 * 순서지 관리 - 관리자 전용 JavaScript
 * 업로드, AI 추출, 설정 저장, 연결 테스트, CRUD
 */
(function ($) {
    'use strict';

    const { ajaxUrl, nonce } = window.gpcBulletin || {};

    // ──────────────────────────────
    //  설정 페이지
    // ──────────────────────────────

    // API Key 보기/숨기기 토글
    $('#gpc-toggle-key').on('click', function () {
        const input = $('#gpc-api-key');
        const isPassword = input.attr('type') === 'password';
        input.attr('type', isPassword ? 'text' : 'password');
        $(this).text(isPassword ? '🙈' : '👁');
    });

    // 설정 저장
    $('#gpc-save-settings').on('click', function () {
        const btn = $(this);
        btn.prop('disabled', true).text('저장 중...');

        $.post(ajaxUrl, {
            action: 'gpc_bulletin_save_settings',
            nonce: nonce,
            api_url: $('#gpc-api-url').val(),
            api_key: $('#gpc-api-key').val(),
            model: $('#gpc-model').val(),
        })
        .done(function (res) {
            if (res.success) {
                showStatus(true, '설정이 저장되었습니다.', '');
            } else {
                showStatus(false, res.data || '저장 실패', '');
            }
        })
        .fail(function () {
            showStatus(false, '네트워크 오류', '');
        })
        .always(function () {
            btn.prop('disabled', false).text('💾 저장');
        });
    });

    // 연결 테스트
    $('#gpc-test-connection').on('click', function () {
        const btn = $(this);
        btn.prop('disabled', true).text('테스트 중...');

        const $status = $('#gpc-connection-status');
        $status.hide();

        $.post(ajaxUrl, {
            action: 'gpc_bulletin_test_api',
            nonce: nonce,
        })
        .done(function (res) {
            showStatus(
                res.success,
                res.success ? '✅ ' + res.message : '❌ ' + res.message,
                res.response_time ? '응답시간: ' + res.response_time + '초' : ''
            );
        })
        .fail(function () {
            showStatus(false, '❌ 네트워크 오류', '');
        })
        .always(function () {
            btn.prop('disabled', false).text('🔌 연결 테스트');
        });
    });

    function showStatus(success, message, timeText) {
        const $status = $('#gpc-connection-status');
        $status
            .removeClass('gpc-status-ok gpc-status-fail')
            .addClass(success ? 'gpc-status-ok' : 'gpc-status-fail')
            .show();
        $status.find('.gpc-status-text').text(message);
        $status.find('.gpc-status-time').text(timeText);
    }

    // ──────────────────────────────
    //  업로드 페이지
    // ──────────────────────────────

    let selectedFile = null;

    // 드롭존 클릭 → 파일 선택창 열기
    $(document).on('click', '#gpc-dropzone', function (e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('gpc-file-input').click();
    });

    // 파일 input 클릭이 드롭존으로 버블링되지 않도록
    $(document).on('click', '#gpc-file-input', function (e) {
        e.stopPropagation();
    });

    // 드래그앤드롭
    $(document)
        .on('dragover', '#gpc-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('gpc-dragover');
        })
        .on('dragleave', '#gpc-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('gpc-dragover');
        })
        .on('drop', '#gpc-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('gpc-dragover');
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

    // 파일 선택 (input change)
    $(document).on('change', '#gpc-file-input', function () {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    // 클립보드 붙여넣기 (Ctrl+V / Cmd+V)
    $(document).on('paste', function (e) {
        // 순서지 업로드 페이지에서만 동작
        if ($('#gpc-dropzone').length === 0 && $('#gpc-preview').length === 0) return;

        const clipboardData = e.originalEvent.clipboardData;
        if (!clipboardData || !clipboardData.items) return;

        for (let i = 0; i < clipboardData.items.length; i++) {
            const item = clipboardData.items[i];
            if (item.type.startsWith('image/')) {
                e.preventDefault();
                const file = item.getAsFile();
                if (file) {
                    handleFile(file);
                }
                return;
            }
        }
    });

    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('이미지 파일만 업로드 가능합니다.');
            return;
        }

        selectedFile = file;

        // 미리보기
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#gpc-preview-img').attr('src', e.target.result);
            $('#gpc-preview').show();
            $('#gpc-dropzone').hide();
            $('#gpc-extract-btn').prop('disabled', false);
        };
        reader.readAsDataURL(file);
    }

    // 이미지 제거
    $(document).on('click', '#gpc-remove-image', function (e) {
        e.stopPropagation();
        selectedFile = null;
        $('#gpc-preview').hide();
        $('#gpc-dropzone').show();
        $('#gpc-extract-btn').prop('disabled', true);
        $('#gpc-file-input').val('');
    });

    // AI 추출
    $('#gpc-extract-btn').on('click', function () {
        if (!selectedFile) return;

        const btn = $(this);
        btn.prop('disabled', true);
        $('#gpc-extract-progress').show();
        $('#gpc-extract-error').hide();

        const formData = new FormData();
        formData.append('action', 'gpc_bulletin_extract');
        formData.append('nonce', nonce);
        formData.append('image', selectedFile);

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            timeout: 120000, // 2분
        })
        .done(function (res) {
            // ── 디버그: 원본 응답 전체 출력 ──
            console.log('[GPC Bulletin] 전체 AJAX 응답:', JSON.stringify(res, null, 2));
            console.log('[GPC Bulletin] res.success:', res.success);
            console.log('[GPC Bulletin] res.data:', res.data);
            console.log('[GPC Bulletin] res.data 타입:', typeof res.data);

            // 데이터 추출 - 응답 구조에 따라 적절히 처리
            let extractedData = null;

            if (res.success && res.data && typeof res.data === 'object') {
                // 정상 케이스: { success: true, data: { publish_date: "...", ... } }
                extractedData = res.data;
            } else if (res.data && res.data.data && typeof res.data.data === 'object') {
                // wp_send_json_success 래핑 케이스: { success: true, data: { success: true, data: {...} } }
                extractedData = res.data.data;
            } else if (typeof res === 'object' && res.publish_date !== undefined) {
                // 최상위에 데이터가 있는 경우
                extractedData = res;
            }

            console.log('[GPC Bulletin] 최종 extractedData:', extractedData);

            if (extractedData) {
                populateForm(extractedData);
                $('#gpc-data-form').slideDown(300);
            } else {
                const error = res.error || (typeof res.data === 'string' ? res.data : '추출에 실패했습니다. 콘솔 로그를 확인해주세요.');
                $('#gpc-extract-error').text(error).show();
            }
        })
        .fail(function (xhr, status) {
            console.error('[GPC Bulletin] AJAX 실패:', status, xhr.responseText);
            const msg = status === 'timeout'
                ? 'AI 분석 시간이 초과되었습니다. 다시 시도해주세요.'
                : '네트워크 오류가 발생했습니다.';
            $('#gpc-extract-error').text(msg).show();
        })
        .always(function () {
            btn.prop('disabled', false);
            $('#gpc-extract-progress').hide();
        });
    });

    // 추출 데이터를 폼에 채우기
    function populateForm(data) {
        console.log('[GPC Bulletin] populateForm 호출됨, 데이터 키:', Object.keys(data));

        let filledCount = 0;
        let missingFields = [];

        for (const [key, value] of Object.entries(data)) {
            const selector = '#gpc-field-' + key;
            const $field = $(selector);
            if ($field.length) {
                $field.val(value || '');
                filledCount++;
                if (value) {
                    console.log('[GPC Bulletin] ✅ 필드 설정:', key, '=', String(value).substring(0, 50));
                }
            } else {
                missingFields.push(key);
            }
        }

        console.log('[GPC Bulletin] 채워진 필드:', filledCount, '개');
        if (missingFields.length > 0) {
            console.warn('[GPC Bulletin] DOM에 없는 필드:', missingFields);
        }
    }

    // ──────────────────────────────
    //  저장
    // ──────────────────────────────

    $('#gpc-save-btn').on('click', function () {
        const btn = $(this);
        btn.prop('disabled', true).text('저장 중...');

        const formData = {
            action: 'gpc_bulletin_save',
            nonce: nonce,
            id: $('#gpc-bulletin-id').val() || 0,
        };

        // 모든 gpc-field 값 수집
        $('[id^="gpc-field-"]').each(function () {
            const name = $(this).attr('name');
            if (name) {
                formData[name] = $(this).val();
            }
        });

        $.post(ajaxUrl, formData)
        .done(function (res) {
            const $notice = $('#gpc-save-notice');
            if (res.success) {
                $notice
                    .removeClass('gpc-notice-error')
                    .addClass('gpc-notice-success')
                    .text('✅ ' + (res.data.message || '저장되었습니다.'))
                    .show();

                // 새로 생성된 경우 ID 업데이트
                if (res.data.id) {
                    $('#gpc-bulletin-id').val(res.data.id);
                }

                // 2초 후 목록으로 이동
                setTimeout(function () {
                    window.location.href = window.gpcBulletin
                        ? ajaxUrl.replace('admin-ajax.php', 'admin.php?page=gpc-bulletin')
                        : 'admin.php?page=gpc-bulletin';
                }, 1500);
            } else {
                $notice
                    .removeClass('gpc-notice-success')
                    .addClass('gpc-notice-error')
                    .text('❌ ' + (res.data || '저장 실패'))
                    .show();
            }
        })
        .fail(function () {
            $('#gpc-save-notice')
                .removeClass('gpc-notice-success')
                .addClass('gpc-notice-error')
                .text('❌ 네트워크 오류')
                .show();
        })
        .always(function () {
            btn.prop('disabled', false).text('💾 저장');
        });
    });

    // ──────────────────────────────
    //  삭제
    // ──────────────────────────────

    $(document).on('click', '.gpc-delete-btn', function () {
        const id = $(this).data('id');
        if (!id || !confirm('이 순서지를 삭제하시겠습니까?')) return;

        $.post(ajaxUrl, {
            action: 'gpc_bulletin_delete',
            nonce: nonce,
            id: id,
        })
        .done(function (res) {
            if (res.success) {
                window.location.href = ajaxUrl.replace('admin-ajax.php', 'admin.php?page=gpc-bulletin');
            } else {
                alert(res.data || '삭제 실패');
            }
        })
        .fail(function () {
            alert('네트워크 오류');
        });
    });

    // ──────────────────────────────
    //  KBoard 게시판 ID 저장
    // ──────────────────────────────

    $('#gpc-save-kboard-id').on('click', function () {
        const btn = $(this);
        const kboardId = $('#gpc-kboard-id').val();
        const $status = $('#gpc-kboard-save-status');
        btn.prop('disabled', true).text('저장 중...');

        $.post(ajaxUrl, {
            action: 'gpc_bulletin_save_kboard_id',
            nonce: nonce,
            kboard_id: kboardId,
        })
        .done(function (res) {
            $status
                .removeClass('gpc-status-fail').addClass('gpc-status-ok')
                .find('.gpc-status-text').text(res.success ? '✅ ' + (res.data || '저장되었습니다.') : '❌ ' + (res.data || '저장 실패'));
            $status.show();
        })
        .fail(function () {
            $status.removeClass('gpc-status-ok').addClass('gpc-status-fail')
                   .find('.gpc-status-text').text('❌ 네트워크 오류');
            $status.show();
        })
        .always(function () {
            btn.prop('disabled', false).text('💾 저장');
        });
    });

    // ──────────────────────────────
    //  공지사항 발행 모달
    // ──────────────────────────────

    // 모달 열기
    $(document).on('click', '#gpc-publish-notice-btn', function () {
        const $modal = $('#gpc-publish-modal');
        if (!$modal.length) return;

        // 날짜 포맷
        const rawDate = $modal.data('publish-date') || '';
        const dateFormatted = rawDate
            ? rawDate.replace(/(\d{4})-(\d{2})-(\d{2})/, '$1년 $2월 $3일')
            : '';

        // 자동 제목 생성
        const title = '가평교회 주간소식 — ' + dateFormatted;

        // 자동 내용 조합
        const content = buildNoticeContent($modal.data());

        $('#gpc-publish-title').val(title);
        $('#gpc-publish-content').val(content);
        $('#gpc-publish-result').hide();
        $modal.fadeIn(200);
        $('body').addClass('gpc-modal-open');
    });

    // 모달 닫기
    function closePublishModal() {
        $('#gpc-publish-modal').fadeOut(150);
        $('body').removeClass('gpc-modal-open');
    }

    $(document).on('click', '#gpc-modal-close, #gpc-publish-cancel, #gpc-modal-overlay', closePublishModal);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') closePublishModal();
    });

    // 공지 내용 자동 조합
    function buildNoticeContent(d) {
        const lines = [];
        const date = (d.publishDate || '').replace(/(\d{4})-(\d{2})-(\d{2})/, '$1년 $2월 $3일');

        lines.push('📅 ' + date + ' 순서지 소식입니다.');

        if (d.sunsetTime) {
            lines.push('');
            lines.push('🌅 일몰 시각: ' + d.sunsetTime);
        }

        if (d.sermonTitle || d.preacher || d.bibleText) {
            lines.push('');
            lines.push('⛪ 이번 주 설교');
            if (d.sermonTitle)  lines.push('  - 제목: ' + d.sermonTitle);
            if (d.preacher)     lines.push('  - 설교자: ' + d.preacher);
            if (d.bibleText)    lines.push('  - 성경 본문: ' + d.bibleText);
        }

        if (d.memoryVerse) {
            lines.push('');
            lines.push('📖 기억절');
            lines.push(d.memoryVerse);
        }

        if (d.churchNews) {
            lines.push('');
            lines.push('📢 교회 소식');
            lines.push(d.churchNews);
        }

        if (d.prayerRequests) {
            lines.push('');
            lines.push('🙏 기도 요청');
            lines.push(d.prayerRequests);
        }

        if (d.serviceThisWeek) {
            lines.push('');
            lines.push('👐 이번 주 봉사');
            lines.push(d.serviceThisWeek);
        }

        if (d.serviceNextWeek) {
            lines.push('');
            lines.push('👐 다음 주 봉사');
            lines.push(d.serviceNextWeek);
        }

        if (d.offeringList) {
            lines.push('');
            lines.push('💰 헌금자 명단');
            lines.push(d.offeringList);
        }

        if (d.announcements) {
            lines.push('');
            lines.push('📣 광고 및 공지');
            lines.push(d.announcements);
        }

        return lines.join('\n');
    }

    // 발행 확정
    $(document).on('click', '#gpc-publish-confirm', function () {
        const btn = $(this);
        const bulletinId = $('#gpc-publish-notice-btn').data('bulletin-id');
        const title   = $('#gpc-publish-title').val().trim();
        const content = $('#gpc-publish-content').val().trim();
        const $result = $('#gpc-publish-result');

        if (!title) {
            $result.removeClass('gpc-notice-success').addClass('gpc-notice-error')
                   .text('❌ 제목을 입력해주세요.').show();
            return;
        }

        btn.prop('disabled', true).text('발행 중...');
        $result.hide();

        $.post(ajaxUrl, {
            action:       'gpc_bulletin_publish_notice',
            nonce:        nonce,
            bulletin_id:  bulletinId,
            post_title:   title,
            post_content: content,
        })
        .done(function (res) {
            if (res.success) {
                $result.removeClass('gpc-notice-error').addClass('gpc-notice-success')
                       .text('✅ ' + res.data.message).show();

                // 버튼 텍스트를 "업데이트"로 변경
                const $publishBtn = $('#gpc-publish-notice-btn');
                $publishBtn
                    .text('🔄 공지사항 업데이트')
                    .removeClass('gpc-btn-success').addClass('gpc-btn-secondary')
                    .data('notice-post-id', res.data.kboard_uid);

                // 발행됨 뱃지 추가
                if (!$('.gpc-published-badge').length) {
                    $publishBtn.before('<span class="gpc-published-badge">✅ 발행됨</span> ');
                }

                // 2초 후 모달 닫기
                setTimeout(closePublishModal, 2000);
            } else {
                $result.removeClass('gpc-notice-success').addClass('gpc-notice-error')
                       .text('❌ ' + (res.data || '발행 실패')).show();
            }
        })
        .fail(function () {
            $result.removeClass('gpc-notice-success').addClass('gpc-notice-error')
                   .text('❌ 네트워크 오류').show();
        })
        .always(function () {
            btn.prop('disabled', false).text('✅ 발행');
        });
    });

})(jQuery);
