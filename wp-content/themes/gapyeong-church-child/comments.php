<?php
/**
 * Comments template for single posts.
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="gpc-comments">
    <?php if ( have_comments() ) : ?>
        <h2 class="gpc-comments-title">
            <?php
            printf(
                esc_html( _n( '댓글 %s개', '댓글 %s개', get_comments_number(), 'gapyeong-church-child' ) ),
                esc_html( number_format_i18n( get_comments_number() ) )
            );
            ?>
        </h2>

        <ol class="gpc-comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 44,
                )
            );
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="gpc-comment-navigation" aria-label="<?php esc_attr_e( '댓글 페이지', 'gapyeong-church-child' ); ?>">
                <div class="gpc-comment-nav-prev"><?php previous_comments_link( esc_html__( '이전 댓글', 'gapyeong-church-child' ) ); ?></div>
                <div class="gpc-comment-nav-next"><?php next_comments_link( esc_html__( '다음 댓글', 'gapyeong-church-child' ) ); ?></div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() ) : ?>
        <p class="gpc-comments-closed"><?php esc_html_e( '댓글 작성이 닫혀 있습니다.', 'gapyeong-church-child' ); ?></p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $required_attribute = $req ? ' required' : '';

    comment_form(
        array(
            'class_container'      => 'gpc-comment-respond',
            'class_form'           => 'gpc-comment-form',
            'title_reply'          => esc_html__( '답글 남기기', 'gapyeong-church-child' ),
            'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
            'title_reply_after'    => '</h2>',
            'comment_notes_before' => '<p class="comment-notes">' . esc_html__( '이름과 이메일을 입력한 뒤 댓글을 남겨주세요.', 'gapyeong-church-child' ) . '</p>',
            'comment_notes_after'  => '',
            'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( '댓글', 'gapyeong-church-child' ) . '</label><textarea id="comment" name="comment" cols="45" rows="7" required></textarea></p>',
            'fields'               => array(
                'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( '이름', 'gapyeong-church-child' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" autocomplete="name"' . $required_attribute . '></p>',
                'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( '이메일', 'gapyeong-church-child' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" autocomplete="email"' . $required_attribute . '></p>',
                'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( '웹사이트', 'gapyeong-church-child' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" autocomplete="url"></p>',
            ),
            'label_submit'         => esc_html__( '댓글 등록', 'gapyeong-church-child' ),
        )
    );
    ?>
</div>
