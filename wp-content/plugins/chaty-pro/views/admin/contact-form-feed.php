<?php
global $wpdb;
$table_name = $wpdb->prefix.'chaty_contact_form_leads';

$current = isset($_GET['paged'])&&!empty($_GET['paged'])&&is_numeric($_GET['paged'])&&$_GET['paged'] > 0 ? $_GET['paged'] : 1;
$current = intval($current);

$search_for  = "all_time";
$search_list = [
    'today'        => 'Today',
    'yesterday'    => 'Yesterday',
    'last_7_days'  => 'Last 7 Days',
    'last_30_days' => 'Last 30 Days',
    'this_week'    => 'This Week',
    'this_month'   => 'This Month',
    'all_time'     => 'All Time',
    'custom'       => 'Custom Date',
];

if (isset($_GET['search_for']) && !empty($_GET['search_for']) && isset($search_list[$_GET['search_for']])) {
    $search_for = esc_attr($_GET['search_for']);
}

$start_date = "";
$end_date   = "";
if ($search_for == "today") {
    $start_date = date("Y-m-d");
    $end_date   = date("Y-m-d");
} else if ($search_for == "yesterday") {
    $start_date = date("Y-m-d", strtotime("-1 days"));
    $end_date   = date("Y-m-d", strtotime("-1 days"));
} else if ($search_for == "last_7_days") {
    $start_date = date("Y-m-d", strtotime("-7 days"));
    $end_date   = date("Y-m-d");
} else if ($search_for == "last_30_days") {
    $start_date = date("Y-m-d", strtotime("-30 days"));
    $end_date   = date("Y-m-d");
} else if ($search_for == "this_week") {
    $start_date = date("Y-m-d", strtotime('monday this week'));
    $end_date   = date("Y-m-d");
} else if ($search_for == "this_month") {
    $start_date = date("Y-m-01");
    $end_date   = date("Y-m-d");
} else if ($search_for == "custom") {
    if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
        $start_date = $_GET['start_date'];
    }

    if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
        $end_date = $_GET['end_date'];
    }
} else if ($search_for == "all_time") {
    $start_date = "";
    $end_date   = "";
}//end if

$hasSearch = isset($_GET['search'])&&!empty($_GET['search']) ? $_GET['search'] : false;

$query  = "SELECT count(id) as total_records FROM ".$table_name;
$search = "";

$condition      = "";
$conditionArray = [];
if ($hasSearch !== false) {
    $search           = $hasSearch;
    $hasSearch        = "%".esc_attr($hasSearch)."%";
    $condition       .= " (name LIKE %s OR email LIKE %s OR phone_number LIKE %s OR message LIKE %s)";
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
}

$start_date = esc_attr($start_date);
$end_date   = esc_attr($end_date);
if (!empty($start_date) && !empty($end_date)) {
    if (!empty($condition)) {
        $condition .= " AND ";
    }

    $c_start_date     = date("Y-m-d 00:00:00", strtotime($start_date));
    $c_end_date       = date("Y-m-d 23:59:59", strtotime($end_date));
    $condition       .= " created_on >= %s AND created_on <= %s";
    $conditionArray[] = $c_start_date;
    $conditionArray[] = $c_end_date;
}

if (!empty($condition)) {
    $query .= " WHERE ".$condition;
}

$query .= " ORDER BY ID DESC";

if (!empty($conditionArray)) {
    $query = $wpdb->prepare($query, $conditionArray);
}

$total_records = $wpdb->get_var($query);
$per_page      = 15;
$total_pages   = ceil($total_records / $per_page);

$query = "SELECT * FROM ".$table_name;
if (!empty($condition)) {
    $query .= " WHERE ".$condition;
}

if ($current > $total_pages) {
    $current = 1;
}

$start_from = (($current - 1) * $per_page);

$query .= " ORDER BY ID DESC";
$query .= " LIMIT $start_from, $per_page";

if (!empty($conditionArray)) {
    $query = $wpdb->prepare($query, $conditionArray);
}
?>
<div class="wrap">
    <?php
    $result = $wpdb->get_results($query);
    ?>
    <div>
        <?php if ($result || !empty($search) || $search_for != 'all_time') : ?>
            <div class="flex flex-wrap justify-between pt-5">
                <a href="<?php echo esc_url( $this->getDashboardUrl() ) ?>">
                    <img class="w-32" src="<?php echo esc_url(plugins_url('../../admin/assets/images/logo-color.svg', __FILE__)); ?>" alt="Chaty" class="logo">
                </a>
                <span class="mt-3 sm:mt-0 font-primary text-3xl text-cht-gray-150">Contact Form Leads</span>
            </div>
        <?php endif; ?>

        <div class="flex flex-wrap space-y-3 md:space-y-0 justify-between items-center contact-form-leads-header mt-4 pb-2">
            <?php if ($result) : ?>
                <div class="flex items-center">
                    <select name="action" id="bulk-action-selector-top">
                        <option value="">Bulk Actions</option>
                        <option value="delete_message">Delete</option>
                    </select>
                    <input type="submit" id="doaction" class="action btn cursor-pointer" value="Apply">
                </div>
            <?php endif; ?>

            <?php if ($result || !empty($search) || $search_for != 'all_time') : ?>
                <form class="flex items-center flex-wrap gap-3" action="<?php echo admin_url("admin.php") ?>" method="get">
                    <label class="screen-reader-text" for="post-search-input">Search:</label>
                    <select class="search-input mr-5" name="search_for" id="date-range">
                        <?php foreach ($search_list as $key => $value) { ?>
                            <option <?php selected($key, $search_for) ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></option>
                        <?php } ?>
                    </select>
                    <input type="search" class="search-input" name="search" value="<?php echo esc_attr($search) ?>" class="">
                    <input type="submit" id="search-submit" class="cursor-pointer btn" value="Search">
                    <input type="hidden" name="page" value="chaty-contact-form-feed" />
                    <div class="date-range <?php echo ($search_for == "custom" ? "active" : "") ?>">
                        <input type="search" class="search-input" name="start_date" id="start_date" value="<?php echo esc_attr($start_date) ?>" autocomplete="off" placeholder="Start date">
                        <input type="search" class="search-input" name="end_date" id="end_date" value="<?php echo esc_attr($end_date) ?>" autocomplete="off" placeholder="End date">
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <form action="" method="post" class="responsive-table contact-form-lead">
            <?php
            if ($result) {
                ?>
                <table id="contact-feed" class="border-separate w-full rounded-lg border border-cht-gray-50 mb-5"  border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="rounded-tl-lg text-cht-gray-150 text-sm font-semibold font-primary py-3 px-2 bg-cht-primary-50" style="width:1%"><?php esc_html_e('Bulk', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('ID', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Widget Name', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Name', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Email', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Phone number', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Message', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('Date', 'chaty');?></th>
                            <th class="text-center text-cht-gray-150 text-sm font-semibold font-primary py-3 px-5 bg-cht-primary-50"><?php esc_html_e('URL', 'chaty');?></th>
                            <th class="rounded-tr-lg text-cht-gray-150 text-sm font-semibold font-primary py-3 px-2 bg-cht-primary-50"><?php esc_html_e('Delete', 'chaty');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($result as $res) {
                                if ($res->widget_id == 0) {
                                    $widget_name = "Default";
                                } else {
                                    $widget_name = get_option("cht_widget_title_".$res->widget_id);
                                    if (empty($widget_name)) {
                                        $widget_name = "Widget #".($res->widget_id + 1);
                                    }
                                }
                                ?>
                                <tr data-id="<?php echo esc_attr($res->id)?>">
                                    <td class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r">
                                        <div class="checkbox">
                                            <label for="checkbox_<?php echo esc_attr($res->id) ?>" class="chaty-checkbox text-cht-gray-150 text-base flex items-center">
                                                <input 
                                                    class="sr-only" 
                                                    type="checkbox" 
                                                    id="checkbox_<?php echo esc_attr($res->id) ?>" 
                                                    name="chaty_leads[]" 
                                                    value="<?php echo esc_attr($res->id) ?>" 
                                                />
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('ID', 'chaty');?>">
                                            <?php echo esc_attr($res->id) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Widget Name', 'chaty');?>">
                                            <?php echo esc_attr($widget_name) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Name', 'chaty');?>">
                                            <?php echo esc_attr($res->name) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Email', 'chaty');?>">
                                            <?php echo esc_attr($res->email) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Phone number', 'chaty');?>">
                                            <?php echo esc_attr($res->phone_number) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Message', 'chaty');?>">
                                            <?php echo nl2br(esc_attr($res->message)) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('Date', 'chaty');?>">
                                            <?php echo esc_attr($res->created_on) ?>
                                    </td>
                                    <td 
                                        class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center border-r border-t"
                                        data-title="<?php esc_html_e('URL', 'chaty');?>">
                                            <a class="url" target="_blank" href="<?php echo esc_url($res->ref_page) ?>">
                                                <span class="dashicons dashicons-external"></span>
                                            </a>
                                    </td>
                                    <td class="bg-white py-3.5 px-5 text-cht-gray-150 font-primary text-sm text-center"><a class="remove-record" href="#"><span class="dashicons dashicons-trash"></span></a></td>
                                </tr>
                            <?php }//end foreach
                        ?>
                    </tbody>
                </table>
                <?php
                if ($total_pages > 1) {
                    $baseURL = admin_url("admin.php?paged=%#%&page=chaty-contact-form-feed");
                    if (!empty($search)) {
                        $baseURL .= "&search=".$search;
                    }

                    echo '<div class="custom-pagination">';
                        echo paginate_links(
                            [
                                'base'         => $baseURL,
                                'total'        => $total_pages,
                                'current'      => $current,
                                'format'       => '?paged=%#%',
                                'show_all'     => false,
                                'type'         => 'list',
                                'end_size'     => 3,
                                'mid_size'     => 1,
                                'prev_next'    => true,
                                'prev_text'    => sprintf('%1$s', '<span class="dashicons dashicons-arrow-left-alt2"></span>'),
                                'next_text'    => sprintf('%1$s', '<span class="dashicons dashicons-arrow-right-alt2"></span>'),
                                'add_args'     => false,
                                'add_fragment' => '',
                            ]
                        );
                    echo "</div>";
                }//end if
                ?>
                <div class="leads-buttons flex items-center gap-3 flex-wrap">
                    <a href="<?php echo admin_url("?download_chaty_file=chaty_contact_leads&nonce=".wp_create_nonce("download_chaty_contact_leads")) ?>" class="btn rounded-lg inline-block" id="wpappp_export_to_csv" value="Export to CSV">Download &amp; Export to CSV</a>
                    <input type="button" class="inline-block cursor-pointer rounded-lg bg-transparent border-red-500 text-red-500 hover:bg-red-500/10 focus:bg-red-500/10 hover:text-red-500 btn btn-primary" id="chaty_delete_all_leads" value="Delete All Data">
                </div>
            <?php } else if (!empty($search) || $search_for != "all_time") { ?>
                <div class="chaty-updates-form pt-7">
                    <div class="testimonial-error-message max-w-screen-sm font-primary mx-auto">
                        <p class="px-5 text-2xl text-center">No records are found</p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="container">
                    <div class="chaty-table no-widgets py-20 bg-cover rounded-lg border border-cht-gray-50">
                        
                        <img class="mx-auto w-60" src="<?php echo CHT_PLUGIN_URL ?>/admin/assets/images/stars-image.png" />
                
                        <div class="text-center">
                            <div class="update-title text-cht-gray-150 text-3xl sm:text-4xl pb-5">Contact Form Leads</div>
                            <p class="font-primary text-base text-cht-gray-150 -mt-2 max-w-screen-sm px-5 mx-auto">
                            Your contact form leads will appear here once you get some leads. Please make sure you've added the contact form channel to your Chaty channels in order to collect leads
                            </p>
                        </div>
                    </div>
                </div>
                
            <?php }//end if
            ?>
            <input type="hidden" name="remove_chaty_leads" value="<?php echo wp_create_nonce("remove_chaty_leads") ?>">
            <input type="hidden" name="paged" value="<?php echo esc_attr($current) ?>">
            <input type="hidden" name="search" value="<?php echo esc_attr($search) ?>">
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        var selectedURL = '<?php echo admin_url("admin.php?page=chaty-contact-form-feed&remove_chaty_leads=".wp_create_nonce("remove_chaty_leads")."&action=delete_message&paged={$current}&search=".esc_attr($search)."&chaty_leads=") ?>';
        jQuery(document).on("click", ".remove-record", function(e){
            e.preventDefault();
            var redirectRemoveURL = selectedURL+jQuery(this).closest("tr").data("id");
            if(confirm("Are you sure you want to delete Record with ID# "+jQuery(this).closest("tr").data("id"))) {
                window.location = redirectRemoveURL;
            }
        });
        jQuery(document).on("click", "#chaty_delete_all_leads", function(e){
            e.preventDefault();
            var redirectRemoveURL = selectedURL+"remove-all";
            if(confirm("Are you sure you want to delete all Record from the database?")) {
                window.location = redirectRemoveURL;
            }
        });
        jQuery(document).on("click", "#doaction", function(e){
            if(jQuery("#bulk-action-selector-top").val() == "delete_message") {
                if(jQuery("#contact-feed input:checked").length) {

                    var selectedIds = [];
                    jQuery("#contact-feed input:checked").each(function(){
                        selectedIds.push(jQuery(this).val());
                    });
                    if(selectedIds.length) {
                        selectedIds = selectedIds.join(",");
                        var redirectRemoveURL = selectedURL+selectedIds;
                        if(confirm("Are you sure you want to delete selected records?")) {
                            window.location = redirectRemoveURL;
                        }
                    }
                }
            }
        });
        jQuery("#date-range").on("change", function(){
            if(jQuery(this).val() == "custom") {
                jQuery(".date-range").addClass("active");
            } else {
                jQuery(".date-range").removeClass("active");
            }
        });
        if(jQuery("#start_date").length) {
            jQuery("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                altFormat: 'yy-mm-dd',
                maxDate: 0,
                onSelect: function(d,i){
                    var minDate = jQuery("#start_date").datepicker('getDate');
                    minDate.setDate(minDate.getDate()); //add two days
                    jQuery("#end_date").datepicker("option", "minDate", minDate);
                    if(jQuery("#end_date").val() <= jQuery("#start_date").val()) {
                        jQuery("#end_date").val(jQuery("#start_date").val());
                    }

                    if(jQuery("#end_date").val() == "") {
                        jQuery("#end_date").val(jQuery("#start_date").val());
                    }
                }
            });
        }
        if(jQuery("#end_date").length) {
            jQuery("#end_date").datepicker({
                dateFormat: 'yy-mm-dd',
                altFormat: 'yy-mm-dd',
                maxDate: 0,
                minDate: 0,
                onSelect: function(d,i){
                    if(jQuery("#start_date").val() == "") {
                        jQuery("#start_date").val(jQuery("#end_date").val());
                    }
                }
            });
        }
    });
</script>
