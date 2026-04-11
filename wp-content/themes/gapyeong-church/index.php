<?php
/**
 * 가평교회 테마 - Fallback 템플릿
 * WordPress는 적절한 템플릿 파일이 없을 때 이 파일을 사용합니다.
 */
get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>