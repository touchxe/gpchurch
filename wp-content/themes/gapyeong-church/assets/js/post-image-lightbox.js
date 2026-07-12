document.addEventListener('DOMContentLoaded', () => {
    const lightbox = document.getElementById('postImageLightbox');
    const lightboxImage = lightbox?.querySelector('.post-image-lightbox-image');
    const closeButton = lightbox?.querySelector('.post-image-lightbox-close');
    const images = document.querySelectorAll('.post-detail-thumbnail img, .post-detail-body img');
    let lastTrigger = null;

    if (!lightbox || !lightboxImage || !images.length) return;

    const closeLightbox = () => {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('post-image-lightbox-open');
        lightboxImage.removeAttribute('src');
        lastTrigger?.focus();
    };

    const openLightbox = (image) => {
        lastTrigger = image;
        lightboxImage.src = image.currentSrc || image.src;
        lightboxImage.alt = image.alt || '확대된 이미지';
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.classList.add('post-image-lightbox-open');
        closeButton.focus();
    };

    images.forEach((image) => {
        image.classList.add('post-image-zoomable');
        image.tabIndex = 0;
        image.setAttribute('role', 'button');
        image.setAttribute('aria-label', `${image.alt || '이미지'} 크게 보기`);
        image.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            openLightbox(image);
        });
        image.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openLightbox(image);
            }
        });
    });

    closeButton.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
});
