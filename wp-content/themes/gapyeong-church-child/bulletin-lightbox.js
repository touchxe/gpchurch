/**
 * 가평교회 주보 라이트박스
 * - .zoom-btn (이번 주 주보 크게 보기) 클릭 → 새 창 대신 라이트박스
 * - .kboard-gallery-link (과거 주보 목록) 클릭 → 이미지 추출 후 라이트박스
 * - 모바일: 핀치 줌, 스와이프 닫기 지원
 * - PC: ESC 키, 배경 클릭으로 닫기
 */
(function () {
    'use strict';

    /* ── 1. 라이트박스 DOM 생성 ── */
    function createLightbox() {
        const lb = document.createElement('div');
        lb.id = 'gpc-lightbox';
        lb.setAttribute('role', 'dialog');
        lb.setAttribute('aria-label', '주보 크게 보기');
        lb.innerHTML = `
            <div id="gpc-lb-backdrop"></div>
            <div id="gpc-lb-container">
                <button id="gpc-lb-close" aria-label="닫기">✕</button>
                <img id="gpc-lb-img" src="" alt="주보 이미지" draggable="false">
                <p id="gpc-lb-caption"></p>
            </div>
        `;
        document.body.appendChild(lb);

        /* 닫기 이벤트 */
        lb.addEventListener('click', function (e) {
            if (e.target === lb || e.target.id === 'gpc-lb-backdrop' || e.target.id === 'gpc-lb-close') {
                closeLightbox();
            }
        });

        /* ESC 키 */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && lb.classList.contains('gpc-lb-open')) {
                closeLightbox();
            }
        });

        /* 모바일 뒤로가기(브라우저 히스토리) 방어 */
        window.addEventListener('popstate', function () {
            if (lb.classList.contains('gpc-lb-open')) {
                closeLightbox();
            }
        });

        /* 스와이프 닫기 (↓ 방향) */
        let touchStartY = 0;
        const container = lb.querySelector('#gpc-lb-container');
        container.addEventListener('touchstart', function (e) {
            touchStartY = e.changedTouches[0].clientY;
        }, { passive: true });
        container.addEventListener('touchend', function (e) {
            const diff = e.changedTouches[0].clientY - touchStartY;
            if (diff > 80) closeLightbox();
        }, { passive: true });

        return lb;
    }

    let lightbox = null;

    function getLightbox() {
        if (!lightbox) lightbox = createLightbox();
        return lightbox;
    }

    /* ── 2. 열기 / 닫기 ── */
    function openLightbox(imgSrc, caption) {
        const lb = getLightbox();
        const img = lb.querySelector('#gpc-lb-img');
        const cap = lb.querySelector('#gpc-lb-caption');

        img.src = imgSrc;
        cap.textContent = caption || '';

        lb.classList.add('gpc-lb-open');
        document.body.style.overflow = 'hidden';

        /* 히스토리 push → 뒤로가기 시 모달만 닫힘 */
        history.pushState({ lightbox: true }, '');
    }

    function closeLightbox() {
        const lb = getLightbox();
        lb.classList.remove('gpc-lb-open');
        document.body.style.overflow = '';

        /* 히스토리가 lightbox 상태면 뒤로 이동 */
        if (history.state && history.state.lightbox) {
            history.back();
        }
    }

    /* ── 3. 이벤트 바인딩 ── */
    document.addEventListener('DOMContentLoaded', function () {

        /* (A) 이번 주 주보 – "크게 보기" 버튼 */
        document.querySelectorAll('.zoom-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const imgSrc = btn.getAttribute('href');
                const caption = document.querySelector('.bulletin-main-info h3')
                    ? document.querySelector('.bulletin-main-info h3').textContent.trim()
                    : '이번 주 주보';
                openLightbox(imgSrc, caption);
            });
        });

        /* (B) 과거 주보 목록 – KBoard 갤러리 링크 */
        document.addEventListener('click', function (e) {
            const link = e.target.closest('.kboard-gallery-link');
            if (!link) return;

            /* 링크에 연결된 이미지 찾기 */
            const thumb = link.querySelector('.kboard-gallery-thumbnail img');
            if (!thumb) return;

            /* 썸네일 src에서 원본 이미지 URL 추출 시도 (워드프레스 리사이즈 접미어 제거) */
            let imgSrc = thumb.src;
            const origSrc = link.getAttribute('data-full') || link.getAttribute('href');

            /* href가 이미지 URL이면 직접 사용, 아니면 썸네일 */
            if (origSrc && /\.(jpg|jpeg|png|gif|webp)(\?|$)/i.test(origSrc)) {
                imgSrc = origSrc;
            }

            const caption = link.querySelector('.kboard-gallery-title')
                ? link.querySelector('.kboard-gallery-title').textContent.trim()
                : '';

            /* 이미지 URL이면 라이트박스, 아니면 기본 동작 허용 */
            if (!imgSrc || !/\.(jpg|jpeg|png|gif|webp)(\?|$)/i.test(imgSrc)) return;

            e.preventDefault();
            openLightbox(imgSrc, caption);
        });
    });

})();
