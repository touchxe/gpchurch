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
        add_action( 'wp_ajax_gpc_bulletin_test_api', array( $this, 'ajax_test_api' ) );
        add_action( 'wp_ajax_gpc_bulletin_save_settings', array( $this, 'ajax_save_settings' ) );
        add_action( 'wp_ajax_gpc_bulletin_extract', array( $this, 'ajax_extract' ) );
        add_action( 'wp_ajax_gpc_bulletin_save', array( $this, 'ajax_save' ) );
        add_action( 'wp_ajax_gpc_bulletin_delete', array( $this, 'ajax_delete' ) );

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
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'gpc_bulletin_nonce' ),
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
        foreach ( $columns as $col ) {
            if ( isset( $_POST[ $col ] ) ) {
                $data[ $col ] = sanitize_textarea_field( wp_unslash( $_POST[ $col ] ) );
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
                wp_send_json_success( array( 'message' => '순서지가 수정되었습니다.', 'id' => $id ) );
            } else {
                wp_send_json_error( '수정에 실패했습니다.' );
            }
        } else {
            $existing = $this->db->get_by_date( $data['publish_date'] );
            if ( $existing ) {
                $success = $this->db->update( $existing->id, $data );
                if ( $success ) {
                    wp_send_json_success( array( 'message' => '같은 날짜의 기존 순서지를 업데이트했습니다.', 'id' => $existing->id ) );
                } else {
                    wp_send_json_error( '업데이트에 실패했습니다.' );
                }
            } else {
                $new_id = $this->db->insert( $data );
                if ( $new_id ) {
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

        $success = $this->db->delete( $id );
        if ( $success ) {
            wp_send_json_success( '삭제되었습니다.' );
        } else {
            wp_send_json_error( '삭제에 실패했습니다.' );
        }
    }
}
