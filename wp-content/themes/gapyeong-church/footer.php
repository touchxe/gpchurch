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
                <p>제칠일안식일예수재림교회<br>가평교회</p>
                <div class="footer-social">
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                </div>
            </div>
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
                    <li><a href="/intro/location">오시는 길</a></li>
                </ul>
            </div>
            <?php endif; ?>

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
                </ul>
            </div>
            <?php endif; ?>

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
                    <li><a href="/community/qna">문의하기</a></li>
                    <li><a href="/community/prayer">기도요청</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div class="footer-bottom">
            <p>&copy;
                <?php echo date('Y'); ?> 가평교회 (Gapyeong SDA Church). All rights reserved.
            </p>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" aria-label="맨 위로 이동">
    <i data-lucide="chevron-up"></i>
</button>

<?php wp_footer(); ?>
</body>

</html>