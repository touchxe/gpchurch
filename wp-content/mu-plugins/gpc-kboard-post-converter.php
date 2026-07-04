<?php
/**
 * Plugin Name: GPC KBoard Post Converter
 * Description: Converts selected KBoard boards into native WordPress posts.
 * Author: Gapyeong Church Digital Team
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GPC_KBoard_Post_Converter {
    const META_UID      = '_gpc_kboard_uid';
    const META_BOARD_ID = '_gpc_kboard_board_id';
    const META_SOURCE   = '_gpc_kboard_source_file';

    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'register_admin_page' ) );
    }

    public static function board_map() {
        return array(
            1 => array(
                'label'         => '공지사항',
                'category_name' => '공지사항',
                'category_slug' => 'notices',
            ),
            2 => array(
                'label'         => '갤러리',
                'category_name' => '교회활동',
                'category_slug' => 'church-activities',
            ),
            4 => array(
                'label'         => '주보 아카이브',
                'category_name' => '주보',
                'category_slug' => 'bulletin',
            ),
        );
    }

    public static function register_admin_page() {
        add_management_page(
            'KBoard 글 변환',
            'KBoard 글 변환',
            'manage_options',
            'gpc-kboard-post-converter',
            array( __CLASS__, 'render_admin_page' )
        );
    }

    public static function render_admin_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.' ) );
        }

        $result = null;
        if ( isset( $_POST['gpc_kboard_convert_nonce'] ) ) {
            check_admin_referer( 'gpc_kboard_convert', 'gpc_kboard_convert_nonce' );

            $boards = isset( $_POST['boards'] ) && is_array( $_POST['boards'] )
                ? array_map( 'absint', wp_unslash( $_POST['boards'] ) )
                : array();
            $dry_run = empty( $_POST['convert_now'] );
            $result  = self::convert_boards( $boards, $dry_run );
        }

        $board_map = self::board_map();
        ?>
        <div class="wrap">
            <h1>KBoard 글 변환</h1>
            <p>1번 공지사항, 2번 갤러리, 4번 주보 게시판의 KBoard 글을 WordPress 기본 글로 복사합니다. 이미 변환된 글은 원본 UID 메타값으로 감지해 건너뜁니다.</p>

            <?php if ( $result ) : ?>
                <div class="notice notice-<?php echo $result['errors'] ? 'warning' : 'success'; ?> is-dismissible">
                    <p>
                        <?php
                        echo esc_html(
                            sprintf(
                                '%s 완료: 생성 %d건, 건너뜀 %d건, 누락 파일 %d건, 오류 %d건',
                                $result['dry_run'] ? '드라이런' : '변환',
                                $result['created'],
                                $result['skipped'],
                                $result['missing_files'],
                                $result['errors']
                            )
                        );
                        ?>
                    </p>
                </div>

                <?php if ( ! empty( $result['messages'] ) ) : ?>
                    <div class="notice notice-info">
                        <p><strong>처리 로그</strong></p>
                        <ul style="list-style: disc; padding-left: 20px;">
                            <?php foreach ( array_slice( $result['messages'], 0, 80 ) as $message ) : ?>
                                <li><?php echo esc_html( $message ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <h2>게시판 상태</h2>
            <table class="widefat striped" style="max-width: 820px;">
                <thead>
                    <tr>
                        <th>Board ID</th>
                        <th>게시판</th>
                        <th>대상 카테고리</th>
                        <th>변환 대상</th>
                        <th>변환 완료</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $board_map as $board_id => $config ) : ?>
                        <?php $status = self::get_board_status( $board_id ); ?>
                        <tr>
                            <td><?php echo esc_html( (string) $board_id ); ?></td>
                            <td><?php echo esc_html( $config['label'] ); ?></td>
                            <td><?php echo esc_html( $config['category_name'] ); ?></td>
                            <td><?php echo esc_html( (string) $status['total'] ); ?></td>
                            <td><?php echo esc_html( (string) $status['converted'] ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" style="margin-top: 24px;">
                <?php wp_nonce_field( 'gpc_kboard_convert', 'gpc_kboard_convert_nonce' ); ?>

                <fieldset>
                    <legend><strong>변환할 게시판</strong></legend>
                    <?php foreach ( $board_map as $board_id => $config ) : ?>
                        <label style="display: block; margin: 8px 0;">
                            <input type="checkbox" name="boards[]" value="<?php echo esc_attr( (string) $board_id ); ?>" checked>
                            <?php echo esc_html( sprintf( '%d번 %s -> %s', $board_id, $config['label'], $config['category_name'] ) ); ?>
                        </label>
                    <?php endforeach; ?>
                </fieldset>

                <p class="submit">
                    <button type="submit" class="button">드라이런</button>
                    <button type="submit" class="button button-primary" name="convert_now" value="1">변환 실행</button>
                </p>
            </form>
        </div>
        <?php
    }

    private static function get_board_status( $board_id ) {
        global $wpdb;

        $content_table = $wpdb->prefix . 'kboard_board_content';
        if ( ! self::table_exists( $content_table ) ) {
            return array( 'total' => 0, 'converted' => 0 );
        }

        $total = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$content_table} WHERE board_id = %d AND parent_uid = 0 AND status != 'trash'",
                $board_id
            )
        );

        $converted = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(DISTINCT p.ID)
                 FROM {$wpdb->posts} p
                 INNER JOIN {$wpdb->postmeta} uid_meta
                    ON p.ID = uid_meta.post_id AND uid_meta.meta_key = %s
                 INNER JOIN {$wpdb->postmeta} board_meta
                    ON p.ID = board_meta.post_id AND board_meta.meta_key = %s AND board_meta.meta_value = %d
                 WHERE p.post_type = 'post'
                   AND p.post_status NOT IN ('trash', 'auto-draft')",
                self::META_UID,
                self::META_BOARD_ID,
                $board_id
            )
        );

        return array(
            'total'     => $total,
            'converted' => $converted,
        );
    }

    private static function convert_boards( $boards, $dry_run ) {
        global $wpdb;

        $board_map = self::board_map();
        $boards    = array_values( array_intersect( array_keys( $board_map ), $boards ) );

        $result = array(
            'dry_run'       => (bool) $dry_run,
            'created'       => 0,
            'skipped'       => 0,
            'missing_files' => 0,
            'errors'        => 0,
            'messages'      => array(),
        );

        if ( empty( $boards ) ) {
            $result['errors']++;
            $result['messages'][] = '선택된 게시판이 없습니다.';
            return $result;
        }

        $content_table = $wpdb->prefix . 'kboard_board_content';
        if ( ! self::table_exists( $content_table ) ) {
            $result['errors']++;
            $result['messages'][] = 'KBoard content 테이블을 찾을 수 없습니다.';
            return $result;
        }

        $placeholders = implode( ',', array_fill( 0, count( $boards ), '%d' ) );
        $query = $wpdb->prepare(
            "SELECT * FROM {$content_table}
             WHERE board_id IN ({$placeholders})
               AND parent_uid = 0
               AND status != 'trash'
             ORDER BY board_id ASC, date ASC",
            $boards
        );

        $rows = $wpdb->get_results( $query );
        foreach ( $rows as $row ) {
            $converted = self::convert_row( $row, $board_map[ (int) $row->board_id ], $dry_run );

            foreach ( array( 'created', 'skipped', 'missing_files', 'errors' ) as $key ) {
                $result[ $key ] += $converted[ $key ];
            }
            $result['messages'] = array_merge( $result['messages'], $converted['messages'] );
        }

        return $result;
    }

    private static function convert_row( $row, $config, $dry_run ) {
        $result = array(
            'created'       => 0,
            'skipped'       => 0,
            'missing_files' => 0,
            'errors'        => 0,
            'messages'      => array(),
        );

        $uid      = (int) $row->uid;
        $board_id = (int) $row->board_id;
        $title    = wp_strip_all_tags( (string) $row->title );
        if ( '' === $title ) {
            $title = sprintf( 'KBoard #%d', $uid );
        }

        if ( self::find_converted_post_id( $uid, $board_id ) ) {
            $result['skipped']++;
            $result['messages'][] = sprintf( '[%d:%d] 이미 변환됨: %s', $board_id, $uid, $title );
            return $result;
        }

        if ( $dry_run ) {
            $result['created']++;
            $result['messages'][] = sprintf( '[%d:%d] 변환 예정: %s', $board_id, $uid, $title );
            return $result;
        }

        $category_id = self::ensure_category( $config['category_name'], $config['category_slug'] );
        if ( ! $category_id ) {
            $result['errors']++;
            $result['messages'][] = sprintf( '[%d:%d] 카테고리 생성 실패: %s', $board_id, $uid, $config['category_name'] );
            return $result;
        }

        $post_date     = self::kboard_date_to_mysql( $row->date );
        $post_modified = self::kboard_date_to_mysql( $row->update );
        $author_id     = self::resolve_author_id( (int) $row->member_uid );

        $post_id = wp_insert_post(
            wp_slash(
                array(
                    'post_author'    => $author_id,
                    'post_title'     => $title,
                    'post_content'   => (string) $row->content,
                    'post_status'    => 'publish',
                    'post_type'      => 'post',
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_date'      => $post_date,
                    'post_date_gmt'  => get_gmt_from_date( $post_date ),
                    'post_modified'  => $post_modified,
                    'post_modified_gmt' => get_gmt_from_date( $post_modified ),
                )
            ),
            true
        );

        if ( is_wp_error( $post_id ) ) {
            $result['errors']++;
            $result['messages'][] = sprintf( '[%d:%d] 글 생성 실패: %s', $board_id, $uid, $post_id->get_error_message() );
            return $result;
        }

        wp_set_post_terms( $post_id, array( $category_id ), 'category', false );
        add_post_meta( $post_id, self::META_UID, $uid, true );
        add_post_meta( $post_id, self::META_BOARD_ID, $board_id, true );
        add_post_meta( $post_id, '_gpc_kboard_member_display', (string) $row->member_display, true );
        add_post_meta( $post_id, '_gpc_kboard_view_count', (int) $row->view, true );
        add_post_meta( $post_id, '_gpc_kboard_original_url', site_url( '?kboard_content_redirect=' . $uid ), true );

        $media_result = self::convert_media_for_post( $post_id, $row );
        $result['missing_files'] += $media_result['missing_files'];
        $result['errors']        += $media_result['errors'];
        $result['messages']       = array_merge( $result['messages'], $media_result['messages'] );

        $result['created']++;
        $result['messages'][] = sprintf( '[%d:%d] 변환 완료: #%d %s', $board_id, $uid, $post_id, $title );

        return $result;
    }

    private static function convert_media_for_post( $post_id, $row ) {
        $result = array(
            'missing_files' => 0,
            'errors'        => 0,
            'messages'      => array(),
        );

        $content       = (string) $row->content;
        $featured_id   = 0;
        $image_sources = self::extract_image_sources( $content );

        foreach ( $image_sources as $source_url ) {
            $attachment_id = self::register_upload_as_attachment( $source_url, $post_id );
            if ( ! $attachment_id ) {
                $result['missing_files']++;
                $result['messages'][] = sprintf( '[%d:%d] 본문 이미지 파일 없음: %s', (int) $row->board_id, (int) $row->uid, $source_url );
                continue;
            }

            $attachment_url = wp_get_attachment_url( $attachment_id );
            if ( $attachment_url ) {
                $content = str_replace( $source_url, $attachment_url, $content );
            }

            if ( ! $featured_id && wp_attachment_is_image( $attachment_id ) ) {
                $featured_id = $attachment_id;
            }
        }

        $attachment_sources = self::get_kboard_attachment_sources( (int) $row->uid );
        foreach ( $attachment_sources as $source ) {
            $attachment_id = self::register_upload_as_attachment( $source['path'], $post_id, $source['name'] );
            if ( ! $attachment_id ) {
                $result['missing_files']++;
                $result['messages'][] = sprintf( '[%d:%d] 첨부 파일 없음: %s', (int) $row->board_id, (int) $row->uid, $source['path'] );
                continue;
            }

            if ( ! $featured_id && wp_attachment_is_image( $attachment_id ) ) {
                $featured_id = $attachment_id;
            }

            $attachment_url = wp_get_attachment_url( $attachment_id );
            if (
                $attachment_url
                && wp_attachment_is_image( $attachment_id )
                && false === strpos( $content, $attachment_url )
                && false === strpos( $content, $source['path'] )
            ) {
                $content .= "\n\n" . '<figure class="wp-block-image"><img src="' . esc_url( $attachment_url ) . '" alt="' . esc_attr( $source['name'] ) . '" /></figure>';
            }
        }

        if ( ! empty( $row->thumbnail_file ) ) {
            $thumbnail_id = self::register_upload_as_attachment( (string) $row->thumbnail_file, $post_id, (string) $row->thumbnail_name );
            if ( $thumbnail_id && wp_attachment_is_image( $thumbnail_id ) ) {
                $featured_id = $thumbnail_id;
            }
        }

        wp_update_post(
            wp_slash(
                array(
                    'ID'           => $post_id,
                    'post_content' => $content,
                )
            )
        );

        if ( $featured_id ) {
            set_post_thumbnail( $post_id, $featured_id );
        }

        return $result;
    }

    private static function extract_image_sources( $content ) {
        if ( ! preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches ) ) {
            return array();
        }

        return array_values( array_unique( array_map( 'html_entity_decode', $matches[1] ) ) );
    }

    private static function get_kboard_attachment_sources( $content_uid ) {
        global $wpdb;

        $attached_table = $wpdb->prefix . 'kboard_board_attached';
        if ( ! self::table_exists( $attached_table ) ) {
            return array();
        }

        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT file_path, file_name FROM {$attached_table} WHERE content_uid = %d AND comment_uid = 0 ORDER BY uid ASC",
                $content_uid
            )
        );

        $sources = array();
        foreach ( $rows as $row ) {
            $sources[] = array(
                'path' => (string) $row->file_path,
                'name' => (string) $row->file_name,
            );
        }

        return $sources;
    }

    private static function register_upload_as_attachment( $source, $post_id, $title = '' ) {
        $file = self::resolve_upload_file( $source );
        if ( ! $file ) {
            return 0;
        }

        $existing_id = self::find_attachment_by_relative_path( $file['relative'] );
        if ( $existing_id ) {
            return $existing_id;
        }

        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $filetype = wp_check_filetype( $file['path'] );
        if ( empty( $filetype['type'] ) ) {
            return 0;
        }

        $attachment_id = wp_insert_attachment(
            wp_slash(
                array(
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => $title ? $title : pathinfo( $file['path'], PATHINFO_FILENAME ),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                    'post_parent'    => $post_id,
                )
            ),
            $file['path'],
            $post_id,
            true
        );

        if ( is_wp_error( $attachment_id ) ) {
            return 0;
        }

        update_post_meta( $attachment_id, self::META_SOURCE, $file['relative'] );

        if ( 0 === strpos( (string) $filetype['type'], 'image/' ) ) {
            $metadata = wp_generate_attachment_metadata( $attachment_id, $file['path'] );
            if ( ! is_wp_error( $metadata ) && ! empty( $metadata ) ) {
                wp_update_attachment_metadata( $attachment_id, $metadata );
            }
        }

        return (int) $attachment_id;
    }

    private static function resolve_upload_file( $source ) {
        $source = trim( html_entity_decode( (string) $source ) );
        if ( '' === $source ) {
            return false;
        }

        $path = $source;
        if ( preg_match( '#^https?://#i', $source ) ) {
            $parsed = wp_parse_url( $source );
            $path   = isset( $parsed['path'] ) ? $parsed['path'] : '';
        }

        $path = rawurldecode( $path );
        $path = str_replace( '\\', '/', $path );

        $marker = '/wp-content/uploads/';
        $pos    = strpos( $path, $marker );
        if ( false !== $pos ) {
            $relative = substr( $path, $pos + strlen( $marker ) );
        } else {
            $relative = preg_replace( '#^/?wp-content/uploads/#', '', $path );
        }

        $relative = ltrim( $relative, '/' );
        if ( '' === $relative || ( $relative === $path && 0 === strpos( $relative, 'http' ) ) ) {
            return false;
        }

        $uploads = wp_get_upload_dir();
        $full    = trailingslashit( $uploads['basedir'] ) . $relative;
        $full    = wp_normalize_path( $full );

        if ( ! file_exists( $full ) ) {
            return false;
        }

        return array(
            'path'     => $full,
            'relative' => $relative,
        );
    }

    private static function find_attachment_by_relative_path( $relative ) {
        global $wpdb;

        $attachment_id = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1",
                self::META_SOURCE,
                $relative
            )
        );

        if ( $attachment_id ) {
            return $attachment_id;
        }

        return (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
                $relative
            )
        );
    }

    private static function find_converted_post_id( $uid, $board_id ) {
        global $wpdb;

        return (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT p.ID
                 FROM {$wpdb->posts} p
                 INNER JOIN {$wpdb->postmeta} uid_meta
                    ON p.ID = uid_meta.post_id AND uid_meta.meta_key = %s AND uid_meta.meta_value = %d
                 INNER JOIN {$wpdb->postmeta} board_meta
                    ON p.ID = board_meta.post_id AND board_meta.meta_key = %s AND board_meta.meta_value = %d
                 WHERE p.post_type = 'post'
                   AND p.post_status NOT IN ('trash', 'auto-draft')
                 LIMIT 1",
                self::META_UID,
                $uid,
                self::META_BOARD_ID,
                $board_id
            )
        );
    }

    private static function ensure_category( $name, $slug ) {
        $term = get_category_by_slug( $slug );
        if ( $term ) {
            return (int) $term->term_id;
        }

        $term = term_exists( $name, 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return (int) $term['term_id'];
        }

        $inserted = wp_insert_term(
            $name,
            'category',
            array(
                'slug' => $slug,
            )
        );

        if ( is_wp_error( $inserted ) ) {
            return 0;
        }

        return (int) $inserted['term_id'];
    }

    private static function resolve_author_id( $member_uid ) {
        if ( $member_uid > 0 && get_user_by( 'id', $member_uid ) ) {
            return $member_uid;
        }

        $current_user_id = get_current_user_id();
        if ( $current_user_id ) {
            return $current_user_id;
        }

        return 1;
    }

    private static function kboard_date_to_mysql( $date ) {
        $date = preg_replace( '/[^0-9]/', '', (string) $date );
        if ( strlen( $date ) < 14 ) {
            return current_time( 'mysql' );
        }

        return sprintf(
            '%04d-%02d-%02d %02d:%02d:%02d',
            (int) substr( $date, 0, 4 ),
            (int) substr( $date, 4, 2 ),
            (int) substr( $date, 6, 2 ),
            (int) substr( $date, 8, 2 ),
            (int) substr( $date, 10, 2 ),
            (int) substr( $date, 12, 2 )
        );
    }

    private static function table_exists( $table ) {
        global $wpdb;

        return $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table;
    }
}

GPC_KBoard_Post_Converter::init();
