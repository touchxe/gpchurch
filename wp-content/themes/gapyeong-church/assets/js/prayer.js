// ========================================
// PRAYER REQUEST PAGE JavaScript
// ========================================

/**
 * Prayer Request Management
 * - Form submission and validation
 * - LocalStorage data persistence
 * - Prayer counter functionality
 * - Filter and sort features
 */

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    initializePrayerPage();
});

// Main initialization function
function initializePrayerPage() {
    // Skip initialization if not on prayer page
    if (!document.getElementById('prayerForm')) {
        return;
    }

    // Initialize form
    setupPrayerForm();

    // Setup anonymous checkbox toggle
    setupAnonymousToggle();

    // Load and display prayers
    loadPrayers();

    // Setup filter buttons
    setupFilters();

    // Setup prayer buttons
    setupPrayerButtons();

    // Setup "write more" button
    setupWriteMoreButton();

    // Initialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// ========================================
// FORM HANDLING
// ========================================

function setupPrayerForm() {
    const form = document.getElementById('prayerForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const isAnonymous = document.getElementById('isAnonymous').checked;
        const author = isAnonymous ? '익명' : document.getElementById('author').value.trim();
        const title = document.getElementById('title').value.trim();
        const content = document.getElementById('content').value.trim();

        // Validation
        if (!title || !content) {
            alert('제목과 내용을 모두 입력해주세요.');
            return;
        }

        if (!isAnonymous && !author) {
            alert('작성자 이름을 입력해주세요.');
            return;
        }

        // Create prayer object
        const prayer = {
            id: Date.now(),
            author: author,
            title: title,
            content: content,
            date: new Date().toISOString(),
            prayerCount: 0,
            status: 'pending', // pending or approved
            isAnonymous: isAnonymous
        };

        // Save to LocalStorage
        savePrayer(prayer);

        // Show success message
        showSuccessMessage();

        // Reset form
        form.reset();

        // Reload prayers
        loadPrayers();
    });
}

function setupAnonymousToggle() {
    const checkbox = document.getElementById('isAnonymous');
    const authorGroup = document.getElementById('authorGroup');
    const authorInput = document.getElementById('author');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            authorGroup.style.display = 'none';
            authorInput.removeAttribute('required');
        } else {
            authorGroup.style.display = 'block';
            authorInput.setAttribute('required', 'required');
        }
    });
}

function showSuccessMessage() {
    const formCard = document.querySelector('.prayer-form-card');
    const successMessage = document.getElementById('successMessage');

    formCard.style.display = 'none';
    successMessage.style.display = 'block';

    // Scroll to success message
    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Reinitialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function setupWriteMoreButton() {
    const writeMoreBtn = document.getElementById('writeMoreBtn');

    if (writeMoreBtn) {
        writeMoreBtn.addEventListener('click', function () {
            const formCard = document.querySelector('.prayer-form-card');
            const successMessage = document.getElementById('successMessage');

            successMessage.style.display = 'none';
            formCard.style.display = 'block';

            // Scroll to form
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }
}

// ========================================
// LOCALSTORAGE FUNCTIONS
// ========================================

function savePrayer(prayer) {
    let prayers = getPrayers();
    prayers.unshift(prayer); // Add to beginning
    localStorage.setItem('gapyeong_prayers', JSON.stringify(prayers));
}

function getPrayers() {
    const data = localStorage.getItem('gapyeong_prayers');
    return data ? JSON.parse(data) : getSamplePrayers();
}

function updatePrayerCount(prayerId) {
    let prayers = getPrayers();
    const index = prayers.findIndex(p => p.id === prayerId);

    if (index !== -1) {
        prayers[index].prayerCount = (prayers[index].prayerCount || 0) + 1;
        localStorage.setItem('gapyeong_prayers', JSON.stringify(prayers));
        return prayers[index].prayerCount;
    }
    return 0;
}

function hasPrayed(prayerId) {
    const prayedList = localStorage.getItem('gapyeong_prayed') || '[]';
    const prayed = JSON.parse(prayedList);
    return prayed.includes(prayerId);
}

function markAsPrayed(prayerId) {
    const prayedList = localStorage.getItem('gapyeong_prayed') || '[]';
    const prayed = JSON.parse(prayedList);

    if (!prayed.includes(prayerId)) {
        prayed.push(prayerId);
        localStorage.setItem('gapyeong_prayed', JSON.stringify(prayed));
        return true;
    }
    return false;
}

// Sample prayers for initial load
function getSamplePrayers() {
    return [
        {
            id: 1,
            author: '익명',
            title: '가족의 건강을 위해',
            content: '부모님의 건강이 회복되도록 기도 부탁드립니다. 하나님의 치유하심이 함께하길 소망합니다.',
            date: '2026-01-15T10:30:00',
            prayerCount: 12,
            status: 'approved',
            isAnonymous: true
        },
        {
            id: 2,
            author: '김성도',
            title: '시험을 앞두고',
            content: '다음 주 중요한 시험이 있습니다. 하나님의 지혜와 평안을 주시길 기도 부탁드립니다.',
            date: '2026-01-14T15:20:00',
            prayerCount: 8,
            status: 'approved',
            isAnonymous: false
        },
        {
            id: 3,
            author: '익명',
            title: '새로운 직장을 위해',
            content: '이직을 준비하고 있습니다. 하나님께서 인도해주시길 기도합니다.',
            date: '2026-01-13T09:15:00',
            prayerCount: 5,
            status: 'pending',
            isAnonymous: true
        }
    ];
}

// ========================================
// DISPLAY PRAYERS
// ========================================

function loadPrayers(filter = 'all') {
    let prayers = getPrayers();

    // Apply filter
    if (filter === 'recent') {
        prayers.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else if (filter === 'popular') {
        prayers.sort((a, b) => (b.prayerCount || 0) - (a.prayerCount || 0));
    }

    displayPrayers(prayers);
}

function displayPrayers(prayers) {
    const grid = document.getElementById('prayerGrid');
    const emptyState = document.getElementById('prayerEmpty');

    if (!grid) return;

    if (prayers.length === 0) {
        grid.style.display = 'none';
        if (emptyState) emptyState.style.display = 'block';
        return;
    }

    grid.style.display = 'grid';
    if (emptyState) emptyState.style.display = 'none';

    grid.innerHTML = prayers.map(prayer => createPrayerCard(prayer)).join('');

    // Reinitialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Reattach event listeners
    setupPrayerButtons();
}

function createPrayerCard(prayer) {
    const date = new Date(prayer.date);
    const formattedDate = `${date.getFullYear()}.${String(date.getMonth() + 1).padStart(2, '0')}.${String(date.getDate()).padStart(2, '0')}`;

    const isPrayed = hasPrayed(prayer.id);
    const prayedClass = isPrayed ? 'prayed' : '';

    const statusBadge = prayer.status === 'approved'
        ? '<span class="prayer-status approved">승인됨</span>'
        : '<span class="prayer-status pending">승인대기</span>';

    return `
        <div class="prayer-card" data-aos="fade-up">
            <div class="prayer-card-header">
                <div class="prayer-card-meta">
                    <span class="prayer-author">
                        <i data-lucide="user"></i>
                        ${prayer.author}
                    </span>
                    <span class="prayer-date">
                        <i data-lucide="calendar"></i>
                        ${formattedDate}
                    </span>
                </div>
                ${statusBadge}
            </div>
            <h3 class="prayer-title">${escapeHtml(prayer.title)}</h3>
            <p class="prayer-content">${escapeHtml(prayer.content)}</p>
            <div class="prayer-card-footer">
                <button class="prayer-btn ${prayedClass}" data-id="${prayer.id}">
                    <i data-lucide="heart"></i>
                    <span class="prayer-count">${prayer.prayerCount || 0}</span>
                    <span>${isPrayed ? '함께 기도했어요' : '함께 기도했어요'}</span>
                </button>
            </div>
        </div>
    `;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ========================================
// PRAYER BUTTON FUNCTIONALITY
// ========================================

function setupPrayerButtons() {
    const prayerBtns = document.querySelectorAll('.prayer-btn');

    prayerBtns.forEach(btn => {
        // Remove existing listeners by cloning
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);

        newBtn.addEventListener('click', function () {
            const prayerId = parseInt(this.dataset.id);

            if (markAsPrayed(prayerId)) {
                const newCount = updatePrayerCount(prayerId);

                // Update UI
                this.classList.add('prayed');
                const countSpan = this.querySelector('.prayer-count');
                countSpan.textContent = newCount;

                // Show animation
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 300);
            }
        });
    });
}

// ========================================
// FILTER FUNCTIONALITY
// ========================================

function setupFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Get filter type
            const filter = this.dataset.filter;

            // Load prayers with filter
            loadPrayers(filter);
        });
    });
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Auto-save draft (optional feature for future)
function saveDraft() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    if (title || content) {
        localStorage.setItem('gapyeong_prayer_draft', JSON.stringify({
            title: title,
            content: content,
            timestamp: Date.now()
        }));
    }
}

// Load draft (optional feature for future)
function loadDraft() {
    const draft = localStorage.getItem('gapyeong_prayer_draft');
    if (draft) {
        const data = JSON.parse(draft);
        document.getElementById('title').value = data.title || '';
        document.getElementById('content').value = data.content || '';
    }
}

// Clear draft
function clearDraft() {
    localStorage.removeItem('gapyeong_prayer_draft');
}

// ========================================
// UPDATE SUBPAGE HERO FOR PRAYER PAGE
// ========================================

// Wait for components to load first
setTimeout(function() {
    const subpageTitle = document.querySelector('.subpage-title');
    const subpageSlogan = document.querySelector('.subpage-slogan');
    const breadcrumb = document.querySelector('.breadcrumb');
    
    if (subpageTitle) {
        subpageTitle.textContent = '�⵵��û';
    }
    
    if (subpageSlogan) {
        subpageSlogan.innerHTML = '���� ������� �⵵�ϸ� �ϳ����� ������ �����ϴ�<br>"���� ���� �⵵�϶�" (���� 5:17)';
    }
    
    if (breadcrumb) {
        breadcrumb.innerHTML = `
            <a href="/">Ȩ</a>
            <i data-lucide="chevron-right"></i>
            <a href="/community">Ŀ�´�Ƽ</a>
            <i data-lucide="chevron-right"></i>
            <span>�⵵��û</span>
        `;
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
}, 100);
