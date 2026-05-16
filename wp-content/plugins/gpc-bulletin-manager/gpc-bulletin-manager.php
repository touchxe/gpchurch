<?php
/**
 * Plugin Name: 가평교회 순서지 관리
 * Plugin URI:  https://github.com/touchxe/gpchurch
 * Description: 교회 순서지(주보) 이미지를 AI로 분석하여 데이터를 추출하고 DB에 저장·관리하는 플러그인
 * Version:     1.0.0
 * Author:      가평교회 디지털팀
 * Author URI:  https://sdagp.kr
 * Text Domain: gpc-bulletin
 * Domain Path: /languages
 * Requires at least: 5.9
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ── 플러그인 상수 ── */
define( 'GPC_BULLETIN_VERSION', '1.0.0' );
define( 'GPC_BULLETIN_FILE',    __FILE__ );
define( 'GPC_BULLETIN_DIR',     plugin_dir_path( __FILE__ ) );
define( 'GPC_BULLETIN_URL',     plugin_dir_url( __FILE__ ) );

/* ── 클래스 로드 ── */
require_once GPC_BULLETIN_DIR . 'includes/class-bulletin-db.php';
require_once GPC_BULLETIN_DIR . 'includes/class-bulletin-ai-extractor.php';
require_once GPC_BULLETIN_DIR . 'includes/class-bulletin-admin.php';

/* ── 플러그인 활성화 시 테이블 생성 ── */
register_activation_hook( __FILE__, function () {
    $db = new GPC_Bulletin_DB();
    $db->create_table();
} );

/* ── 관리자 패널에서만 Admin 클래스 초기화 ── */
if ( is_admin() ) {
    new GPC_Bulletin_Admin();
}
