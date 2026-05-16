<?php
/**
 * 관리자 뷰: 순서지 목록 페이지
 * - 행 클릭 시 상세/수정 페이지 이동
 * - 체크박스를 통한 다중 선택 삭제
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$db       = new GPC_Bulletin_DB();
$page     = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1;
$search   = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
$per_page = 20;
$result   = $db->get_all( $page, $per_page, $search );
$items    = $result['items'];
$total    = $result['total'];
$pages    = ceil( $total / $per_page );
?>
<div class="wrap gpc-bulletin-wrap">
    <h1 class="gpc-bulletin-title">
        📋 순서지 목록
        <a href="<?php echo admin_url( 'admin.php?page=gpc-bulletin-upload' ); ?>" class="gpc-btn gpc-btn-primary gpc-btn-sm">
            ＋ 새 순서지 업로드
        </a>
    </h1>

    <div class="gpc-list-toolbar">
        <form method="get" class="gpc-search-form">
            <input type="hidden" name="page" value="gpc-bulletin">
            <input type="text" name="s" class="gpc-input gpc-search-input"
                   value="<?php echo esc_attr( $search ); ?>"
                   placeholder="설교자, 설교 제목 검색...">
            <button type="submit" class="gpc-btn gpc-btn-secondary">검색</button>
        </form>
        <span class="gpc-list-count">총 <strong><?php echo $total; ?></strong>건</span>
    </div>

    <?php if ( empty( $items ) ) : ?>
        <div class="gpc-empty-state">
            <div class="gpc-empty-icon">📄</div>
            <p>등록된 순서지가 없습니다.</p>
            <a href="<?php echo admin_url( 'admin.php?page=gpc-bulletin-upload' ); ?>" class="gpc-btn gpc-btn-primary">
                첫 번째 순서지 업로드하기
            </a>
        </div>
    <?php else : ?>
        <!-- 다중 선택 삭제 바 -->
        <div class="gpc-bulk-bar" id="gpc-bulk-bar" style="display:none">
            <span class="gpc-bulk-count"><strong id="gpc-selected-count">0</strong>건 선택됨</span>
            <button type="button" class="gpc-btn gpc-btn-danger gpc-btn-sm" id="gpc-bulk-delete-btn">
                🗑 선택 삭제
            </button>
            <button type="button" class="gpc-btn gpc-btn-secondary gpc-btn-sm" id="gpc-bulk-cancel-btn">
                취소
            </button>
        </div>

        <table class="gpc-table">
            <thead>
                <tr>
                    <th class="gpc-col-check">
                        <input type="checkbox" id="gpc-check-all" title="전체 선택">
                    </th>
                    <th>발행 날짜</th>
                    <th>안식일 구분</th>
                    <th>설교 제목</th>
                    <th>설교자</th>
                    <th>예배 인도</th>
                    <th>안교 진행</th>
                    <th class="gpc-col-actions">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $items as $item ) :
                    $edit_url = admin_url( 'admin.php?page=gpc-bulletin&action=edit&id=' . $item->id );
                ?>
                <tr class="gpc-clickable-row" data-href="<?php echo esc_url( $edit_url ); ?>">
                    <td class="gpc-col-check" onclick="event.stopPropagation()">
                        <input type="checkbox" class="gpc-row-check" value="<?php echo $item->id; ?>">
                    </td>
                    <td class="gpc-col-date">
                        <strong><?php echo esc_html( $item->publish_date ); ?></strong>
                    </td>
                    <td><?php echo esc_html( $item->sabbath_type ); ?></td>
                    <td class="gpc-col-sermon"><?php echo esc_html( $item->ws_sermon_title ); ?></td>
                    <td><?php echo esc_html( $item->ws_preacher ); ?></td>
                    <td><?php echo esc_html( $item->ws_host ); ?></td>
                    <td><?php echo esc_html( $item->ss_host ); ?></td>
                    <td class="gpc-col-actions" onclick="event.stopPropagation()">
                        <a href="<?php echo esc_url( $edit_url ); ?>"
                           class="gpc-btn-link">수정</a>
                        <button type="button" class="gpc-btn-link gpc-btn-danger gpc-delete-btn"
                                data-id="<?php echo $item->id; ?>">삭제</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ( $pages > 1 ) : ?>
        <div class="gpc-pagination">
            <?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
                <?php if ( $i === $page ) : ?>
                    <span class="gpc-page-current"><?php echo $i; ?></span>
                <?php else : ?>
                    <a href="<?php echo add_query_arg( 'paged', $i ); ?>" class="gpc-page-link"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
