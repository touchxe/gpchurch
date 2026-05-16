<?php
/**
 * 순서지(주보) AI 추출 클래스
 *
 * 관리자 설정 페이지에서 저장된 API URL/Key/모델명을 사용하여
 * 이미지에서 순서지 데이터를 JSON으로 추출합니다.
 *
 * @package GapyeongChurchChild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GPC_Bulletin_AI_Extractor {

    /** @var string wp_options 키 접두어 */
    const OPTION_PREFIX = 'gpc_bulletin_ai_';

    /**
     * 저장된 API 설정 가져오기
     *
     * @return array [ 'api_url', 'api_key', 'model' ]
     */
    public static function get_settings() {
        return array(
            'api_url' => get_option( self::OPTION_PREFIX . 'api_url', 'https://api.minimax.io/v1/chat/completions' ),
            'api_key' => get_option( self::OPTION_PREFIX . 'api_key', '' ),
            'model'   => get_option( self::OPTION_PREFIX . 'model', 'MiniMax-M2.5' ),
        );
    }

    /**
     * API 설정 저장
     *
     * @param string $api_url
     * @param string $api_key
     * @param string $model
     */
    public static function save_settings( $api_url, $api_key, $model ) {
        update_option( self::OPTION_PREFIX . 'api_url', sanitize_url( $api_url ) );
        update_option( self::OPTION_PREFIX . 'api_key', sanitize_text_field( $api_key ) );
        update_option( self::OPTION_PREFIX . 'model', sanitize_text_field( $model ) );
    }

    /**
     * API 연결 테스트
     *
     * 간단한 텍스트 메시지를 보내 응답 여부를 확인합니다.
     *
     * @return array [ 'success' => bool, 'message' => string, 'response_time' => float ]
     */
    public static function test_connection() {
        $settings = self::get_settings();

        if ( empty( $settings['api_key'] ) ) {
            return array(
                'success'       => false,
                'message'       => 'API Key가 설정되지 않았습니다.',
                'response_time' => 0,
            );
        }

        $start_time = microtime( true );

        $body = wp_json_encode( array(
            'model'    => $settings['model'],
            'messages' => array(
                array(
                    'role'    => 'user',
                    'content' => '안녕하세요. 연결 테스트입니다. "연결 성공"이라고 답해주세요.',
                ),
            ),
            'max_tokens' => 20,
        ) );

        $response = wp_remote_post( $settings['api_url'], array(
            'timeout' => 30,
            'headers' => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $settings['api_key'],
            ),
            'body' => $body,
        ) );

        $elapsed = round( microtime( true ) - $start_time, 2 );

        if ( is_wp_error( $response ) ) {
            return array(
                'success'       => false,
                'message'       => '네트워크 오류: ' . $response->get_error_message(),
                'response_time' => $elapsed,
            );
        }

        $code = wp_remote_retrieve_response_code( $response );
        $body_raw = wp_remote_retrieve_body( $response );

        if ( $code !== 200 ) {
            $error_data = json_decode( $body_raw, true );
            $error_msg  = isset( $error_data['error']['message'] )
                ? $error_data['error']['message']
                : "HTTP {$code} 응답";
            return array(
                'success'       => false,
                'message'       => 'API 오류: ' . $error_msg,
                'response_time' => $elapsed,
            );
        }

        return array(
            'success'       => true,
            'message'       => '연결 성공',
            'response_time' => $elapsed,
        );
    }

    /**
     * 순서지 이미지에서 데이터 추출
     *
     * @param  string $image_path  로컬 이미지 파일 경로 또는 URL
     * @return array  [ 'success' => bool, 'data' => array|null, 'error' => string ]
     */
    public static function extract_from_image( $image_path ) {
        $settings = self::get_settings();

        if ( empty( $settings['api_key'] ) ) {
            return array(
                'success' => false,
                'data'    => null,
                'error'   => 'API Key가 설정되지 않았습니다. 설정 페이지에서 입력해주세요.',
            );
        }

        // 이미지를 base64로 인코딩
        if ( filter_var( $image_path, FILTER_VALIDATE_URL ) ) {
            $tmp = download_url( $image_path, 30 );
            if ( is_wp_error( $tmp ) ) {
                return array(
                    'success' => false,
                    'data'    => null,
                    'error'   => '이미지 다운로드 실패: ' . $tmp->get_error_message(),
                );
            }
            $image_data = file_get_contents( $tmp );
            @unlink( $tmp );
        } else {
            if ( ! file_exists( $image_path ) ) {
                return array(
                    'success' => false,
                    'data'    => null,
                    'error'   => '이미지 파일을 찾을 수 없습니다: ' . $image_path,
                );
            }
            $image_data = file_get_contents( $image_path );
        }

        if ( empty( $image_data ) ) {
            return array(
                'success' => false,
                'data'    => null,
                'error'   => '이미지 파일이 비어 있습니다.',
            );
        }

        // MIME 타입 감지
        $mime = 'image/jpeg';
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        if ( is_string( $image_path ) && file_exists( $image_path ) ) {
            $detected = finfo_file( $finfo, $image_path );
            if ( $detected ) {
                $mime = $detected;
            }
        }
        finfo_close( $finfo );

        // 이미지 크기 최적화: 너무 큰 이미지는 리사이즈 (5MB 이상)
        $image_size = strlen( $image_data );
        if ( $image_size > 5 * 1024 * 1024 ) {
            $resized = self::resize_image( $image_path, 2048 );
            if ( $resized ) {
                $image_data = $resized;
                $mime = 'image/jpeg';
            }
        }

        $base64   = base64_encode( $image_data );
        $data_uri = "data:{$mime};base64,{$base64}";

        // 추출 프롬프트
        $prompt = self::get_extraction_prompt();

        $request_body = array(
            'model'    => $settings['model'],
            'messages' => array(
                array(
                    'role'    => 'user',
                    'content' => array(
                        array(
                            'type' => 'text',
                            'text' => $prompt,
                        ),
                        array(
                            'type'      => 'image_url',
                            'image_url' => array(
                                'url' => $data_uri,
                            ),
                        ),
                    ),
                ),
            ),
            'max_tokens'  => 16384,
            'temperature' => 0.1,
        );

        $body_json = wp_json_encode( $request_body );

        if ( false === $body_json ) {
            return array(
                'success' => false,
                'data'    => null,
                'error'   => 'JSON 인코딩 실패. 이미지 크기: ' . size_format( $image_size ),
            );
        }

        // 디버그 로그
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] API 요청 - 모델: ' . $settings['model'] . ', 이미지 크기: ' . size_format( $image_size ) . ', 요청 바디 크기: ' . size_format( strlen( $body_json ) ) );
        }

        $response = wp_remote_post( $settings['api_url'], array(
            'timeout'  => 120,
            'headers'  => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $settings['api_key'],
            ),
            'body'     => $body_json,
            'data_format' => 'body',
        ) );

        if ( is_wp_error( $response ) ) {
            return array(
                'success' => false,
                'data'    => null,
                'error'   => '네트워크 오류: ' . $response->get_error_message(),
            );
        }

        $code     = wp_remote_retrieve_response_code( $response );
        $body_raw = wp_remote_retrieve_body( $response );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] API 응답 - HTTP ' . $code . ', 응답 크기: ' . size_format( strlen( $body_raw ) ) );
        }

        if ( $code !== 200 ) {
            $error_data = json_decode( $body_raw, true );
            $error_msg  = isset( $error_data['error']['message'] )
                ? $error_data['error']['message']
                : "HTTP {$code}";
            return array(
                'success' => false,
                'data'    => null,
                'error'   => 'API 오류: ' . $error_msg,
            );
        }

        $result = json_decode( $body_raw, true );

        // 응답이 잘렸는지(finish_reason) 체크
        $finish_reason = isset( $result['choices'][0]['finish_reason'] )
            ? $result['choices'][0]['finish_reason']
            : 'unknown';

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] finish_reason: ' . $finish_reason );
        }

        // AI 응답에서 content 추출
        $content = '';
        if ( isset( $result['choices'][0]['message']['content'] ) ) {
            $content = $result['choices'][0]['message']['content'];
        }

        if ( empty( $content ) ) {
            return array(
                'success' => false,
                'data'    => null,
                'error'   => 'AI가 빈 응답을 반환했습니다.',
            );
        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] AI 원본 응답 길이: ' . strlen( $content ) . ' bytes' );
            error_log( '[GPC Bulletin] AI 원본 응답 (앞 200자): ' . mb_substr( $content, 0, 200 ) );
        }

        // <think>...</think> 태그 제거 (thinking/reasoning 모델 호환)
        $content = self::strip_thinking_tags( $content );

        // JSON 블록 추출 (```json ... ``` 또는 순수 JSON)
        if ( preg_match( '/```(?:json)?\s*([\s\S]*?)\s*```/s', $content, $matches ) ) {
            $json_str = $matches[1];
        } elseif ( preg_match( '/\{[\s\S]*\}/s', $content, $matches ) ) {
            $json_str = $matches[0];
        } else {
            $json_str = $content;
        }

        $json_str = trim( $json_str );

        // [안전장치] JSON 문자열 값 내부의 실제 개행 문자를 이스케이프 처리
        // "키": "값 내부에\n실제 개행" → "키": "값 내부에\\n실제 개행"
        $json_str = self::fix_json_newlines( $json_str );

        $extracted = json_decode( $json_str, true );

        // JSON 파싱 실패 시 잘린 JSON 복구 시도
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( '[GPC Bulletin] 첫 json_decode 실패: ' . json_last_error_msg() );
                error_log( '[GPC Bulletin] finish_reason: ' . $finish_reason );
            }

            // 응답이 잘린 경우(length/max_tokens) 복구 시도
            $repaired = self::repair_truncated_json( $json_str );
            if ( $repaired ) {
                $extracted = json_decode( $repaired, true );
            }
        }

        if ( json_last_error() !== JSON_ERROR_NONE ) {
            $preview = mb_substr( $content, 0, 500 );
            return array(
                'success' => false,
                'data'    => null,
                'error'   => 'AI 응답 JSON 파싱 실패: ' . json_last_error_msg()
                    . ( $finish_reason === 'length' ? "\n⚠️ 응답이 토큰 제한으로 잘렸습니다." : '' )
                    . "\n\n원본 응답 (앞 500자):\n" . $preview,
            );
        }

        // AI가 규칙을 어겼더라도 안전하게 정규화 (이름 공백/괄호 찬미/일몰시각)
        $extracted = self::normalize_extracted_data( $extracted );

        return array(
            'success' => true,
            'data'    => $extracted,
            'error'   => '',
        );
    }

    /**
     * 저장 시점에도 호출 가능한 정규화 래퍼
     *
     * 폼에서 사용자가 수정 후 저장할 때도 동일 정규화를 적용해
     * 한글 사이 공백/괄호 찬미/별표 일몰시각이 DB에 들어가지 않도록 보장.
     */
    public static function normalize_for_save( $data ) {
        return self::normalize_extracted_data( $data );
    }

    /**
     * AI 추출 결과 후처리 정규화
     *
     * 프롬프트 규칙을 AI가 어긴 경우에도 결정적인 정리를 강제합니다.
     * - 인명 필드: 글자 사이 공백 제거
     * - 찬미/송영 필드: 괄호 및 내부 공백 제거 → "?장"
     * - 일몰시각: `*` 제거, pm/am → 오후/오전
     *
     * @param  array $data 추출된 데이터
     * @return array       정규화된 데이터
     */
    private static function normalize_extracted_data( $data ) {
        if ( ! is_array( $data ) ) {
            return $data;
        }

        $name_fields = array(
            'ss_host', 'ss_prayer', 'ss_welcome', 'ss_special_song',
            'ws_host', 'ws_invocation', 'ws_prayer',
            'ws_offering_leader', 'ws_offering_benediction',
            'ws_preacher', 'ws_benediction',
        );
        foreach ( $name_fields as $f ) {
            if ( isset( $data[ $f ] ) ) {
                $data[ $f ] = self::normalize_korean_name( $data[ $f ] );
            }
        }

        $hymn_fields = array(
            'ss_hymn', 'ws_doxology', 'ws_hymn',
            'ws_offering_hymn', 'ws_closing_hymn',
        );
        foreach ( $hymn_fields as $f ) {
            if ( isset( $data[ $f ] ) ) {
                $data[ $f ] = self::normalize_hymn( $data[ $f ] );
            }
        }

        if ( isset( $data['sunset_time'] ) ) {
            $data['sunset_time'] = self::normalize_sunset_time( $data['sunset_time'] );
        }

        return $data;
    }

    /**
     * 한글 인명 공백 제거
     *
     * 두 한글 글자 사이의 모든 공백(일반 스페이스, 전각 공백, NBSP 등 유니코드 공백 포함)을 제거.
     *  "심 재 영"           → "심재영"
     *  "심재영, 김 한 나"   → "심재영, 김한나"
     *  "홍 길 동 (장로)"    → "홍길동 (장로)"  (괄호 앞 공백은 보존)
     *  "John Smith"         → "John Smith"      (한글 사이 공백이 아니므로 변경 없음)
     */
    private static function normalize_korean_name( $value ) {
        if ( ! is_string( $value ) ) {
            return $value;
        }
        $value = trim( $value );
        if ( '' === $value ) {
            return '';
        }

        // 콤마/슬래시/가운뎃점 등 다중 이름 구분자로 분리
        $parts = preg_split( '/\s*[,，、·•・\/]\s*/u', $value );
        $out   = array();
        foreach ( $parts as $part ) {
            $part = trim( $part );
            if ( '' === $part ) {
                continue;
            }

            // [핵심] 두 한글 글자 사이의 공백(유니코드 공백 모두 포함) 제거
            // \p{Z}: 모든 유니코드 공백 분리자 (전각공백 U+3000, NBSP U+00A0 등)
            // \s   : ASCII 공백 (스페이스/탭/개행)
            // 한글-공백-한글 패턴을 반복적으로 적용 (preg_replace 한 번으로 모두 처리됨)
            $part = preg_replace(
                '/([\x{AC00}-\x{D7A3}])[\s\p{Z}]+(?=[\x{AC00}-\x{D7A3}])/u',
                '$1',
                $part
            );

            $out[] = $part;
        }
        return implode( ', ', $out );
    }

    /**
     * 찬미/송영 장수 정규화
     *
     * "( 28장 )" → "28장",  "(2장)" → "2장",  "82장" → "82장"
     */
    private static function normalize_hymn( $value ) {
        if ( ! is_string( $value ) ) {
            return $value;
        }
        $value = trim( $value );
        if ( '' === $value ) {
            return '';
        }
        // 외곽 괄호 제거 (전각/반각 모두)
        if ( preg_match( '/^[\(\（]\s*(.+?)\s*[\)\）]$/u', $value, $m ) ) {
            $value = $m[1];
        }
        // 내부 공백 모두 제거
        $value = preg_replace( '/\s+/u', '', $value );
        return $value;
    }

    /**
     * 일몰시각 정규화
     *
     * "*일몰pm7:35*" → "오후 7:35"
     * "am6:20"       → "오전 6:20"
     */
    private static function normalize_sunset_time( $value ) {
        if ( ! is_string( $value ) ) {
            return $value;
        }
        $value = trim( $value );
        if ( '' === $value ) {
            return '';
        }
        // 별표 및 콜론 형태 별표 제거
        $value = str_replace( array( '*', '＊' ), '', $value );
        // "일몰" 라벨 제거
        $value = preg_replace( '/일몰\s*/u', '', $value );
        // pm/am 한글 변환 (대소문자 무관)
        $value = preg_replace( '/\s*p\.?m\.?\s*/iu', '오후 ', $value );
        $value = preg_replace( '/\s*a\.?m\.?\s*/iu', '오전 ', $value );
        // 공백 정리
        $value = preg_replace( '/\s+/u', ' ', $value );
        return trim( $value );
    }

    /**
     * <think>...</think> 태그 제거
     *
     * Thinking/Reasoning 모델(DeepSeek, MiniMax 등)이 출력하는
     * 내부 추론 과정을 제거하고 실제 응답만 반환합니다.
     *
     * @param  string $content AI 원본 응답
     * @return string          thinking 태그가 제거된 응답
     */
    private static function strip_thinking_tags( $content ) {
        $cleaned = preg_replace( '/<think>[\s\S]*?<\/think>/i', '', $content );
        $cleaned = preg_replace( '/<reasoning>[\s\S]*?<\/reasoning>/i', '', $cleaned );
        return trim( $cleaned );
    }

    /**
     * JSON 문자열 값 내부의 실제 개행 문자를 이스케이프 처리
     *
     * AI가 JSON 값 안에 실제 줄바꿈(Enter)을 넣으면 json_decode가 실패하므로,
     * 큰따옴표 내부의 개행을 \\n 으로 치환합니다.
     *
     * @param  string $json_str JSON 문자열
     * @return string           개행이 이스케이프된 JSON 문자열
     */
    private static function fix_json_newlines( $json_str ) {
        $result = '';
        $in_string = false;
        $escape_next = false;
        $len = strlen( $json_str );

        for ( $i = 0; $i < $len; $i++ ) {
            $char = $json_str[$i];

            if ( $escape_next ) {
                $result .= $char;
                $escape_next = false;
                continue;
            }

            if ( $char === '\\' && $in_string ) {
                $result .= $char;
                $escape_next = true;
                continue;
            }

            if ( $char === '"' ) {
                $in_string = ! $in_string;
                $result .= $char;
                continue;
            }

            // 문자열 내부의 개행 문자를 이스케이프
            if ( $in_string && ( $char === "\n" || $char === "\r" ) ) {
                if ( $char === "\r" && $i + 1 < $len && $json_str[$i + 1] === "\n" ) {
                    $i++; // \r\n을 한 번에 처리
                }
                $result .= '\\n';
                continue;
            }

            // 문자열 내부의 탭 문자를 이스케이프
            if ( $in_string && $char === "\t" ) {
                $result .= '\\t';
                continue;
            }

            $result .= $char;
        }

        return $result;
    }

    /**
     * 잘린 JSON 복구 시도
     *
     * AI 응답이 max_tokens 제한으로 잘린 경우, 
     * 누락된 필드는 빈 문자열로 채우고 괄호를 닫아 유효한 JSON으로 만듭니다.
     *
     * @param  string      $json_str 잘린 JSON 문자열
     * @return string|false          복구된 JSON 문자열 또는 false
     */
    private static function repair_truncated_json( $json_str ) {
        // 이미 유효한 JSON이면 그대로 반환
        $test = json_decode( $json_str, true );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            return $json_str;
        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] 잘린 JSON 복구 시도...' );
        }

        $repaired = $json_str;

        // 마지막 완전한 "key": "value" 쌍 이후를 잘라냄
        // 마지막으로 완전히 닫힌 큰따옴표 쌍 찾기
        $last_complete = strrpos( $repaired, '",');
        $last_complete2 = strrpos( $repaired, '"');

        if ( $last_complete !== false ) {
            // 마지막 완전한 key-value 쌍까지만 유지
            $repaired = substr( $repaired, 0, $last_complete + 1 );
        } elseif ( $last_complete2 !== false ) {
            $repaired = substr( $repaired, 0, $last_complete2 + 1 );
        }

        // 열린 중괄호 닫기
        $open_braces = substr_count( $repaired, '{' ) - substr_count( $repaired, '}' );
        for ( $i = 0; $i < $open_braces; $i++ ) {
            $repaired .= "\n}";
        }

        // 개행 문자 수정 후 다시 시도
        $repaired = self::fix_json_newlines( $repaired );

        $test = json_decode( $repaired, true );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( '[GPC Bulletin] 잘린 JSON 복구 성공! 키 수: ' . count( $test ) );
            }
            return $repaired;
        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( '[GPC Bulletin] JSON 복구 실패: ' . json_last_error_msg() );
        }

        return false;
    }

    /**
     * 이미지 리사이즈 (너무 큰 이미지 최적화)
     *
     * @param  string      $image_path  이미지 파일 경로
     * @param  int         $max_width   최대 너비
     * @return string|false             리사이즈된 이미지 데이터 또는 false
     */
    private static function resize_image( $image_path, $max_width = 2048 ) {
        $editor = wp_get_image_editor( $image_path );
        if ( is_wp_error( $editor ) ) {
            return false;
        }

        $size = $editor->get_size();
        if ( $size['width'] > $max_width ) {
            $editor->resize( $max_width, null, false );
        }
        $editor->set_quality( 85 );

        $tmp_file = wp_tempnam( 'gpc_bulletin_' );
        $saved = $editor->save( $tmp_file, 'image/jpeg' );

        if ( is_wp_error( $saved ) ) {
            @unlink( $tmp_file );
            return false;
        }

        $data = file_get_contents( $saved['path'] );
        @unlink( $saved['path'] );
        return $data;
    }

    /**
     * 추출 프롬프트 (33개 필드 JSON 형식)
     *
     * @return string
     */
    private static function get_extraction_prompt() {
        return <<<'PROMPT'
이 이미지는 한국 SDA(제칠일안식일예수재림교회) 가평교회의 주간 순서지(주보)입니다.
아래 JSON 키에 해당하는 모든 항목을 이미지에서 정확히 추출해 주세요.

규칙:
1. 값이 없거나 읽을 수 없는 항목은 빈 문자열("")로 반환하세요.
2. 날짜는 "YYYY-MM-DD" 형식으로 반환하세요.

3. **인명(사람 이름)은 글자 사이의 공백을 모두 제거하세요.**
   - 예: "홍 길 동" → "홍길동", "심 재 영" → "심재영", "김 한 나" → "김한나"
   - 적용 필드: ss_host, ss_prayer, ss_welcome, ss_special_song, ws_host, ws_invocation, ws_prayer, ws_offering_leader, ws_offering_benediction, ws_preacher, ws_benediction
   - 여러 명이 콤마로 구분된 경우(예: "홍길동, 김철수")는 콤마는 유지하고 각 이름 내부의 공백만 제거하세요.

4. **찬미/송영 장수는 괄호와 내부 공백을 모두 제거하고 "?장" 형식으로 반환하세요.**
   - 예: "( 28장 )" → "28장", "(2장)" → "2장", "( 84장 )" → "84장", "(215장)" → "215장"
   - 적용 필드: ss_hymn, ws_doxology, ws_hymn, ws_offering_hymn, ws_closing_hymn

5. **일몰시각(sunset_time)은 별표(`*`) 및 "일몰" 라벨을 제거하고, 영문 시간 표기를 한글로 변환하세요.**
   - "pm" / "PM" → "오후",  "am" / "AM" → "오전"
   - 예: "*일몰pm7:35*" → "오후 7:35"
   - 예: "am6:20" → "오전 6:20"

6. **안교 특순 진행자(ss_special_song)의 기준:**
   - 안교 특순(ss_special_order)을 진행/담당하는 사람의 이름을 넣으세요.
   - 인명이므로 규칙 3(공백 제거)을 동일하게 적용하세요.
   - 진행자가 표기되어 있지 않으면 빈 문자열("")을 반환하세요.

7. **안교 특순(ss_special_order)의 기준:**
   - 안식일학교 영역에서 점선(------ 또는 ‒‒‒‒‒‒)으로 둘러싸인 별도 안내 영역의 중앙에 단독으로 적힌 텍스트(특순의 제목/내용)만 ss_special_order에 넣으세요.
   - 일반 예배 순서표 행 안에 있는 항목은 ss_special_order가 아닙니다.
   - 점선으로 둘러싸인 안내가 없으면 빈 문자열("")을 반환하세요.

8. 교독문은 "856 어린이 (막10:13-16)" 같이 번호와 제목을 함께 반환하세요.

9. 긴 텍스트(교회 소식 등)에서 줄바꿈이 필요할 때는 **절대로 실제 줄바꿈(Enter)을 사용하지 말고**, 반드시 이스케이프된 문자열 `\n` 기호를 그대로 입력하세요.
10. 반드시 유효한 JSON만 반환하세요. 추가 설명이나 생각 과정 없이 JSON만 출력하세요.
11. <think> 태그나 추론 과정을 출력하지 마세요. JSON만 반환하세요.

```json
{
  "publish_date": "",
  "sabbath_type": "",
  "sunset_time": "",
  "ss_host": "",
  "ss_hymn": "",
  "ss_prayer": "",
  "ss_welcome": "",
  "ss_special_song": "",
  "ss_special_order": "",
  "ss_lesson_title": "",
  "ws_host": "",
  "ws_doxology": "",
  "ws_invocation": "",
  "ws_responsive_reading": "",
  "ws_hymn": "",
  "ws_prayer": "",
  "ws_offering_leader": "",
  "ws_offering_hymn": "",
  "ws_offering_benediction": "",
  "ws_special_song": "",
  "ws_sermon_title": "",
  "ws_preacher": "",
  "ws_bible_text": "",
  "ws_closing_hymn": "",
  "ws_benediction": "",
  "church_news": "",
  "offering_list": "",
  "prayer_requests": "",
  "service_this_week": "",
  "service_next_week": "",
  "memory_verse": "",
  "announcements": ""
}
```
PROMPT;
    }
}
