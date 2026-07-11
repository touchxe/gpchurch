<?php
/**
 * 사업계획서 관리
 *
 * @package GPC_Bulletin_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wrap gpc-bulletin-wrap">
    <h1><span class="dashicons dashicons-calendar-alt" style="font-size: 28px; width: 30px; height: 30px; margin-right: 5px;"></span> 사업계획서 관리 (엑셀/CSV 연동)</h1>
    <p>연간 사업계획서(예배 순서, 봉사자 등)를 엑셀이나 CSV 파일로 업로드하여 데이터베이스에 저장합니다.<br>
    업로드된 데이터는 '순서지 만들기' 메뉴에서 날짜를 선택할 때 자동으로 폼에 채워집니다.</p>

    <div class="card gpc-card">
        <h2>1. 업로드 양식 다운로드</h2>
        <p>정확한 데이터 인식을 위해 아래의 표준 엑셀(CSV) 양식을 다운로드하여 사용해 주세요.<br>
        기존 한글이나 PDF에 있는 표 내용을 이 양식에 복사/붙여넣기 하시면 됩니다.</p>
        <p><a href="<?php echo esc_url( GPC_BULLETIN_URL . 'assets/gpc-business-plan-template.csv' ); ?>" class="button button-secondary" download>⬇️ 표준 양식 (CSV) 다운로드</a></p>
    </div>

    <div class="card gpc-card">
        <h2>2. 사업계획서 업로드</h2>
        <form id="gpc-bulletin-plan-form" enctype="multipart/form-data">
            <?php wp_nonce_field( 'gpc_bulletin_nonce', 'nonce' ); ?>
            <input type="hidden" name="action" value="gpc_bulletin_upload_plan">
            
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="plan_file">파일 선택 (CSV 전용)</label></th>
                        <td>
                            <input type="file" name="plan_file" id="plan_file" accept=".csv" required>
                            <p class="description">양식에 맞춰 작성된 CSV 파일을 선택해 주세요.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <p class="submit">
                <button type="submit" class="button button-primary" id="btn-upload-plan">업로드 및 데이터 갱신</button>
            </p>
        </form>
        <div id="plan-upload-result" style="margin-top: 15px;"></div>
    </div>
</div>
