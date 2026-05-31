<?php
/**
 * 순서지(주보) 관리자 메뉴 및 라우팅 클래스
 *
 * WordPress 관리자 패널에 순서지 관리 메뉴를 등록하고
 * AJAX 엔드포인트를 제공합니다.
 *
 * @package GPC_Bulletin_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GPC_Bulletin_Admin {

    /** @var GPC_Bulletin_DB */
    private $db;

    public function __construct() {
        $this->db = new GPC_Bulletin_DB();

        // 관리자 메뉴 등록
        add_action( 'admin_menu', array( $this, 'register_menu' ) );

        // 관리자 스크립트/스타일
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

        // AJAX 엔드포인트
        add_action( 'wp_ajax_gpc_bulletin_test_api',       array( $this, 'ajax_test_api' ) );
        add_action( 'wp_ajax_gpc_bulletin_save_settings',   array( $this, 'ajax_save_settings' ) );
        add_action( 'wp_ajax_gpc_bulletin_extract',         array( $this, 'ajax_extract' ) );
        add_action( 'wp_ajax_gpc_bulletin_save',            array( $this, 'ajax_save' ) );
        add_action( 'wp_ajax_gpc_bulletin_delete',          array( $this, 'ajax_delete' ) );
        add_action( 'wp_ajax_gpc_bulletin_publish_notice',  array( $this, 'ajax_publish_notice' ) );
        add_action( 'wp_ajax_gpc_bulletin_save_kboard_id',      array( $this, 'ajax_save_kboard_id' ) );
        add_action( 'wp_ajax_gpc_bulletin_generate_notice',      array( $this, 'ajax_generate_notice_content' ) );
        add_action( 'wp_ajax_gpc_bulletin_save_notice_prompt',   array( $this, 'ajax_save_notice_prompt' ) );
        add_action( 'wp_ajax_gpc_bulletin_bulk_sync',            array( $this, 'ajax_bulk_sync' ) );

        // admin_init에서 테이블 존재 확인 (안전장치)
        add_action( 'admin_init', array( $this, 'maybe_create_table' ) );
    }

    /**
     * 테이블이 없으면 자동 생성 (안전장치)
     */
    public function maybe_create_table() {
        global $wpdb;
        $table = $wpdb->prefix . 'gpc_bulletin';
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) !== $table ) {
            $this->db->create_table();
        }
        // notice_post_id 컬럼 마이그레이션 (기존 설치 환경 대응)
        $this->db->maybe_add_notice_post_id_column();
        // bulletin_post_id 컬럼 마이그레이션 (주보 KBoard 아카이브용)
        $this->db->maybe_add_bulletin_post_id_column();
    }

    /**
     * 관리자 메뉴 등록
     */
    public function register_menu() {
        add_menu_page(
            '순서지 관리',
            '📋 순서지 관리',
            'manage_options',
            'gpc-bulletin',
            array( $this, 'render_list_page' ),
            'dashicons-media-document',
            30
        );

        add_submenu_page(
            'gpc-bulletin',
            '순서지 목록',
            '순서지 목록',
            'manage_options',
            'gpc-bulletin',
            array( $this, 'render_list_page' )
        );

        add_submenu_page(
            'gpc-bulletin',
            '새 순서지 업로드',
            '새 순서지 업로드',
            'manage_options',
            'gpc-bulletin-upload',
            array( $this, 'render_upload_page' )
        );

        add_submenu_page(
            'gpc-bulletin',
            'API 설정',
            '⚙️ API 설정',
            'manage_options',
            'gpc-bulletin-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * 관리자 전용 CSS/JS 로드
     */
    public function enqueue_admin_assets( $hook ) {
        if ( strpos( $hook, 'gpc-bulletin' ) === false ) {
            return;
        }

        wp_enqueue_style(
            'gpc-admin-bulletin-css',
            GPC_BULLETIN_URL . 'assets/css/admin-bulletin.css',
            array(),
            GPC_BULLETIN_VERSION
        );

        wp_enqueue_script(
            'gpc-admin-bulletin-js',
            GPC_BULLETIN_URL . 'assets/js/admin-bulletin.js',
            array( 'jquery' ),
            GPC_BULLETIN_VERSION,
            true
        );

        wp_enqueue_media();

        wp_localize_script( 'gpc-admin-bulletin-js', 'gpcBulletin', array(
            'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'gpc_bulletin_nonce' ),
            'adminUrl' => admin_url( 'admin.php' ),
        ) );
    }

    // ── 페이지 렌더링 ──

    public function render_list_page() {
        if ( isset( $_GET['action'] ) && $_GET['action'] === 'edit' && isset( $_GET['id'] ) ) {
            include GPC_BULLETIN_DIR . 'admin-views/bulletin-edit.php';
            return;
        }
        include GPC_BULLETIN_DIR . 'admin-views/bulletin-list.php';
    }

    public function render_upload_page() {
        include GPC_BULLETIN_DIR . 'admin-views/bulletin-upload.php';
    }

    public function render_settings_page() {
        include GPC_BULLETIN_DIR . 'admin-views/bulletin-settings.php';
    }

    // ── AJAX 핸들러 ──

    public function ajax_test_api() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }
        $result = GPC_Bulletin_AI_Extractor::test_connection();
        wp_send_json( $result );
    }

    public function ajax_save_settings() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        $api_url = isset( $_POST['api_url'] ) ? sanitize_url( wp_unslash( $_POST['api_url'] ) ) : '';
        $api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';
        $model   = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';

        GPC_Bulletin_AI_Extractor::save_settings( $api_url, $api_key, $model );
        wp_send_json_success( '설정이 저장되었습니다.' );
    }

    public function ajax_extract() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        if ( empty( $_FILES['image'] ) ) {
            wp_send_json_error( '이미지 파일이 없습니다.' );
        }

        $file = $_FILES['image'];

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $upload = wp_handle_upload( $file, array( 'test_form' => false ) );

        if ( isset( $upload['error'] ) ) {
            wp_send_json_error( '업로드 실패: ' . $upload['error'] );
        }

        $image_url  = $upload['url'];
        $image_path = $upload['file'];

        $result = GPC_Bulletin_AI_Extractor::extract_from_image( $image_path );

        if ( $result['success'] ) {
            $result['data']['image_url'] = $image_url;
        }

        wp_send_json( $result );
    }

    public function ajax_save() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        $data = array();
        $columns = GPC_Bulletin_DB::get_data_columns();
        $hymn_fields = array( 'ss_hymn', 'ws_doxology', 'ws_hymn', 'ws_offering_hymn', 'ws_closing_hymn' );

        foreach ( $columns as $col ) {
            if ( isset( $_POST[ $col ] ) ) {
                $val = sanitize_textarea_field( wp_unslash( $_POST[ $col ] ) );
                
                // 찬미/송영 필드: 괄호 제거
                if ( in_array( $col, $hymn_fields, true ) ) {
                    $val = str_replace( array( '(', ')', '（', '）' ), '', $val );
                    $val = trim( $val );
                }

                $data[ $col ] = $val;
            }
        }

        // 저장 시점에도 인명/찬미/일몰시각 정규화 (수동 입력 방어)
        $data = GPC_Bulletin_AI_Extractor::normalize_for_save( $data );

        if ( empty( $data['publish_date'] ) ) {
            wp_send_json_error( '발행 날짜는 필수입니다.' );
        }

        $id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

        if ( $id > 0 ) {
            $success = $this->db->update( $id, $data );
            if ( $success ) {
                $this->sync_to_kboard_archive( $id );
                wp_send_json_success( array( 'message' => '순서지가 수정되었습니다.', 'id' => $id ) );
            } else {
                wp_send_json_error( '수정에 실패했습니다.' );
            }
        } else {
            $existing = $this->db->get_by_date( $data['publish_date'] );
            if ( $existing ) {
                $success = $this->db->update( $existing->id, $data );
                if ( $success ) {
                    $this->sync_to_kboard_archive( $existing->id );
                    wp_send_json_success( array( 'message' => '같은 날짜의 기존 순서지를 업데이트했습니다.', 'id' => $existing->id ) );
                } else {
                    wp_send_json_error( '업데이트에 실패했습니다.' );
                }
            } else {
                $new_id = $this->db->insert( $data );
                if ( $new_id ) {
                    $this->sync_to_kboard_archive( $new_id );
                    wp_send_json_success( array( 'message' => '순서지가 저장되었습니다.', 'id' => $new_id ) );
                } else {
                    wp_send_json_error( '저장에 실패했습니다.' );
                }
            }
        }
    }

    public function ajax_delete() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        $id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
        if ( $id <= 0 ) {
            wp_send_json_error( '유효하지 않은 ID입니다.' );
        }

        // 🔗 연동된 KBoard 아카이브 게시글 동시 삭제 로직
        $item = $this->db->get_by_id( $id );
        if ( $item && (int) $item->bulletin_post_id > 0 ) {
            $bulletin_post_id = (int) $item->bulletin_post_id;

            // KBContent 클래스 동적 로드
            if ( ! class_exists( 'KBContent' ) ) {
                $kboard_path = WP_PLUGIN_DIR . '/kboard/class/KBContent.class.php';
                if ( file_exists( $kboard_path ) ) {
                    require_once $kboard_path;
                }
            }

            if ( class_exists( 'KBContent' ) ) {
                $content_obj = new KBContent();
                $content_obj->initWithUID( $bulletin_post_id );
                if ( ! empty( $content_obj->uid ) ) {
                    // KBoard 글, 썸네일, 관련 메타데이터 서버에서 완전 일괄 삭제
                    $content_obj->remove();
                }
            }
        }

        $success = $this->db->delete( $id );
        if ( $success ) {
            wp_send_json_success( '삭제되었습니다.' );
        } else {
            wp_send_json_error( '삭제에 실패했습니다.' );
        }
    }

    /**
     * 공지사항 발행 / 업데이트 AJAX 핸들러
     *
     * KBoard 게시판에 순서지 내용을 글로 발행합니다.
     * 이미 발행된 경우(notice_post_id > 0) 기존 글을 업데이트합니다.
     */
    public function ajax_publish_notice() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        $bulletin_id   = isset( $_POST['bulletin_id'] ) ? (int) $_POST['bulletin_id'] : 0;
        $post_title    = isset( $_POST['post_title'] )   ? sanitize_text_field( wp_unslash( $_POST['post_title'] ) ) : '';
        $post_content  = isset( $_POST['post_content'] ) ? wp_kses_post( wp_unslash( $_POST['post_content'] ) ) : '';
        $post_content_html = $this->format_notice_content_html( $post_content );
        $board_id      = (int) get_option( 'gpc_bulletin_kboard_id', 0 );

        if ( $bulletin_id <= 0 ) {
            wp_send_json_error( '유효하지 않은 순서지 ID입니다.' );
        }
        if ( empty( $post_title ) ) {
            wp_send_json_error( '제목을 입력해주세요.' );
        }
        if ( $board_id <= 0 ) {
            wp_send_json_error( 'KBoard 게시판 ID가 설정되지 않았습니다. 설정 페이지에서 공지사항 게시판 ID를 입력해주세요.' );
        }

        $item = $this->db->get_by_id( $bulletin_id );
        if ( ! $item ) {
            wp_send_json_error( '순서지 데이터를 찾을 수 없습니다.' );
        }

        // KBContent 클래스 로드
        if ( ! class_exists( 'KBContent' ) ) {
            $kboard_path = WP_PLUGIN_DIR . '/kboard/class/KBContent.class.php';
            if ( ! file_exists( $kboard_path ) ) {
                wp_send_json_error( 'KBoard 플러그인이 설치되어 있지 않습니다.' );
            }
            require_once $kboard_path;
        }

        $content_obj = new KBContent( $board_id );

        $existing_uid = (int) $item->notice_post_id;

        if ( $existing_uid > 0 ) {
            // 기존 글 업데이트
            $content_obj->initWithUID( $existing_uid );
            if ( ! empty( $content_obj->uid ) ) {
                $result = $content_obj->updateContent( array(
                    'board_id'       => $board_id,
                    'title'          => $post_title,
                    'content'        => $post_content_html,
                    'member_uid'     => get_current_user_id(),
                    'member_display' => wp_get_current_user()->display_name,
                    'notice'         => 1,
                ) );
                $kboard_uid = $existing_uid;
                $is_update  = true;
            } else {
                // 기존 ID가 있으나 실제 KBoard 글이 삭제된 경우 대응
                $result = $content_obj->insertContent( array(
                    'board_id'       => $board_id,
                    'title'          => $post_title,
                    'content'        => $post_content_html,
                    'member_uid'     => get_current_user_id(),
                    'member_display' => wp_get_current_user()->display_name,
                    'notice'         => 1,
                ) );
                $kboard_uid = $content_obj->uid;
                $is_update  = false;
            }
        } else {
            // 신규 발행
            $result = $content_obj->insertContent( array(
                'board_id'       => $board_id,
                'title'          => $post_title,
                'content'        => $post_content_html,
                'member_uid'     => get_current_user_id(),
                'member_display' => wp_get_current_user()->display_name,
                'notice'         => 1,
            ) );
            $kboard_uid = $content_obj->uid;
            $is_update  = false;
        }

        if ( ! $kboard_uid ) {
            wp_send_json_error( 'KBoard 게시판에 글 작성에 실패했습니다.' );
        }

        // notice_post_id 저장
        $this->db->update( $bulletin_id, array( 'notice_post_id' => $kboard_uid ) );

        wp_send_json_success( array(
            'message'     => $is_update ? '공지사항이 업데이트되었습니다.' : '공지사항이 발행되었습니다.',
            'kboard_uid'  => $kboard_uid,
            'board_id'    => $board_id,
            'is_update'   => $is_update,
        ) );
    }

    /**
     * AI/수동 입력 공지 본문을 KBoard 상세 화면용 HTML 컴포넌트로 변환합니다.
     *
     * @param string $content 관리자 모달에서 입력한 본문
     * @return string
     */
    private function format_notice_content_html( $content ) {
        $lines = $this->normalize_notice_lines( $content );
        if ( empty( $lines ) ) {
            return '';
        }

        $sections = array();
        $lead     = array();
        $current  = null;

        foreach ( $lines as $line ) {
            $heading = $this->detect_notice_heading( $line );

            if ( $heading ) {
                if ( $current ) {
                    $sections[] = $current;
                }

                $current = array(
                    'title' => $heading['title'],
                    'icon'  => $heading['icon'],
                    'slug'  => $heading['slug'],
                    'items' => array(),
                );
                continue;
            }

            if ( $current ) {
                $current['items'][] = $line;
            } else {
                $lead[] = $line;
            }
        }

        if ( $current ) {
            $sections[] = $current;
        }

        $html = '<div class="gpc-notice-article">';

        if ( ! empty( $lead ) ) {
            $html .= '<div class="gpc-notice-lead">';
            foreach ( $lead as $paragraph ) {
                $html .= '<p>' . esc_html( $paragraph ) . '</p>';
            }
            $html .= '</div>';
        }

        foreach ( $sections as $section ) {
            $html .= '<div class="gpc-notice-section gpc-notice-section-' . esc_attr( $section['slug'] ) . '">';
            $html .= '<h2 class="gpc-notice-section-title">';
            $html .= '<span class="gpc-notice-section-icon" aria-hidden="true">' . esc_html( $section['icon'] ) . '</span>';
            $html .= '<span>' . esc_html( $section['title'] ) . '</span>';
            $html .= '</h2>';
            $html .= '<div class="gpc-notice-section-body">';

            $html .= $this->render_notice_items_html( $section['items'] );

            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return wp_kses_post( $html );
    }

    /**
     * HTML/Markdown/줄바꿈이 섞인 입력을 사람이 읽는 줄 목록으로 정리합니다.
     */
    private function normalize_notice_lines( $content ) {
        $content = (string) $content;
        $content = preg_replace_callback(
            '/<img\b[^>]*\balt=["\']([^"\']*)["\'][^>]*>/i',
            function ( $matches ) {
                return html_entity_decode( $matches[1], ENT_QUOTES, 'UTF-8' );
            },
            $content
        );
        $content = preg_replace( '/<br\s*\/?>/i', "\n", $content );
        $content = preg_replace( '/<\/(p|div|section|h[1-6]|li)>/i', "\n", $content );
        $content = preg_replace( '/<li[^>]*>/i', "\n* ", $content );
        $content = wp_strip_all_tags( $content );
        $content = html_entity_decode( $content, ENT_QUOTES, 'UTF-8' );
        $content = str_replace( array( "\r\n", "\r" ), "\n", $content );
        $content = preg_replace( '/\*\*([^*]+)\*\*/u', '$1', $content );
        $content = preg_replace( '/__([^_]+)__/u', '$1', $content );
        $content = preg_replace( '/^[\s#>*_=~-]{3,}$/m', '', $content );
        $content = preg_replace( '/[ \t]+/u', ' ', $content );
        $content = preg_replace( "/\n{2,}/u", "\n", $content );

        $lines = array();
        foreach ( explode( "\n", $content ) as $line ) {
            $line = trim( $line );
            if ( '' === $line ) {
                continue;
            }

            $line = preg_replace( '/^[\*\-]\s*/u', '* ', $line );
            if ( ! empty( $lines ) && end( $lines ) === $line ) {
                continue;
            }

            $lines[] = $line;
        }

        return $lines;
    }

    /**
     * 공지 섹션 제목을 감지해 고정 아이콘/슬러그로 정규화합니다.
     */
    private function detect_notice_heading( $line ) {
        $plain = trim( preg_replace( '/^[^\p{L}\p{N}]+/u', '', $line ) );
        $plain = preg_replace( '/\s+/u', ' ', $plain );

        $headings = array(
            array( 'match' => '말씀', 'title' => '이번 주 말씀 나눔', 'icon' => '✨', 'slug' => 'word' ),
            array( 'match' => '환영', 'title' => '환영합니다', 'icon' => '💖', 'slug' => 'welcome' ),
            array( 'match' => '교회 소식', 'title' => '교회 소식 및 안내', 'icon' => '📢', 'slug' => 'news' ),
            array( 'match' => '기도 요청', 'title' => '기도 요청', 'icon' => '🙏', 'slug' => 'prayer' ),
            array( 'match' => '이번 주 봉사', 'title' => '이번 주 봉사', 'icon' => '🤝', 'slug' => 'service' ),
            array( 'match' => '다음 주 봉사', 'title' => '다음 주 봉사', 'icon' => '🗓️', 'slug' => 'next-service' ),
            array( 'match' => '헌금자 명단', 'title' => '헌금자 명단', 'icon' => '💰', 'slug' => 'offering' ),
        );

        foreach ( $headings as $heading ) {
            if ( false !== mb_strpos( $plain, $heading['match'] ) && mb_strlen( $plain ) <= 40 ) {
                return $heading;
            }
        }

        return null;
    }

    /**
     * 섹션 본문 줄을 문단과 목록으로 나누어 렌더링합니다.
     */
    private function render_notice_items_html( $items ) {
        $html    = '';
        $in_list = false;

        foreach ( $items as $item ) {
            $is_bullet = strpos( $item, '* ' ) === 0;
            $text      = $is_bullet ? trim( substr( $item, 2 ) ) : trim( $item );

            if ( '' === $text ) {
                continue;
            }

            if ( $is_bullet ) {
                if ( ! $in_list ) {
                    $html   .= '<ul class="gpc-notice-list">';
                    $in_list = true;
                }
                $html .= '<li>' . esc_html( $text ) . '</li>';
                continue;
            }

            if ( $in_list ) {
                $html   .= '</ul>';
                $in_list = false;
            }

            $html .= '<p>' . esc_html( $text ) . '</p>';
        }

        if ( $in_list ) {
            $html .= '</ul>';
        }

        return $html;
    }

    /**
     * KBoard 게시판 ID 저장 AJAX 핸들러
     */
    public function ajax_save_kboard_id() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }
        $kboard_id         = isset( $_POST['kboard_id'] ) ? (int) $_POST['kboard_id'] : 0;
        $kboard_archive_id = isset( $_POST['kboard_archive_id'] ) ? (int) $_POST['kboard_archive_id'] : 0;

        update_option( 'gpc_bulletin_kboard_id', $kboard_id );
        update_option( 'gpc_bulletin_kboard_archive_id', $kboard_archive_id );

        wp_send_json_success( '게시판 설정이 저장되었습니다.' );
    }

    /**
     * 주보(순서지) 데이터를 KBoard 주보 아카이브 게시판에 동기화합니다.
     *
     * @param int $bulletin_id 순서지 ID
     * @return int|false 성공 시 KBoard UID, 실패 시 false
     */
    public function sync_to_kboard_archive( $bulletin_id ) {
        $bulletin_id = (int) $bulletin_id;
        if ( $bulletin_id <= 0 ) {
            return false;
        }

        $item = $this->db->get_by_id( $bulletin_id );
        if ( ! $item ) {
            return false;
        }

        // 이미지 URL이 없으면 KBoard 아카이브에 발행하지 않거나 보류
        $image_url = isset( $item->image_url ) ? trim( $item->image_url ) : '';
        if ( empty( $image_url ) ) {
            return false;
        }

        // KBoard 아카이브 게시판 ID (기본값 4)
        $board_id = (int) get_option( 'gpc_bulletin_kboard_archive_id', 4 );

        // KBContent 클래스 로드
        if ( ! class_exists( 'KBContent' ) ) {
            $kboard_path = WP_PLUGIN_DIR . '/kboard/class/KBContent.class.php';
            if ( ! file_exists( $kboard_path ) ) {
                return false;
            }
            require_once $kboard_path;
        }

        $content_obj = new KBContent( $board_id );

        // 날짜 가독성 개선 (예: 2026-05-30 -> 2026년 05월 30일 안식일 예배 주보)
        $date_str = $item->publish_date;
        if ( ! empty( $date_str ) ) {
            $time = strtotime( $date_str );
            if ( $time ) {
                $bulletin_title = date( 'Y년 m월 d일', $time ) . ' 안식일 예배 주보';
            } else {
                $bulletin_title = $date_str . ' 안식일 예배 주보';
            }
        } else {
            $bulletin_title = '안식일 예배 주보';
        }

        // 본문 내용: 이미지를 선명하게 보여주는 HTML
        $post_content = '<div style="text-align: center; margin: 20px 0;">';
        $post_content .= '<img src="' . esc_url( $image_url ) . '" style="max-width: 100%; height: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px;" alt="' . esc_attr( $bulletin_title ) . '" />';
        $post_content .= '</div>';

        $existing_uid = (int) $item->bulletin_post_id;

        $content_data = array(
            'board_id'       => $board_id,
            'title'          => $bulletin_title,
            'content'        => $post_content,
            'member_uid'     => get_current_user_id() ? get_current_user_id() : 1,
            'member_display' => wp_get_current_user()->display_name ? wp_get_current_user()->display_name : '가평교회',
            'status'         => 'publish',
        );

        if ( $existing_uid > 0 ) {
            // 기존 글 업데이트
            $content_obj->initWithUID( $existing_uid );
            if ( ! empty( $content_obj->uid ) ) {
                $content_obj->updateContent( $content_data );
                $kboard_uid = $existing_uid;
            } else {
                $kboard_uid = $content_obj->insertContent( $content_data );
            }
        } else {
            // 신규 발행
            $kboard_uid = $content_obj->insertContent( $content_data );
        }

        if ( ! $kboard_uid ) {
            return false;
        }

        // 썸네일 등록 (KBoard 썸네일/갤러리 스킨 지원)
        $site_url = site_url();
        $relative_thumbnail = str_replace( $site_url, '', $image_url );

        global $wpdb;
        $wpdb->update(
            "{$wpdb->prefix}kboard_board_content",
            array(
                'thumbnail_file' => $relative_thumbnail,
                'thumbnail_name' => basename( $image_url ),
            ),
            array( 'uid' => $kboard_uid )
        );

        // 순서지 DB에 KBoard 아카이브 포스트 ID 업데이트
        if ( $existing_uid !== (int) $kboard_uid ) {
            $this->db->update( $bulletin_id, array( 'bulletin_post_id' => $kboard_uid ) );
        }

        // 📅 최신 주보 섹션(page-bulletin.php) 노출용 워드프레스 옵션 자동 갱신
        $table_name = $wpdb->prefix . 'gpc_bulletin';
        $latest_item = $wpdb->get_row( "SELECT * FROM {$table_name} ORDER BY publish_date DESC LIMIT 1" );
        if ( $latest_item ) {
            $latest_time = strtotime( $latest_item->publish_date );
            $latest_title = $latest_time ? date( 'Y년 m월 d일', $latest_time ) . ' 안식일 예배 주보' : $latest_item->publish_date . ' 안식일 예배 주보';

            update_option( 'gpc_bulletin_image', $latest_item->image_url );
            update_option( 'gpc_bulletin_title', $latest_title );
            update_option( 'gpc_bulletin_date', $latest_item->publish_date );
        }

        return $kboard_uid;
    }

    /**
     * AI 공지사항 내용 생성 AJAX 핸들러
     *
     * 순서지 데이터를 읽어 사용자 설정 프롬프트와 함께 AI에 전달,
     * 생성된 공지 본문을 반환합니다.
     */
    public function ajax_generate_notice_content() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        $bulletin_id = isset( $_POST['bulletin_id'] ) ? (int) $_POST['bulletin_id'] : 0;
        if ( $bulletin_id <= 0 ) {
            wp_send_json_error( '유효하지 않은 순서지 ID입니다.' );
        }

        $item = $this->db->get_by_id( $bulletin_id );
        if ( ! $item ) {
            wp_send_json_error( '순서지 데이터를 찾을 수 없습니다.' );
        }

        $prompt   = get_option( 'gpc_bulletin_notice_prompt', '' );
        $bulletin = (array) $item;
        $result   = GPC_Bulletin_AI_Extractor::generate_notice_content( $bulletin, $prompt );

        if ( $result['success'] ) {
            wp_send_json_success( array( 'content' => $result['content'] ) );
        } else {
            wp_send_json_error( $result['error'] );
        }
    }

    /**
     * AI 공지사항 작성 프롬프트 저장 AJAX 핸들러
     */
    public function ajax_save_notice_prompt() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }
        $prompt = isset( $_POST['prompt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['prompt'] ) ) : '';
        update_option( 'gpc_bulletin_notice_prompt', $prompt );
        wp_send_json_success( '프롬프트가 저장되었습니다.' );
    }

    /**
     * 과거 순서지 일괄 KBoard 동기화 AJAX 핸들러
     *
     * 이미지 URL이 있는 모든 순서지(또는 미연동 순서지)를 KBoard 아카이브에 일괄 동기화합니다.
     * 청크(chunk) 방식으로 한 번에 일정 수만 처리하여 타임아웃 방지.
     *
     * POST 파라미터:
     *   - only_unsynced : 1 = 미연동 항목만, 0 = 전체
     *   - offset        : 처리 시작 오프셋
     *   - chunk_size    : 한 번에 처리할 건수 (기본 5)
     */
    public function ajax_bulk_sync() {
        check_ajax_referer( 'gpc_bulletin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( '권한이 없습니다.' );
        }

        global $wpdb;
        $table_name   = $wpdb->prefix . 'gpc_bulletin';
        $only_unsynced = isset( $_POST['only_unsynced'] ) ? (int) $_POST['only_unsynced'] : 1;
        $offset        = isset( $_POST['offset'] )        ? (int) $_POST['offset']        : 0;
        $chunk_size    = isset( $_POST['chunk_size'] )    ? (int) $_POST['chunk_size']    : 5;

        // 안전 범위 제한
        if ( $chunk_size < 1 )  { $chunk_size = 1; }
        if ( $chunk_size > 20 ) { $chunk_size = 20; }

        // 총 대상 수 카운트
        if ( $only_unsynced ) {
            $total = (int) $wpdb->get_var(
                "SELECT COUNT(*) FROM {$table_name}
                  WHERE image_url != '' AND image_url IS NOT NULL
                    AND (bulletin_post_id IS NULL OR bulletin_post_id = 0)"
            );
        } else {
            $total = (int) $wpdb->get_var(
                "SELECT COUNT(*) FROM {$table_name}
                  WHERE image_url != '' AND image_url IS NOT NULL"
            );
        }

        if ( $total === 0 ) {
            wp_send_json_success( array(
                'done'        => true,
                'total'       => 0,
                'processed'   => 0,
                'success'     => 0,
                'fail'        => 0,
                'message'     => '동기화할 항목이 없습니다.',
            ) );
            return;
        }

        // 청크 항목 가져오기
        if ( $only_unsynced ) {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT id FROM {$table_name}
                  WHERE image_url != '' AND image_url IS NOT NULL
                    AND (bulletin_post_id IS NULL OR bulletin_post_id = 0)
                  ORDER BY publish_date DESC
                  LIMIT %d OFFSET %d",
                $chunk_size, $offset
            ) );
        } else {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT id FROM {$table_name}
                  WHERE image_url != '' AND image_url IS NOT NULL
                  ORDER BY publish_date DESC
                  LIMIT %d OFFSET %d",
                $chunk_size, $offset
            ) );
        }

        $success_count = 0;
        $fail_count    = 0;

        foreach ( $items as $item ) {
            $result = $this->sync_to_kboard_archive( (int) $item->id );
            if ( $result ) {
                $success_count++;
            } else {
                $fail_count++;
            }
        }

        $processed_so_far = $offset + count( $items );
        $is_done          = ( $processed_so_far >= $total );

        wp_send_json_success( array(
            'done'      => $is_done,
            'total'     => $total,
            'processed' => $processed_so_far,
            'success'   => $success_count,
            'fail'      => $fail_count,
            'next_offset' => $processed_so_far,
            'message'   => $is_done
                ? "총 {$total}건 중 {$success_count}건 동기화 완료" . ( $fail_count > 0 ? " ({$fail_count}건 실패)" : '' )
                : "{$processed_so_far}/{$total} 처리 중...",
        ) );
    }
}
