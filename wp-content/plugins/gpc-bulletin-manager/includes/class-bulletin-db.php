<?php
/**
 * 순서지(주보) 데이터 DB 관리 클래스
 *
 * wp_gpc_bulletin 커스텀 테이블 생성 및 CRUD 메서드 제공
 *
 * @package GapyeongChurchChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GPC_Bulletin_DB {

    /** @var string 테이블 이름 (prefix 포함) */
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'gpc_bulletin';
    }

    /**
     * 테이블 생성 (테마 활성화 시 호출)
     */
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            publish_date date NOT NULL,
            sabbath_type varchar(100) DEFAULT '',
            sunset_time varchar(20) DEFAULT '',
            ss_host varchar(50) DEFAULT '',
            ss_hymn varchar(50) DEFAULT '',
            ss_prayer varchar(50) DEFAULT '',
            ss_welcome varchar(50) DEFAULT '',
            ss_special_song varchar(100) DEFAULT '',
            ss_special_order varchar(100) DEFAULT '',
            ss_lesson_title varchar(200) DEFAULT '',
            ws_host varchar(50) DEFAULT '',
            ws_doxology varchar(50) DEFAULT '',
            ws_invocation varchar(50) DEFAULT '',
            ws_responsive_reading varchar(100) DEFAULT '',
            ws_hymn varchar(50) DEFAULT '',
            ws_prayer varchar(50) DEFAULT '',
            ws_offering_leader varchar(50) DEFAULT '',
            ws_offering_hymn varchar(50) DEFAULT '',
            ws_offering_benediction varchar(50) DEFAULT '',
            ws_special_song varchar(100) DEFAULT '',
            ws_sermon_title varchar(200) DEFAULT '',
            ws_preacher varchar(50) DEFAULT '',
            ws_bible_text varchar(200) DEFAULT '',
            ws_closing_hymn varchar(50) DEFAULT '',
            ws_benediction varchar(50) DEFAULT '',
            church_news text,
            offering_list text,
            prayer_requests text,
            service_this_week text,
            service_next_week text,
            memory_verse text,
            announcements text,
            image_url varchar(500) DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY publish_date (publish_date)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * 데이터 컬럼 목록 (메타 컬럼 제외)
     *
     * @return array 컬럼명 배열
     */
    public static function get_data_columns() {
        return array(
            'publish_date',
            'sabbath_type',
            'sunset_time',
            // 안식일 학교
            'ss_host',
            'ss_hymn',
            'ss_prayer',
            'ss_welcome',
            'ss_special_song',
            'ss_special_order',
            'ss_lesson_title',
            // 안식일 예배
            'ws_host',
            'ws_doxology',
            'ws_invocation',
            'ws_responsive_reading',
            'ws_hymn',
            'ws_prayer',
            'ws_offering_leader',
            'ws_offering_hymn',
            'ws_offering_benediction',
            'ws_special_song',
            'ws_sermon_title',
            'ws_preacher',
            'ws_bible_text',
            'ws_closing_hymn',
            'ws_benediction',
            // 텍스트 영역
            'church_news',
            'offering_list',
            'prayer_requests',
            'service_this_week',
            'service_next_week',
            'memory_verse',
            'announcements',
            // 이미지
            'image_url',
        );
    }

    /**
     * 컬럼별 한국어 라벨
     *
     * @return array key => label
     */
    public static function get_column_labels() {
        return array(
            'publish_date'           => '발행 날짜',
            'sabbath_type'           => '안식일 구분',
            'sunset_time'            => '일몰 시각',
            'ss_host'                => '안교 진행',
            'ss_hymn'                => '안교 찬미',
            'ss_prayer'              => '안교 기도',
            'ss_welcome'             => '환영사',
            'ss_special_song'        => '안교 특순 진행자',
            'ss_special_order'       => '안교 특순',
            'ss_lesson_title'        => '교과 제목',
            'ws_host'                => '예배 인도',
            'ws_doxology'            => '송영',
            'ws_invocation'          => '기원',
            'ws_responsive_reading'  => '교독문',
            'ws_hymn'                => '예배 찬미',
            'ws_prayer'              => '대표 기도',
            'ws_offering_leader'     => '헌금 담당',
            'ws_offering_hymn'       => '헌금 찬미',
            'ws_offering_benediction'=> '헌금 축도',
            'ws_special_song'        => '예배 특창',
            'ws_sermon_title'        => '설교 제목',
            'ws_preacher'            => '설교자',
            'ws_bible_text'          => '성경 본문',
            'ws_closing_hymn'        => '폐회 찬미',
            'ws_benediction'         => '축도',
            'church_news'            => '교회 소식',
            'offering_list'          => '헌금자 명단',
            'prayer_requests'        => '기도 요청',
            'service_this_week'      => '이번 주 봉사',
            'service_next_week'      => '다음 주 봉사',
            'memory_verse'           => '기억절',
            'announcements'          => '광고 및 공지',
            'image_url'              => '원본 이미지',
        );
    }

    /**
     * TEXT 타입 컬럼 목록 (textarea 로 렌더링할 필드)
     *
     * @return array
     */
    public static function get_text_columns() {
        return array(
            'church_news',
            'offering_list',
            'prayer_requests',
            'service_this_week',
            'service_next_week',
            'memory_verse',
            'announcements',
        );
    }

    /**
     * 새 순서지 데이터 삽입
     *
     * @param  array    $data  컬럼 => 값
     * @return int|false       삽입된 ID 또는 false
     */
    public function insert( $data ) {
        global $wpdb;

        $allowed = self::get_data_columns();
        $filtered = array();
        foreach ( $allowed as $col ) {
            if ( isset( $data[ $col ] ) ) {
                $filtered[ $col ] = $data[ $col ];
            }
        }

        $result = $wpdb->insert( $this->table_name, $filtered );
        return $result ? $wpdb->insert_id : false;
    }

    /**
     * 기존 데이터 업데이트
     *
     * @param  int   $id    레코드 ID
     * @param  array $data  컬럼 => 값
     * @return bool
     */
    public function update( $id, $data ) {
        global $wpdb;

        $allowed = self::get_data_columns();
        $filtered = array();
        foreach ( $allowed as $col ) {
            if ( isset( $data[ $col ] ) ) {
                $filtered[ $col ] = $data[ $col ];
            }
        }

        $result = $wpdb->update(
            $this->table_name,
            $filtered,
            array( 'id' => (int) $id )
        );
        return false !== $result;
    }

    /**
     * ID로 단건 조회
     *
     * @param  int        $id
     * @return object|null
     */
    public function get_by_id( $id ) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                (int) $id
            )
        );
    }

    /**
     * 날짜로 조회 (중복 체크용)
     *
     * @param  string      $date  Y-m-d
     * @return object|null
     */
    public function get_by_date( $date ) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE publish_date = %s",
                $date
            )
        );
    }

    /**
     * 전체 목록 조회 (페이지네이션)
     *
     * @param  int   $page      현재 페이지 (1부터)
     * @param  int   $per_page  페이지당 항목 수
     * @param  string $search   검색어 (설교자, 설교제목)
     * @return array  [ 'items' => [...], 'total' => int ]
     */
    public function get_all( $page = 1, $per_page = 20, $search = '' ) {
        global $wpdb;

        $offset = ( $page - 1 ) * $per_page;
        $where = '';

        if ( ! empty( $search ) ) {
            $like = '%' . $wpdb->esc_like( $search ) . '%';
            $where = $wpdb->prepare(
                " WHERE ws_preacher LIKE %s OR ws_sermon_title LIKE %s OR sabbath_type LIKE %s",
                $like, $like, $like
            );
        }

        $total = (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->table_name}{$where}"
        );

        $items = $wpdb->get_results(
            "SELECT * FROM {$this->table_name}{$where} ORDER BY publish_date DESC LIMIT {$per_page} OFFSET {$offset}"
        );

        return array(
            'items' => $items,
            'total' => $total,
        );
    }

    /**
     * 삭제
     *
     * @param  int  $id
     * @return bool
     */
    public function delete( $id ) {
        global $wpdb;
        $result = $wpdb->delete(
            $this->table_name,
            array( 'id' => (int) $id )
        );
        return false !== $result;
    }
}
