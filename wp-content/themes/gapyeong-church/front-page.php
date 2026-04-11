<?php
/**
 * 가평교회 테마 - Front Page Template
 * 기존 index.html 의 <body> 콘텐츠를 WordPress PHP로 변환
 * (메인 홈페이지 - 설정 > 읽기 > 정적 페이지로 지정 필요)
 */
get_header();

$theme_uri = get_template_directory_uri();
?>

<!-- Global Parallax Background Orbs -->
<div class="global-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    <div class="orb orb-5"></div>
</div>

<!-- Scroll Progress Indicator -->
<div class="scroll-indicator">
    <span class="scroll-text">scroll</span>
    <div class="scroll-track">
        <div class="scroll-progress"></div>
        <div class="scroll-dot"></div>
    </div>
</div>

<!-- Hero Section - Split Layout -->
<section class="hero-section">
    <!-- Decorative Background Circles -->
    <div class="hero-bg-circles">
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
        <div class="bg-circle bg-circle-3"></div>
    </div>
    <!-- Decorative Geometric Shapes -->
    <div class="deco-shapes">
        <svg class="deco-shape deco-triangle-1" viewBox="0 0 100 100" fill="none">
            <polygon points="50,10 90,80 10,80" fill="#6366f1" opacity="0.6" />
            <polygon points="70,20 85,55 55,55" fill="#10b981" opacity="0.8" />
        </svg>
        <svg class="deco-shape deco-diamond-1" viewBox="0 0 60 60" fill="none">
            <path d="M30 5 L55 30 L30 55 L5 30 Z" fill="#06b6d4" opacity="0.5" />
            <circle cx="15" cy="15" r="6" fill="#10b981" opacity="0.8" />
        </svg>
        <svg class="deco-shape deco-circle-1" viewBox="0 0 90 90" fill="none">
            <circle cx="45" cy="45" r="35" fill="#f59e0b" opacity="0.4" />
        </svg>
        <svg class="deco-shape deco-triangle-3" viewBox="0 0 120 120" fill="none">
            <polygon points="60,15 100,95 20,95" fill="#3b82f6" opacity="0.5" />
        </svg>
    </div>
    <div class="container">
        <div class="hero-grid">
            <!-- Left Content -->
            <div class="hero-text">
                <?php
                // ACF 히어로 텍스트 필드 읽기 (미설정 시 기존 값 폴백)
                $fp_id = (int) get_option('page_on_front');
                $acf_active = function_exists('get_field') && $fp_id > 0;

                $label1 = $acf_active ? get_field('hero_label_1', $fp_id) : '';
                $label2 = $acf_active ? get_field('hero_label_2', $fp_id) : '';
                $title1 = $acf_active ? get_field('hero_title_1', $fp_id) : '';
                $title2 = $acf_active ? get_field('hero_title_2', $fp_id) : '';
                $subtitle = $acf_active ? get_field('hero_subtitle', $fp_id) : '';
                $btn1_text = $acf_active ? get_field('hero_btn1_text', $fp_id) : '';
                $btn1_url = $acf_active ? get_field('hero_btn1_url', $fp_id) : '';
                $btn2_text = $acf_active ? get_field('hero_btn2_text', $fp_id) : '';
                $btn2_url = $acf_active ? get_field('hero_btn2_url', $fp_id) : '';

                // 폴백 기본값
                if (!$label1)
                    $label1 = '제칠일안식일예수재림교회';
                if (!$label2)
                    $label2 = 'Gapyeong SDA Church';
                if (!$title1)
                    $title1 = '하나님의 사랑 안에서';
                if (!$title2)
                    $title2 = '함께하는 가평교회';
                if (!$subtitle)
                    $subtitle = "매주 토요일 안식일 예배로 여러분을 초대합니다.\n말씀과 찬양으로 하나님께 영광을 돌리는 공동체입니다.";
                if (!$btn1_text)
                    $btn1_text = '예배 시간 안내';
                if (!$btn1_url)
                    $btn1_url = '/program/worship';
                ?>
                <div class="hero-tag">
                    <span class="tag-highlight"><?php echo esc_html($label1); ?></span>
                    <span class="tag-sub"><?php echo esc_html($label2); ?></span>
                </div>
                <h1 class="hero-title">
                    <?php echo esc_html($title1); ?><br>
                    <span class="text-highlight"><?php echo esc_html($title2); ?></span>
                </h1>
                <p class="hero-subtitle">
                    <?php
                    // 줄바꿈(\n)을 <br>로 변환하여 출력
                    echo nl2br(esc_html($subtitle));
                    ?>
                </p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-primary">
                        <?php echo esc_html($btn1_text); ?> <i data-lucide="arrow-right"></i>
                    </a>
                    <?php if ($btn2_text): ?>
                        <a href="<?php echo esc_url($btn2_url ?: '#'); ?>" class="btn btn-secondary">
                            <?php echo esc_html($btn2_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Right Image (Swiper Slider) -->
            <div class="hero-images">
                <div class="swiper hero-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        // ACF 개별 이미지 필드에서 슬라이드 가져오기 (슬라이드 1~5)
                        // get_option('page_on_front')으로 프론트 페이지 ID를 명시 전달
                        $has_acf_slides = false;
                        $front_page_id = (int) get_option('page_on_front');

                        if (function_exists('get_field') && $front_page_id > 0):
                            for ($i = 1; $i <= 5; $i++):
                                $img = get_field('hero_slide_' . $i, $front_page_id);
                                if (empty($img))
                                    continue;
                                $has_acf_slides = true;
                                $url = esc_url($img['url'] ?? '');
                                $alt = esc_attr($img['alt'] ?? '가평교회');
                                if (!$url)
                                    continue;
                                ?>
                                <div class="swiper-slide">
                                    <div class="hero-slide-item">
                                        <img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>">
                                    </div>
                                </div>
                                <?php
                            endfor;
                        endif;


                        // ACF 이미지가 하나도 없으면 기본 이미지로 폴백
                        if (!$has_acf_slides):
                            $default_slides = array(
                                array('src' => $theme_uri . '/assets/images/hero-slide-1.jpg', 'alt' => '가평교회 전경 1'),
                                array('src' => $theme_uri . '/assets/images/hero-slide-2.jpg', 'alt' => '가평교회 전경 2'),
                            );
                            foreach ($default_slides as $s):
                                ?>
                                <div class="swiper-slide">
                                    <div class="hero-slide-item">
                                        <img src="<?php echo esc_url($s['src']); ?>" alt="<?php echo esc_attr($s['alt']); ?>">
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="hero-pagination"></div>
                </div>
            </div>


        </div>
    </div>
</section>


<!-- Quick Menu Section -->
<section class="quick-menu-section">
    <div class="container">
        <div class="quick-menu-box">
            <!-- 1. 예배 안내 -->
            <a href="/program/worship" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#60a5fa" />
                            </linearGradient>
                        </defs>
                        <rect x="10" y="14" width="44" height="36" rx="8" fill="url(#g1)" opacity="0.6" />
                        <rect x="16" y="20" width="32" height="24" rx="4" fill="url(#g1)" opacity="0.3" />
                        <path d="M32 28v8M28 32h8" stroke="white" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
                <span>예배 안내</span>
            </a>

            <!-- 2. 안식일학교 -->
            <a href="/program/sabbath" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f97316" />
                                <stop offset="100%" stop-color="#fb923c" />
                            </linearGradient>
                        </defs>
                        <rect x="14" y="10" width="36" height="44" rx="6" fill="url(#g2)" opacity="0.6" />
                        <rect x="20" y="16" width="24" height="32" rx="3" fill="url(#g2)" opacity="0.3" />
                        <path d="M26 26h12M26 34h8" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>안식일학교</span>
            </a>

            <!-- 3. 오시는 길 -->
            <a href="https://gpchurch.mycafe24.com/intro/location/" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#34d399" />
                            </linearGradient>
                        </defs>
                        <circle cx="32" cy="26" r="18" fill="url(#g3)" opacity="0.6" />
                        <circle cx="32" cy="26" r="10" fill="url(#g3)" opacity="0.3" />
                        <path d="M32 48l-8-14h16z" fill="url(#g3)" opacity="0.8" />
                    </svg>
                </div>
                <span>오시는 길</span>
            </a>

            <!-- 4. 갤러리 -->
            <a href="/community/gallery" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#60a5fa" />
                            </linearGradient>
                        </defs>
                        <rect x="8" y="14" width="48" height="36" rx="6" fill="url(#g4)" opacity="0.6" />
                        <rect x="14" y="20" width="36" height="24" rx="3" fill="url(#g4)" opacity="0.3" />
                        <circle cx="24" cy="28" r="4" fill="white" opacity="0.9" />
                        <path d="M14 44l12-10 8 6 12-10 10 8" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span>갤러리</span>
            </a>

            <!-- 5. 공지사항 -->
            <a href="/community/notice" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g5" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#8b5cf6" />
                                <stop offset="100%" stop-color="#a78bfa" />
                            </linearGradient>
                        </defs>
                        <rect x="12" y="10" width="40" height="44" rx="6" fill="url(#g5)" opacity="0.6" />
                        <rect x="18" y="16" width="28" height="32" rx="3" fill="url(#g5)" opacity="0.3" />
                        <path d="M24 26h16M24 34h16M24 42h10" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>공지사항</span>
            </a>

            <!-- 6. 기도요청 -->
            <a href="/community/prayer" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="g6" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#f472b6" />
                            </linearGradient>
                        </defs>
                        <circle cx="26" cy="32" r="16" fill="url(#g6)" opacity="0.5" />
                        <circle cx="38" cy="32" r="16" fill="#a855f7" opacity="0.4" />
                        <circle cx="32" cy="32" r="6" fill="white" opacity="0.9" />
                    </svg>
                </div>
                <span>기도요청</span>
            </a>

            <!-- 7. 재림마을 -->
            <a href="http://www.adventist.or.kr/" target="_blank" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#8b5cf6" />
                            </linearGradient>
                        </defs>
                        <circle cx="32" cy="32" r="22" fill="url(#e1)" opacity="0.6" />
                        <circle cx="32" cy="32" r="14" fill="url(#e1)" opacity="0.3" />
                        <path d="M32 14v36M14 32h36" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>재림마을</span>
            </a>

            <!-- 8. 성경읽기 -->
            <a href="https://www.sijosa.com/sijosa/bible.php" target="_blank" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#34d399" />
                            </linearGradient>
                        </defs>
                        <rect x="16" y="12" width="32" height="40" rx="4" fill="url(#e2)" opacity="0.6" />
                        <rect x="22" y="18" width="20" height="28" rx="2" fill="url(#e2)" opacity="0.3" />
                        <path d="M26 28h12M26 36h12M26 44h8" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>성경읽기</span>
            </a>

            <!-- 9. 안교교과 -->
            <a href="https://www.adventist.or.kr/channel/bbs/content.php?co_id=ss_lesson" target="_blank"
                class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e3" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f59e0b" />
                                <stop offset="100%" stop-color="#fbbf24" />
                            </linearGradient>
                        </defs>
                        <rect x="10" y="16" width="44" height="32" rx="4" fill="url(#e3)" opacity="0.6" />
                        <rect x="16" y="22" width="32" height="20" rx="2" fill="url(#e3)" opacity="0.3" />
                        <path d="M22 30h8M34 30h8M22 38h8M34 38h8" stroke="white" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <span>안교교과</span>
            </a>

            <!-- 10. 예언의신 -->
            <a href="https://www.adventist.or.kr/channel/bbs/content.php?co_id=egw_writings" target="_blank"
                class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e4" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#8b5cf6" />
                                <stop offset="100%" stop-color="#a78bfa" />
                            </linearGradient>
                        </defs>
                        <path d="M32 12l-16 22h32z" fill="url(#e4)" opacity="0.6" />
                        <rect x="20" y="34" width="24" height="18" rx="3" fill="url(#e4)" opacity="0.5" />
                        <path d="M28 44h8" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>예언의신</span>
            </a>

            <!-- 11. 찬미가 -->
            <a href="https://www.adventist.or.kr/hymn?referer=adventist" target="_blank" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e5" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#f472b6" />
                            </linearGradient>
                        </defs>
                        <circle cx="22" cy="44" r="8" fill="url(#e5)" opacity="0.7" />
                        <circle cx="46" cy="38" r="6" fill="url(#e5)" opacity="0.5" />
                        <path d="M28 44V22l22-6v22" stroke="url(#e5)" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span>찬미가</span>
            </a>

            <!-- 12. 교단뉴스 -->
            <a href="https://www.adventist.or.kr/news/" target="_blank" class="quick-item">
                <div class="quick-icon">
                    <svg viewBox="0 0 64 64" fill="none">
                        <defs>
                            <linearGradient id="e6" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#06b6d4" />
                                <stop offset="100%" stop-color="#22d3ee" />
                            </linearGradient>
                        </defs>
                        <rect x="10" y="12" width="44" height="40" rx="6" fill="url(#e6)" opacity="0.6" />
                        <rect x="16" y="18" width="32" height="28" rx="3" fill="url(#e6)" opacity="0.3" />
                        <path d="M22 28h20M22 36h20M22 44h12" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <span>교단뉴스</span>
            </a>
        </div>
    </div>
</section>


<!-- Program Gallery - Bento Grid -->
<section class="section gallery-section">
    <!-- Decorative Shapes -->
    <div class="section-deco">
        <svg class="deco-shape deco-triangle-2" viewBox="0 0 100 100" fill="none">
            <polygon points="50,10 90,80 10,80" fill="#ec4899" opacity="0.4" />
            <polygon points="25,30 40,65 10,65" fill="#8b5cf6" opacity="0.6" />
        </svg>
        <svg class="deco-shape deco-diamond-2" viewBox="0 0 60 60" fill="none">
            <path d="M30 5 L55 30 L30 55 L5 30 Z" fill="#3b82f6" opacity="0.4" />
            <circle cx="45" cy="45" r="5" fill="#10b981" opacity="0.7" />
        </svg>
        <svg class="deco-shape deco-triangle-4" viewBox="0 0 110 110" fill="none">
            <polygon points="55,12 95,88 15,88" fill="#06b6d4" opacity="0.45" />
        </svg>
        <svg class="deco-shape deco-diamond-4" viewBox="0 0 70 70" fill="none">
            <path d="M35 6 L64 35 L35 64 L6 35 Z" fill="#f59e0b" opacity="0.5" />
        </svg>
        <svg class="deco-shape deco-circle-3" viewBox="0 0 90 90" fill="none">
            <circle cx="45" cy="45" r="35" fill="#ec4899" opacity="0.38" />
        </svg>
        <svg class="deco-shape deco-triangle-5" viewBox="0 0 130 130" fill="none">
            <polygon points="65,18 110,100 20,100" fill="#8b5cf6" opacity="0.42" />
        </svg>
    </div>
    <div class="container">
        <div class="activity-grid">
            <!-- Main Card (Left) -->
            <div class="activity-main" data-aos="fade-right">
                <div class="activity-main-content">
                    <img src="<?php echo esc_url($theme_uri); ?>/assets/images/worship-main.png" alt="예배 모습">
                    <div class="activity-main-overlay">
                        <h3>예배시간 안내</h3>
                        <p>매주 토요일과 금요일 저녁, 함께 하나님께 예배드립니다</p>
                        <div class="worship-time-badges">
                            <span class="time-badge primary">안식일(토) 11시</span>
                            <span class="time-badge secondary">금요일 저녁 7시 30분</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Cards Grid -->
            <div class="activity-cards" data-aos="fade-left">
                <div class="activity-card">
                    <div class="activity-icon">
                        <i data-lucide="book-open"></i>
                    </div>
                    <h4>안식일학교</h4>
                    <p>연령별 성경 공부와 교과 토의를 통해 말씀을 깊이 배웁니다.</p>
                    <div class="card-time-badge"><i data-lucide="clock"></i><span>안식일(토) 9시 30분</span></div>
                </div>
                <div class="activity-card">
                    <div class="activity-icon">
                        <i data-lucide="users"></i>
                    </div>
                    <h4>청년반</h4>
                    <p>청년들이 함께 신앙을 나누며 성장하는 공동체입니다.</p>
                    <div class="card-time-badge"><i data-lucide="clock"></i><span>안식일(토) 13시 30분</span></div>
                </div>
                <div class="activity-card">
                    <div class="activity-icon">
                        <i data-lucide="compass"></i>
                    </div>
                    <h4>패스파인더</h4>
                    <p>청소년을 위한 야외 활동과 봉사 프로그램입니다.</p>
                    <div class="card-time-badge"><i data-lucide="clock"></i><span>안식일(토) 13시 30분</span></div>
                </div>
                <div class="activity-card">
                    <div class="activity-icon">
                        <i data-lucide="heart-handshake"></i>
                    </div>
                    <h4>소그룹</h4>
                    <p>이웃을 섬기며 사랑을 실천하는 소그룹 활동입니다.</p>
                    <div class="card-time-badge"><i data-lucide="clock"></i><span>소그룹별 상이</span></div>
                </div>
            </div>
        </div>

        <!-- Activity CTA -->
        <div class="activity-cta" data-aos="fade-up">
            <div class="activity-cta-content">
                <div class="activity-cta-icon">
                    <i data-lucide="handshake"></i>
                </div>
                <div class="activity-cta-text">
                    <h3>교회 활동에 함께 하고 싶으신가요?</h3>
                    <p>다양한 프로그램에 참여하고 싶으시다면 언제든 문의해 주세요. 따뜻하게 환영합니다!</p>
                </div>
                <a href="https://gpchurch.mycafe24.com/community/contact/" class="btn btn-white">활동 참여 문의하기</a>
            </div>
        </div>
    </div>
</section>


<!-- Church Activities Blog Style -->
<section class="section activities-blog-section">
    <div class="container">
        <!-- Team Showcase -->
        <div class="team-showcase" data-aos="fade-up">
            <div class="team-showcase-left">
                <div class="team-avatars">
                    <div class="avatar-group">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=member1" alt="교인" class="avatar">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=member2" alt="교인" class="avatar">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=member3" alt="교인" class="avatar">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=member4" alt="교인" class="avatar">
                        <div class="avatar-plus">
                            <i data-lucide="plus"></i>
                        </div>
                    </div>
                </div>
                <p class="team-description">함께하는 <strong>가평교회 성도들</strong>이<br>신앙 공동체를 이루어 갑니다</p>
            </div>
            <div class="team-showcase-right">
                <h3 class="team-slogan">
                    하나님의 사랑 안에서 함께 성장하며 서로 돌보는 <span class="highlight">따뜻한 신앙 공동체</span>입니다. 말씀과 찬양으로 하나 되어 이웃을 섬기며
                    사랑을 실천합니다.
                </h3>
                <a href="https://gpchurch.mycafe24.com/intro/location/" class="team-cta-btn">오시는 길</a>
            </div>
        </div>

        <!-- KBoard 최신글 모아보기 갤러리 (id=3, gallary-skin) -->
        <div class="activities-blog-grid-header" data-aos="fade-up">
            <h2 class="activities-blog-title">교회 활동</h2>
            <a href="/community/gallery" class="activities-more-link">전체 보기 <i data-lucide="arrow-right"></i></a>
        </div>
        <div class="kboard-latestview-wrapper" data-aos="fade-up">
            <?php echo do_shortcode('[kboard_latestview id="3"]'); ?>
        </div>
    </div>
</section>


<!-- Church Info Section (교회알림) -->
<section class="section church-info-section">
    <div class="container">
        <h2 class="section-title section-title-left">교회알림</h2>
        <p class="section-subtitle section-subtitle-left">가평교회의 최신 소식과 주요 안내사항을 확인하세요. 주보, 공지사항, 교회 일정 등 다양한 정보를 한눈에
            보실 수 있습니다.</p>

        <div class="church-info-box" data-aos="fade-up">
            <!-- Row 1: 3 Columns -->
            <div class="info-row info-row-main">
                <!-- Column 1: 주보 -->
                <div class="info-col bulletin-col">
                    <div class="col-header">
                        <h3>주보</h3>
                        <a href="/community/bulletin" class="more-link">더보기 <i data-lucide="chevron-right"></i></a>
                    </div>
                    <?php
                    $b_img = get_option('gpc_bulletin_image', esc_url($theme_uri) . '/assets/images/bulletin-cover.png');
                    $b_title = get_option('gpc_bulletin_title', '주보를 등록해 주세요');
                    $b_date = get_option('gpc_bulletin_date', '');
                    $b_link = get_option('gpc_bulletin_link', '/community/bulletin');
                    ?>
                    <a href="<?php echo esc_url($b_link); ?>" class="bulletin-card">
                        <div class="bulletin-image">
                            <img src="<?php echo esc_url($b_img); ?>" alt="주보 표지">
                            <span class="bulletin-badge">이번 주</span>
                        </div>
                        <div class="bulletin-info">
                            <h4><?php echo esc_html($b_title); ?></h4>
                            <?php if ($b_date): ?>
                                <span class="bulletin-date"><?php echo esc_html($b_date); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <a href="/community/bulletin" class="bulletin-archive-btn">
                        <i data-lucide="archive"></i>
                        <span>지난 주보 보기</span>
                    </a>
                </div>

                <!-- Column 2: 공지사항 -->
                <div class="info-col notice-col">
                    <div class="col-header">
                        <h3>공지사항</h3>
                        <a href="/community/notice" class="more-link">더보기 <i data-lucide="chevron-right"></i></a>
                    </div>
                    <?php echo do_shortcode('[kboard_latestview id="4" skin="notice-skin"]'); ?>

                    <!-- 자료실 -->
                    <div class="resources-section">
                        <h4 class="resources-title">자료실</h4>
                        <ul class="resources-list">
                            <li class="resource-item">
                                <i data-lucide="file-text"></i>
                                <span class="resource-name">2026년 교회 사업계획서</span>
                                <a href="#" class="resource-download"><i data-lucide="download"></i></a>
                            </li>
                            <li class="resource-item">
                                <i data-lucide="file-spreadsheet"></i>
                                <span class="resource-name">안식일학교 교과 자료</span>
                                <a href="#" class="resource-download"><i data-lucide="download"></i></a>
                            </li>
                            <li class="resource-item">
                                <i data-lucide="file-image"></i>
                                <span class="resource-name">교회 행사 포스터</span>
                                <a href="#" class="resource-download"><i data-lucide="download"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Column 3: 교회일정 (달력 + 일정) -->
                <div class="info-col calendar-col">
                    <div class="col-header">
                        <h3>교회일정</h3>
                    </div>
                    <div class="calendar-schedule-wrapper" data-board-id="3">

                        <!-- Mini Calendar -->
                        <div class="mini-calendar">
                            <div class="calendar-header">
                                <button class="cal-nav cal-prev"><i data-lucide="chevron-left"></i></button>
                                <span class="cal-month">로딩 중...</span>
                                <button class="cal-nav cal-next"><i data-lucide="chevron-right"></i></button>
                            </div>
                            <div class="calendar-grid">
                                <div class="cal-weekdays">
                                    <span>일</span><span>월</span><span>화</span><span>수</span><span>목</span><span>금</span><span>토</span>
                                </div>
                                <div class="cal-days" id="calendarDays">
                                    <!-- Days generated by JS -->
                                </div>
                            </div>
                        </div>
                        <!-- Month Schedule - JS로 동적 렌더링 -->
                        <div class="month-schedule">
                            <h4 class="schedule-month-title" id="scheduleMonthTitle">일정 로딩 중...</h4>
                            <ul class="schedule-list" id="scheduleList">
                                <!-- JS가 REST API로 동적으로 채웁니다 -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Contact Info -->
            <div class="info-row info-row-contact">
                <div class="contact-item">
                    <i data-lucide="user"></i>
                    <div class="contact-info">
                        <span class="contact-label">담임목사</span>
                        <span class="contact-name">홍길동 목사</span>
                        <a href="tel:010-1234-5678" class="contact-phone">010-1234-5678</a>
                    </div>
                </div>
                <div class="contact-item">
                    <i data-lucide="shield-check"></i>
                    <div class="contact-info">
                        <span class="contact-label">수석장로</span>
                        <span class="contact-name">김성실 장로</span>
                        <a href="tel:010-9876-5432" class="contact-phone">010-9876-5432</a>
                    </div>
                </div>
                <div class="contact-item">
                    <i data-lucide="map-pin"></i>
                    <div class="contact-info">
                        <span class="contact-label">교회주소</span>
                        <span class="contact-address">경기도 가평군 가평읍 (상세주소)</span>
                        <a href="https://maps.google.com/?q=가평교회" target="_blank" class="map-link">
                            <i data-lucide="external-link"></i> 지도보기
                        </a>
                    </div>
                </div>
                <a href="/contact" class="contact-cta-btn">
                    <i data-lucide="mail"></i>
                    <span>문의하기</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Schedule Detail Modal -->
    <div class="schedule-modal" id="scheduleModal">
        <div class="schedule-modal-overlay"></div>
        <div class="schedule-modal-content">
            <button class="schedule-modal-close"><i data-lucide="x"></i></button>
            <div class="modal-header">
                <span class="modal-date" id="modalDate">01.11</span>
                <h3 class="modal-title" id="modalTitle">신년 기도회</h3>
            </div>
            <div class="modal-body">
                <p id="modalDescription">새해를 맞이하여 온 성도가 함께 모여 기도하는 시간입니다.</p>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <i data-lucide="clock"></i>
                        <span id="modalTime">오후 7:00</span>
                    </div>
                    <div class="modal-detail-item">
                        <i data-lucide="map-pin"></i>
                        <span id="modalLocation">본당</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Department Introduction Section -->
<section class="section departments-section">
    <!-- Decorative Shapes -->
    <div class="section-deco">
        <svg class="deco-shape deco-triangle-3" viewBox="0 0 100 100" fill="none">
            <polygon points="50,10 90,80 10,80" fill="#f97316" opacity="0.4" />
            <polygon points="30,40 45,75 15,75" fill="#3b82f6" opacity="0.5" />
        </svg>
        <svg class="deco-shape deco-diamond-3" viewBox="0 0 60 60" fill="none">
            <path d="M30 5 L55 30 L30 55 L5 30 Z" fill="#8b5cf6" opacity="0.35" />
            <circle cx="10" cy="50" r="4" fill="#06b6d4" opacity="0.7" />
        </svg>
        <svg class="deco-shape deco-triangle-6" viewBox="0 0 115 115" fill="none">
            <polygon points="57,13 97,90 17,90" fill="#10b981" opacity="0.43" />
        </svg>
        <svg class="deco-shape deco-diamond-5" viewBox="0 0 75 75" fill="none">
            <path d="M37 7 L68 37 L37 68 L7 37 Z" fill="#ec4899" opacity="0.48" />
        </svg>
        <svg class="deco-shape deco-circle-4" viewBox="0 0 95 95" fill="none">
            <circle cx="47" cy="47" r="37" fill="#3b82f6" opacity="0.36" />
        </svg>
        <svg class="deco-shape deco-triangle-7" viewBox="0 0 140 140" fill="none">
            <polygon points="70,20 115,105 25,105" fill="#f59e0b" opacity="0.4" />
        </svg>
    </div>
    <div class="container">
        <h2 class="section-title section-title-left">부서 소개</h2>
        <p class="section-subtitle section-subtitle-left">각 부서가 유기적으로 연합하여 교회를 섬기고 제자 삼는 사명을 감당합니다.</p>

        <!-- Department Slider -->
        <div class="dept-slider-container" id="deptSliderContainer">
            <div class="dept-slider-track" id="deptSliderTrack">
                <a href="https://gpchurch.mycafe24.com/dept/ministry/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="book-open"></i></div>
                    <h3>목회부</h3>
                    <p>성령의 임재 속에 모든 성도가 증인이 되어 새 생명을 잉태하도록 이끕니다. 말씀365, 행복누리기 소그룹, 제자훈련 등을 주관합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/clerk/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="file-text"></i></div>
                    <h3>교회서기</h3>
                    <p>교회의 모든 행정 사항을 기록으로 남겨 보관합니다. 교인 교적 정리, 각부 기말보고 종합, 교회 비품 및 재산 관리 업무를 수행합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/treasury/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="coins"></i></div>
                    <h3>교회재무</h3>
                    <p>하나님의 소유권을 인정하는 청지기 정신으로 교회의 재정을 관리합니다. 십일금 및 월정헌금 정착, 투명한 지출 결의 집행을 담당합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/elders/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="users"></i></div>
                    <h3>장로회</h3>
                    <p>성도들에게 영적 모범을 보이며 목사와 협력하여 양들을 목양합니다. 예배 시무 및 설교 준비, 성만찬과 각종 예식을 주관합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/deacons/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="hand-heart"></i></div>
                    <h3>집사회</h3>
                    <p>경건한 예배 분위기를 조성하고 교회의 시설과 비품을 관리합니다. 예배 안내, 헌금 수합, 침례 및 성찬 예식의 실무를 조력합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/mission/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="globe"></i></div>
                    <h3>선교회</h3>
                    <p>TMI(전교인 참여 사역) 관계 중심 전도를 통해 영혼을 구원하는 일에 주력합니다. 소그룹 전도 축제 운영, 평신도 선교 교육, 새벽기도회 등을 기획합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/sabbath-school/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="book-open-check"></i></div>
                    <h3>안식일학교</h3>
                    <p>성경 연구와 교제를 통해 성도의 영적 성장을 도모합니다. 토의식 교과 교수법 정착, 새신자 정착 지원, 정각 출석 캠페인을 전개합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/community-service/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="gift"></i></div>
                    <h3>지역사회봉사회(도르가회)</h3>
                    <p>구제와 봉사를 통해 지역사회에 하나님의 사랑을 전합니다. 도르가 바자회 운영, 자립준비청년 지원, 지역인재 장학금 사업을 수행합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/children/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="smile"></i></div>
                    <h3>어린이부</h3>
                    <p>어린이들이 예수님의 제자로 성장하도록 전문적인 신앙 교육을 제공합니다. 여름/겨울 성경학교, 영성 훈련 캠프, 친구 초청 안식일 등을 운영합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/youth-student/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="graduation-cap"></i></div>
                    <h3>청년·학생 선교회</h3>
                    <p>하나님의 사랑을 바탕으로 서로 사랑하며 사회에 봉사하는 증인이 됩니다. 국내외 봉사활동, 동아리 운영, 자체 홈페이지 구축 프로젝트를 진행합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/pathfinder-dept/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="compass"></i></div>
                    <h3>패스파인더</h3>
                    <p>어린이와 청소년을 대상으로 지적·영적·신체적 성장을 위한 전인 교육을 실시합니다. 기능 활동 교육, 캠프 개최, 지도자 양성 프로그램을 운영합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/choir/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="music"></i></div>
                    <h3>찬양대</h3>
                    <p>음악과 찬양을 통해 하나님께 영광을 돌리고 풍성한 예배를 준비합니다. 예배 찬양 주관, 기악팀 운영, 연말 찬양 발표회를 개최합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/health-welfare/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="heart-pulse"></i></div>
                    <h3>보건복지부</h3>
                    <p>성경적인 건강 기별을 따라 영육이 강건한 삶을 살도록 돕습니다. 맨발 걷기(어싱), 절제 주간 운영, 예언의 신 말씀 나눔 활동을 진행합니다.</p>
                </a>
                <a href="https://gpchurch.mycafe24.com/dept/digital-media/" class="department-card">
                    <div class="dept-icon-wrapper"><i data-lucide="monitor-play"></i></div>
                    <h3>디지털 홍보부</h3>
                    <p>현대적 매체와 기술을 활용하여 효과적으로 복음을 전파합니다. 온라인 예배 생중계, 방송 시스템 안정화, 디지털 미디어 교육을 담당합니다.</p>
                </a>
            </div>

            <!-- Prev / Next Buttons -->
            <button class="dept-slider-btn dept-slider-prev" id="deptSliderPrev" aria-label="이전">
                <i data-lucide="chevron-left"></i>
            </button>
            <button class="dept-slider-btn dept-slider-next" id="deptSliderNext" aria-label="다음">
                <i data-lucide="chevron-right"></i>
            </button>
        </div>

        <!-- Dot Indicators -->
        <div class="dept-slider-dots" id="deptSliderDots"></div>

        <script>
        (function () {
            var GAP = 24;

            var track   = document.getElementById('deptSliderTrack');
            var prevBtn = document.getElementById('deptSliderPrev');
            var nextBtn = document.getElementById('deptSliderNext');
            var dotsEl  = document.getElementById('deptSliderDots');

            if (!track) return;

            /* ── 원본 카드 수집 (초기화 전에 저장) ── */
            var origCards = Array.from(track.querySelectorAll('.department-card'));
            var total = origCards.length; // 14

            var cpp     = 3;   // 현재 화면에 보이는 카드 수
            var cardW   = 0;   // 카드 1장 너비(px)
            var current = 0;   // 현재 '첫 번째 보이는' 실제 카드 인덱스 (0 ~ total-1)
            var busy    = false;

            /* ── 반응형: 보이는 카드 수 ── */
            function getCPP() {
                var w = window.innerWidth;
                if (w < 640)  return 1;
                if (w < 1024) return 2;
                return 3;
            }

            /* ── 트랙 재구성 (클론 앞뒤 삽입) ── */
            function buildTrack() {
                cpp   = getCPP();
                var container = track.parentElement;
                var totalGap  = GAP * (cpp - 1);
                cardW = (container.clientWidth - totalGap) / cpp;

                /* 클론: 뒤에서 cpp장 → 앞에 붙이기 / 앞에서 cpp장 → 뒤에 붙이기 */
                var before = origCards.slice(total - cpp).map(function (c) { return c.cloneNode(true); });
                var after  = origCards.slice(0, cpp).map(function (c) { return c.cloneNode(true); });

                /* 트랙 초기화 후 [before | origCards | after] 순서로 삽입 */
                track.innerHTML = '';
                before.forEach(function (c) { track.appendChild(c); });
                origCards.forEach(function (c) { track.appendChild(c); });
                after.forEach(function (c)  { track.appendChild(c); });

                /* 전체 카드 너비 일괄 적용 */
                Array.from(track.querySelectorAll('.department-card')).forEach(function (c) {
                    c.style.width      = cardW + 'px';
                    c.style.minWidth   = cardW + 'px';
                    c.style.flexShrink = '0';
                });
                track.style.gap = GAP + 'px';

                /* lucide 아이콘 재초기화 (클론 대상) */
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons({ nodes: Array.from(track.querySelectorAll('i[data-lucide]')) });
                }

                /* 현재 위치로 즉시 이동 */
                jump(cpp + current);
                buildDots();
                updateDots();
            }

            /* ── 위치 즉시 이동 (애니메이션 없음) ── */
            function jump(absIdx) {
                track.style.transition = 'none';
                track.style.transform  = 'translateX(-' + (absIdx * (cardW + GAP)) + 'px)';
                /* 강제 리플로우 → transition 재적용을 위해 */
                track.getBoundingClientRect();
            }

            /* ── 위치 애니메이션 이동 ── */
            function slide(absIdx) {
                track.style.transition = 'transform 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
                track.style.transform  = 'translateX(-' + (absIdx * (cardW + GAP)) + 'px)';
            }

            /* ── 방향 이동: dir = +1(next) / -1(prev) ── */
            function go(dir) {
                if (busy) return;
                busy = true;

                var next = current + dir;
                /* 무한루프: before/after 클론 영역으로 슬라이드 후 순간이동 */
                slide(cpp + next);

                track.addEventListener('transitionend', function onEnd() {
                    track.removeEventListener('transitionend', onEnd);

                    /* 경계 처리 */
                    if (next >= total) {
                        current = 0;
                    } else if (next < 0) {
                        current = total - 1;
                    } else {
                        current = next;
                    }

                    jump(cpp + current);
                    updateDots();
                    busy = false;
                });
            }

            /* ── 도트 직접 이동 ── */
            function goTo(idx) {
                if (busy) return;
                busy = true;
                current = idx;
                slide(cpp + current);
                track.addEventListener('transitionend', function onEnd() {
                    track.removeEventListener('transitionend', onEnd);
                    updateDots();
                    busy = false;
                });
            }

            /* ── 도트 생성 (카드 1개당 1개) ── */
            function buildDots() {
                dotsEl.innerHTML = '';
                for (var i = 0; i < total; i++) {
                    var dot = document.createElement('button');
                    dot.className = 'dept-dot';
                    dot.setAttribute('aria-label', (i + 1) + '번째 카드');
                    (function (idx) {
                        dot.addEventListener('click', function () { goTo(idx); });
                    })(i);
                    dotsEl.appendChild(dot);
                }
            }

            /* ── 도트 활성 상태 갱신 ── */
            function updateDots() {
                var dots = dotsEl.querySelectorAll('.dept-dot');
                dots.forEach(function (d, i) {
                    d.classList.toggle('active', i === current);
                });
            }

            /* ── 버튼 이벤트 ── */
            prevBtn.addEventListener('click', function () { go(-1); });
            nextBtn.addEventListener('click', function () { go(1); });

            /* ── 터치 스와이프 ── */
            var touchStartX = 0;
            track.addEventListener('touchstart', function (e) {
                touchStartX = e.touches[0].clientX;
            }, { passive: true });
            track.addEventListener('touchend', function (e) {
                var diff = touchStartX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 50) go(diff > 0 ? 1 : -1);
            }, { passive: true });

            /* ── 리사이즈 ── */
            var resizeTimer;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(buildTrack, 200);
            });

            /* ── 초기화 ── */
            function init() {
                buildTrack();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
        </script>
    </div>
</section>


<?php get_footer(); ?>