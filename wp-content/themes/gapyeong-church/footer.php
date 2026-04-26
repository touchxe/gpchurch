<?php
/**
 * 가평교회 테마 - Footer Template
 * 기존 components/footer.html 을 WordPress PHP로 변환
 */
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="가평교회"
                    class="footer-logo">
                <p class="footer-church-name">제칠일안식일예수재림교회<br>가평교회</p>
                <p class="footer-church-meta"><i data-lucide="map-pin"></i> 가평군 가평읍 석봉로 153번길 2</p>
                <p class="footer-church-meta"><i data-lucide="phone"></i> 031-581-2765</p>
                <div class="footer-social">
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                </div>
            </div>

            <!-- 교회소개 -->
            <?php if (has_nav_menu('footer-intro')): ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'footer-intro',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'walker'         => new Gapyeong_Footer_Nav_Walker(),
                    'depth'          => 2,
                )); ?>
            <?php else: ?>
            <div class="footer-links">
                <h4>교회소개</h4>
                <ul>
                    <li><a href="/intro/greeting">인사말</a></li>
                    <li><a href="/intro/vision">비전</a></li>
                    <li><a href="/intro/history">연혁</a></li>
                    <li><a href="/intro/organization">조직도</a></li>
                    <li><a href="/intro/location">오시는 길</a></li>
                </ul>
            </div>
            <?php endif; ?>

            <!-- 프로그램 -->
            <?php if (has_nav_menu('footer-program')): ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'footer-program',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'walker'         => new Gapyeong_Footer_Nav_Walker(),
                    'depth'          => 2,
                )); ?>
            <?php else: ?>
            <div class="footer-links">
                <h4>프로그램</h4>
                <ul>
                    <li><a href="/program/worship">예배 안내</a></li>
                    <li><a href="/program/sabbath">안식일학교</a></li>
                    <li><a href="/program/pathfinder">패스파인더</a></li>
                    <li><a href="/program/youth">청년반</a></li>
                    <li><a href="/program/smallgroup">소그룹</a></li>
                </ul>
            </div>
            <?php endif; ?>

            <!-- 커뮤니티 -->
            <?php if (has_nav_menu('footer-community')): ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'footer-community',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'walker'         => new Gapyeong_Footer_Nav_Walker(),
                    'depth'          => 2,
                )); ?>
            <?php else: ?>
            <div class="footer-links">
                <h4>커뮤니티</h4>
                <ul>
                    <li><a href="/community/notice">공지사항</a></li>
                    <li><a href="/community/gallery">갤러리</a></li>
                    <li><a href="/community/bulletin">주보</a></li>
                    <li><a href="/community/qna">문의하기</a></li>
                    <li><a href="/community/prayer">기도요청</a></li>
                </ul>
            </div>
            <?php endif; ?>

            <!-- 이용안내 -->
            <div class="footer-links">
                <h4>이용안내</h4>
                <ul>
                    <li><a href="/community/qna">1:1 문의</a></li>
                    <li><a href="/intro/location">오시는 길</a></li>
                    <li><a href="/intro/greeting">담임목사 인사말</a></li>
                    <li><a href="/community/prayer">기도 요청</a></li>
                    <li><a href="https://gpchurch.mycafe24.com/로그인-화면/">로그인</a></li>
                </ul>
            </div>
        </div>

        <!-- 하단 바: 저작권 + 패밀리 사이트 -->
        <div class="footer-bottom">
            <p>&copy;
                <?php echo date('Y'); ?> 가평교회 (Gapyeong SDA Church). All rights reserved.
            </p>

            <!-- 패밀리 사이트 드롭다운 (우측 하단) -->
            <div class="family-site-wrap" id="familySiteWrap">
                <button class="family-site-btn" id="familySiteBtn" aria-haspopup="true" aria-expanded="false">
                    <span>패밀리 사이트</span>
                    <i data-lucide="chevron-up" class="family-chevron"></i>
                </button>
                <ul class="family-site-list" id="familySiteList" role="menu">
                    <li role="none"><a href="https://www.adventist.or.kr/" target="_blank" rel="noopener" role="menuitem">재림마을</a></li>
                    <li role="none"><a href="https://adventist.org/" target="_blank" rel="noopener" role="menuitem">대총회</a></li>
                    <li role="none"><a href="https://www.eckc.or.kr/" target="_blank" rel="noopener" role="menuitem">동중한합회 서회</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" aria-label="맨 위로 이동">
    <i data-lucide="chevron-up"></i>
</button>

<script>
(function () {
    var btn  = document.getElementById('familySiteBtn');
    var list = document.getElementById('familySiteList');
    if (!btn || !list) return;

    btn.addEventListener('click', function () {
        var open = list.classList.toggle('open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // 외부 클릭 시 닫기
    document.addEventListener('click', function (e) {
        var wrap = document.getElementById('familySiteWrap');
        if (wrap && !wrap.contains(e.target)) {
            list.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
})();
</script>

<?php wp_footer(); ?>
</body>

</html>