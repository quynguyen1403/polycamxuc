<?php
/*
Template Name: Đổi lịch học
*/

defined('ABSPATH') || exit;

use Gostudy_Theme_Helper as Gostudy;

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gostudy
 * @since 1.0.0
 */

get_header();
the_post();

$sb = Gostudy::get_sidebar_data();
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';
$container_class = $sb['container_class'] ?? '';
function doi_lich_hoc()
{
    global $wpdb;
    $sql_query = "select 
                    wp_e_submissions_values.submission_id,
                    wp_e_submissions_values.key,
                    wp_e_submissions_values.value
                    FROM wp_e_submissions 
                    INNER JOIN wp_e_submissions_values on wp_e_submissions.id = wp_e_submissions_values.submission_id
                    WHERE wp_e_submissions.element_id='0a4d8fc'";
    $results = $wpdb->get_results($sql_query);
    $list =[];
    foreach ($results as $key=>$value){
        $list[$value->submission_id][$value->key] = $value->value;
    }
    echo '<h3 class="title-content">Cơ sở Hà Nội</h3>';
    echo '<h3 class="title-content">Danh sách đang tìm đổi</h3>';
    echo '<h5 class="title-content">(Block I - Summer 2023)</h5>';
    echo '<p style="color: red">(*) Mẹo: Hãy tìm kiếm bằng Mã môn hoặc Tên môn học</p>';
    echo '<table id="doi-lich-hoc" class="table hover">';
    echo "<thead>";
    echo '<tr>
            <th class="title-table" rowspan="2" style="vertical-align:middle"">STT</th>
            <th style="vertical-align:middle" rowspan="2" class="title-table">Mã môn</th>
            <th style="width:20%; vertical-align:middle" rowspan="2" class="title-table">Môn Học</th>
            <th class="hientai title-table" colspan="3">Lịch học hiện tại</th>
            <th class="mongmuon title-table" colspan="3">Lịch học muốn đổi</th>
            <th style="width:10%; vertical-align:middle" rowspan="2" class="title-table">Liên hệ <br> (SĐT/Zalo)</th>
          </tr>';
    echo '<tr>
            <th class="hientai title-table">Lớp học</th>
            <th class="hientai title-table">Ngày học</th>
            <th class="hientai title-table">Ca học</th>
            <th class="mongmuon title-table">Lớp học</th>
            <th class="mongmuon title-table">Ngày học</th>
            <th class="mongmuon title-table">Ca học</th>
          </tr>';
    echo "</thead>";
    echo '<tbody>';
    foreach ($list as $item) {
        echo '<tr>';
        echo '<td colspan="text-color"></td>';
        echo '<td class="mamon text-color">' .$item['mamon'] .'</td>';
        echo '<td class="monhoc text-color">'. $item['monhoc'] .'</td>';
        echo '<td class="hientai text-color">'. $item['lophientai'] .'</td>';
        echo '<td class="hientai text-color">'. $item['ngayhientai'] .'</td>';
        echo '<td class="hientai text-color">'. $item['cahientai'] .'</td>';
        echo '<td class="mongmuon text-color">'. $item['lopmuondoi'] .'</td>';
        echo '<td class="mongmuon text-color">'. $item['ngaymuondoi'] .'</td>';
        echo '<td class="mongmuon text-color">'. $item['camuondoi'] .'</td>';
        echo '<td><a href="tel:'. '0'.$item['sdt'] .'">0'. $item['sdt'] .'</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>
<div class="container">
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link src="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <script>
        $(document).ready( function () {
            var table = $("#doi-lich-hoc").DataTable({
                lengthMenu: [
                    [2, 20, 50, 100, 150, 200],
                    [2, 20, 50, 100, 150, 200],
                ],
                language: {
                    "lengthMenu": "Hiển thị _MENU_ trên mỗi trang",
                    "zeroRecords": "Không có dữ liệu ca học liên quan",
                    "info": "Trang số <span style='font-weight: bold'>_PAGE_</span> trong tổng số _PAGES_ trang",
                    "infoEmpty": "Không tìm thấy ca học nào",
                    "infoFiltered": "(dữ liệu được lọc từ _MAX_ đơn đăng kí)",
                    "search":  "Tìm kiếm:",
                    "searchPlaceholder": "Nhập mã môn hoặc tên môn",
                    "paginate": {
                        "first":      "Trang đầu",
                        "last":       "Trang cuối",
                        "next":       "&raquo;",
                        "previous":   "&laquo;"
                    },
                },
                pagingType: 'full_numbers',
                columnDefs: [
                    {
                        searchable: false,
                        orderable: false,
                        targets: 0,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 3,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 4,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 5,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 6,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 7,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 8,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        targets: 9,
                    },
                ],
                order: [[1, 'asc']],
            });

            table.on('order.dt search.dt', function () {
                let i = 1;
                table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();
        } );
    </script>
<style>
       .container {
       max-width: 80%;
       margin: auto;
       }
      table, th, td {
          font-size: 15px;
          border: 1px solid black !important;
        border-collapse: collapse;
        text-align: center !important;
      }
      .title-table{
        font-weight: bold;
        color: black;
      }
      .mamon{
          text-align: left !important;
      }
      .monhoc{
        text-align: left !important;
      }
      .text-color{
        color: black;
      }
      .hientai{
        background-color: #F1C231 !important;
      }
      .mongmuon {
        background-color: #35A853 !important;
      }
      .title-content{
          text-align: center;
      }
       .dataTables_length{
           width: 17% !important;
       }
       .dataTables_length .select__field {
           margin-bottom: 0px !important;
           width: 30% !important;
       }
       .dataTables_filter {
           padding-bottom: 0px !important;
       }
       .dataTables_length .select__field select {
           padding-left: 14px !important;
           width: 77% !important;
       }
       .dataTables_wrapper .dataTables_paginate .paginate_button.current {
           border: none !important;
           background: #FF1F59 !important;
           color: #ffffff !important;
           border-radius: 10px
       }
       .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
           border: 1px solid #FF1F59;
           color: black !important;
           background: transparent !important;
           border-radius: 10px
       }
</style>

<?php doi_lich_hoc();

echo '</div>';

the_content(esc_html__('Xem thêm!', 'gostudy'));

// Pagination
wp_link_pages(Gostudy::pagination_wrapper());

// Comments
if (comments_open() || get_comments_number()) {
    comments_template();
}



if ($sb) {
    Gostudy::render_sidebar($sb);
}



get_footer();  ?>
