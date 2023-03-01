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

// Render
echo "<style>
       .container {
       max-width: 1200px;
       margin: auto;
       }
      table, th, td {
        border: 1px solid black !important;
        border-collapse: collapse;
        text-align: center !important;
      }
      .title-table{
        font-weight: bold;
        color: black;
      }
      .monhoc{
        text-align: left !important;
      }
      .text-color{
        color: black;
      }
      .hientai{
        background-color: #F1C231;
      }
      .mongmuon {
        background-color: #35A853;
      }
      .count_ca {
        float: right;
        font-style: italic;
      }
      .count_number {
        font-weight: bold;
      }
      form.form-search-query input[type=text] {
            float: left;
            padding: 10px;
            border-bottom-left-radius: 10px !important;
            border-top-left-radius: 10px !important;
            border-bottom-right-radius: 0px !important;
            border-top-right-radius: 0px !important;
            width: 80%;
            background: #f1f1f1;
        }

        form.form-search-query button {
            float: left;
            width: 20%;
            background: #2196F3;
            color: white;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
            border-bottom-left-radius: 0px !important;
            border-top-left-radius: 0px !important;
            border-bottom-right-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        form.form-search-query button:hover {
            background: #0b7dda;
        }

        form.form-search-query::after {
          clear: both;
          display: table;
        }
</style>";

echo doi_lich_hoc();
function doi_lich_hoc()
{

    global $wpdb;
    $sql_query = "select 
                    wp_e_submissions_values.submission_id,
                    wp_e_submissions_values.key,
                    wp_e_submissions_values.value
                    FROM wp_e_submissions 
                    INNER JOIN wp_e_submissions_values on wp_e_submissions.id = wp_e_submissions_values.submission_id
                    WHERE wp_e_submissions.element_id='0a4d8fc' ";
    $sql_search = "select 
		wp_e_submissions_values.submission_id,
		wp_e_submissions_values.key,
		wp_e_submissions_values.value
		FROM wp_e_submissions 
		INNER JOIN wp_e_submissions_values on wp_e_submissions.id = wp_e_submissions_values.submission_id
		WHERE wp_e_submissions.element_id='0a4d8fc' 
		AND wp_e_submissions_values.key ='monhoc' 
		AND wp_e_submissions_values.value LIKE '%Môn Toán%'
		ORDER BY wp_e_submissions_values.value ASC";

    $results = $wpdb->get_results($sql_query);
    $list =[];
    foreach ($results as $key=>$value){
        $list[$value->submission_id][$value->key] = $value->value;
    }
    $count_ca = count($list);

    echo '<div class="container">';
    echo '<h3 style="text-align: center">Danh sách đăng kí tìm - đổi lịch học</h3>';
    echo '<br>';
    echo '<form class="form-search-query" action="" method="get" style="margin:auto;max-width:300px">
          <input type="text" placeholder="Tìm môn học .." name="q">
          <button type="submit"><i class="fa fa-search"></i></button>
          </form>';
          $q = $_GET['q'];
    echo '<br>';
    echo '<p class="count_ca">Số ca học đang tìm đổi: <span class="count_number">'.$count_ca.'</span></p>';
    echo '<table>';
    echo '<tr>
            <th style="width:25%; vertical-align:middle" rowspan="2" class="title-table">Môn Học <br> (Từ A-Z sắp xếp theo mã môn)</th>
            <th class="hientai title-table" colspan="3">Lịch học hiện tại</th>
            <th class="mongmuon title-table" colspan="3">Lịch học muốn đổi</th>
            <th style="width:10%; vertical-align:middle" rowspan="2" class="title-table">Liên hệ <br> (SĐT/Zalo)</th>
          </tr>';
    echo '<tr>
            <td class="hientai title-table">Lớp học</td>
            <td class="hientai title-table">Ngày học</td>
            <td class="hientai title-table">Ca học</td>
            <td class="mongmuon title-table">Lớp học</td>
            <td class="mongmuon title-table">Ngày học</td>
            <td class="mongmuon title-table">Ca học</td>
          </tr>';
    foreach ($list as $item) {
        echo '<tr>';
//        echo '<td colspan="text-color"></td>';
//        echo '<td class="monhoc text-color">' .$item['mamon'] .' - '. $item['monhoc'] .'</td>';
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
    echo '</table>';
    echo '</div>';
}
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



get_footer();
