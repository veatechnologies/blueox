<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class WOOBE_EXPORT extends WOOBE_EXT {

    protected $slug = 'export'; //unique
    private $exlude_keys = array('__checker'); //do not export
    private $max_download_columns = 5; //we cant know how max downloads in one product
    private $csv_delimiter = ',';

    public function __construct() {
        add_action('woobe_ext_scripts', array($this, 'woobe_ext_scripts'), 1);

        //ajax
        add_action('wp_ajax_woobe_export_products_count', array($this, 'woobe_export_products_count'), 1);
        add_action('wp_ajax_woobe_export_products', array($this, 'woobe_export_products'), 1);
        add_action('wp_ajax_woobe_bulk_get_att_terms_export', array($this, 'woobe_bulk_get_att_terms_export'), 1);

        //tabs
        $this->add_tab($this->slug, 'top_panel', __('Export', 'woo-bulk-editor'));
        add_action('woobe_ext_top_panel_' . $this->slug, array($this, 'woobe_ext_panel'), 1);
    }

    public function woobe_ext_scripts() {
        wp_enqueue_script('woobe_ext_' . $this->slug, $this->get_ext_link() . 'assets/js/' . $this->slug . '.js',array(),WOOBE_VERSION);
        wp_enqueue_style('woobe_ext_' . $this->slug, $this->get_ext_link() . 'assets/css/' . $this->slug . '.css',array(),WOOBE_VERSION);
        ?>
        <script>
            lang.<?php echo $this->slug ?> = {};
            lang.<?php echo $this->slug ?>.want_to_export = '<?php _e('Should the export be started?', 'woo-bulk-editor') ?>';
            lang.<?php echo $this->slug ?>.exporting = '<?php _e('Exporting', 'woo-bulk-editor') ?> ...';
            lang.<?php echo $this->slug ?>.exported = '<?php _e('Exported', 'woo-bulk-editor') ?> ...';
            lang.<?php echo $this->slug ?>.export_is_going = "<?php echo __('ATTENTION: Export operation is going!', 'woo-bulk-editor') ?>";

        </script>
        <?php
    }

    public function woobe_ext_panel() {
        $data = array();
        $data['download_link'] = $this->get_ext_link() . '__exported_files/woobe_exported.csv';
        $data['active_fields'] = $this->get_active_fields();
        echo WOOBE_HELPER::render_html($this->get_ext_path() . 'views/panel.php', $data);
    }

    //ajax
    public function woobe_export_products_count() {
        if (!current_user_can('manage_woocommerce')) {
            die('0');
        }

        //***
        $active_fields = $this->get_active_fields();

        //***

        if (isset($_REQUEST['download_files_count'])) {//doesn exists if downloads column is not actived
            $download_files_count = intval($_REQUEST['download_files_count']);
            if ($download_files_count > 0) {
                $this->max_download_columns = $download_files_count;
            }
        }

        $this->csv_delimiter = $_REQUEST['csv_delimiter'];

        //***

        switch ($_REQUEST['format']) {
            case 'csv':

                if (!empty($active_fields)) {
                    $file_path = $this->get_ext_path() . '__exported_files/woobe_exported.csv';
                    $fp = fopen($file_path, "w");
                    $titles = array();
                    $attribute_index = 1; //for attributes columns

                    foreach ($active_fields as $field_key => $field) {
                        if (!in_array($field_key, $this->exlude_keys)) {

                            switch ($field['field_type']) {
                                case 'attribute':
                                    //making comapatibility with native woocommerce csv importer
                                    //wp-admin/edit.php?post_type=product&page=product_importer
                                    $titles[] = '"Attribute ' . $attribute_index . ' value(s)"';
                                    $titles[] = '"Attribute ' . $attribute_index . ' name"';
                                    $titles[] = '"Attribute ' . $attribute_index . ' visible"';
                                    $titles[] = '"Attribute ' . $attribute_index . ' global"';
                                    $attribute_index++;

                                    break;

                                case 'downloads':
                                    for ($i = 0; $i < $this->max_download_columns; $i++) {
                                        $titles[] = '"Download ' . ($i + 1) . ' name"';
                                        $titles[] = '"Download ' . ($i + 1) . ' URL"';
                                    }
                                    break;

                                case 'meta':
                                    $titles[] = '"Meta: ' . $field_key . '"';
                                    break;

                                default:
                                    $titles[] = '"' . $field['title'] . '"'; //head titles
                                    break;
                            }
                        }
                    }

                    //***

                    $titles = implode($this->csv_delimiter, $titles);
                    fputs($fp, $titles . $this->csv_delimiter . PHP_EOL);
                    fclose($fp);
                }


                break;

            case 'excel':
                //todo
                break;
        }


        if (!isset($_REQUEST['no_filter'])) {
            //get count of filtered - doesn work if export is for checked products
            $products = $this->products->gets(array(
                'fields' => 'ids',
                'no_found_rows' => true
            ));
            echo json_encode($products->posts);
        }

        exit;
    }

    //ajax
    public function woobe_export_products() {
        if (!current_user_can('manage_woocommerce')) {
            die('0');
        }

        //***
        
        $behavior=1;
        if(isset($_REQUEST['behavior']) AND intval($_REQUEST['behavior'])==0){
            $behavior=0;
        }

        $download_files_count = intval($_REQUEST['download_files_count']);
        if ($download_files_count > 0) {
            $this->max_download_columns = $download_files_count;
        }

        $this->csv_delimiter = $_REQUEST['csv_delimiter'];
        
        $combination=array();
        if(isset($_REQUEST['combination'])){
            $combination =  $_REQUEST['combination'];            
        }
                       
        //***
//die(json_encode($combination ));
        if (!empty($_REQUEST['products_ids'])) {
            switch ($_REQUEST['format']) {
                case 'csv':
                    $file = $this->get_ext_path() . '__exported_files/woobe_exported.csv';
                    $fp = fopen($file, 'a+');
                    $products_ids = array();
                    //$variations_ids = array();
                    //add variations for var products
                    foreach ($_REQUEST['products_ids'] as $product_id) {
                        $products_ids[] = $product_id;
                        $product = $this->products->get_product($product_id);
                        if ($product->is_type('variable')) {
                            $variations = $product->get_children();
                            if (!empty($variations)) {
                                
                                if(!empty($combination) AND is_array($combination) ){
                                   $variations_var=$variations; 
                                   $variations=array(); 
                                   foreach($variations_var as $var_id){
                                        $variation = $this->products->get_product($var_id);
                                        $attributes = $variation->get_attributes();

                                        //***

                                        $go = FALSE;
                                        if(!$behavior){
                                            $go = TRUE;  
                                       }
                                        //***

                                        if (!empty($attributes)) {
                                            foreach ($combination as $comb) {
                                                //lets look is $attributes the same set of attributes as in $comb
                                                $ak_att = array_keys($attributes);
                                                $ak_cv = array_keys($comb);

                                                //fix for non-latin symbols
                                                if (!empty($ak_att)) {
                                                    $ak_att = array_map('urldecode', $ak_att);
                                                }

                                                //fix for non-latin symbols
                                                if (!empty($ak_cv)) {
                                                    $ak_cv = array_map('urldecode', $ak_cv);
                                                }

                                                sort($ak_att);
                                                sort($ak_cv);

                                                if ($ak_att === $ak_cv) {
                                                    $av_att = array_values($attributes);
                                                    $av_cv = array_values($comb);

                                                    //fix for non-latin symbols
                                                    if (!empty($ak_att)) {
                                                        $av_att = array_map('urldecode', $av_att);
                                                    }

                                                    if (!empty($av_cv)) {
                                                        $av_cv = array_map('urldecode', $av_cv);
                                                    }

                                                    sort($av_att);
                                                    sort($av_cv);
                                                    if ($av_att === $av_cv) {
                                                       $go = TRUE;
                                                       if(!$behavior){
                                                            $go=FALSE;
                                                        }
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                        //***

                                        if ($go) {
                                            $variations[]=$var_id;
                                        }                                       
                                   }
                                }
                                
                                $products_ids = array_merge($products_ids, $variations);
                            }
                        }
                    }

//print_r($products_ids);
                    //***

                    foreach ($products_ids as $product_id) {
                        fputcsv($fp,$this->get_product_fields($product_id, $this->get_active_fields()), $this->csv_delimiter);
                    }

                    fclose($fp);
                    break;

                case 'excel':
                    //todo
                    break;

                default:
                    break;
            }
        }


        die('done');
    }

    private function get_product_fields($product_id, $fields) {
        $answer = array();
        if (!empty($fields)) {
            global $wc_product_attributes;
            foreach ($fields as $field_key => $field) {
                if (!in_array($field_key, $this->exlude_keys)) {

                    $a = $this->filter_fields_vals($this->products->get_post_field($product_id, $field_key), $field_key, $field, $product_id);


                    switch ($field['field_type']) {
                        case 'attribute':

                            $answer[] = $a;

                            if (!empty($a)) {
                                //making comapatibility with native woocommerce csv importer
                                //wp-admin/edit.php?post_type=product&page=product_importer

                                $answer[] = $field['title'];
                                //$p = $this->products->get_product($product_id);
                                if (isset($wc_product_attributes[$field_key]) AND ! $this->products->get_product($product_id)->is_type('variation')) {
                                    $answer[] = $wc_product_attributes[$field_key]->attribute_public; //visibility
                                } else {
                                    $answer[] = ''; //visibility
                                }

                                //wp-content\plugins\woocommerce\includes\export\class-wc-product-csv-exporter.php -> protected function prepare_attributes_for_export
                                $answer[] = intval(!empty($field['name'])); //global https://clip2net.com/s/3QWWy0a
                            } else {
                                $answer[] = '';
                                $answer[] = '';
                                $answer[] = '';
                            }

                            break;

                        case 'downloads':
                            if (!empty($a)) {
                                foreach ($a as $v) {
                                    $answer[] = $v;
                                }
                            } else {
                                //2 because there are 2 columns: name and URL
                                for ($i = 0; $i < 2 * $this->max_download_columns; $i++) {
                                    $answer[] = '';
                                }
                            }
                            break;

                        default:
                            $answer[] = $a;
                            break;
                    }
                }
            }
        }

        return $answer;
    }

    //values replaces to the human words
    private function filter_fields_vals($value, $field_key, $field, $product_id) {
        $words = array(
                /*
                  'draft' => __('draft', 'woo-bulk-editor'),
                  'publish' => __('publish', 'woo-bulk-editor'),
                 */
        ); //do not translate as it keys!!
        //***

        switch ($field['field_type']) {
            case 'taxonomy':

                if (is_array($value) AND ! empty($value)) {
                    $tmp = array();
                    if (in_array($field['taxonomy'], array('product_type'/* , 'product_shipping_class' */))) {
                        foreach ($value as $term) {
                            $tmp[] = $term->slug;
                        }
                        $value = implode(',', $tmp);
                    } else {
                        foreach ($value as $term) {
                            $tmp[] = $term->term_id;
                        }
                        include_once( WC_ABSPATH . 'includes/export/class-wc-product-csv-exporter.php' );
                        $woo_csv_exporter = new WC_Product_CSV_Exporter();
                        //wp-content\plugins\woocommerce\includes\export\abstract-wc-csv-exporter.php -> public function format_term_ids
                        $value = $woo_csv_exporter->format_term_ids($tmp, $field['taxonomy']);
                    }
                } else {
                    $value = '';
                }

                //***
                //fix for product_type
                if ($field['taxonomy'] === 'product_type') {
                    $product = $this->products->get_product($product_id);

                    if ($product->is_type('variation')) {
                        $value = 'variation';
                    }

                    if ($product->is_downloadable()) {
                        $value .= ', downloadable';
                    }

                    if ($product->is_virtual()) {
                        $value .= ', virtual';
                    }
                }


                break;

            case 'attribute':

                if (is_array($value) AND ! empty($value)) {
                    $tmp = array();
                    foreach ($value as $term_id) {
                        $tmp[] = get_term_field('name', $term_id);
                    }
                    $value = $this->implode_values($tmp);
                } else {
                    $value = '';
                }

                break;

            case 'gallery':
                if (!empty($value)) {
                    $tmp = array();
                    foreach ($value as $image_id) {
                        $image = wp_get_attachment_image_src($image_id, 'full');
                        if ($image) {
                            $tmp[] = $image[0];
                        }
                    }

                    $value = $this->implode_values($tmp);
                } else {
                    $value = '';
                }
                break;

            case 'meta':
                //just especially for thumbnail only
                if ($field['edit_view'] == 'thumbnail') {
                    $image = wp_get_attachment_image_src($value, 'full');
                    if ($image) {
                        $value = $image[0];
                    }
                }

                if ($field['edit_view'] == 'meta_popup_editor') {
                    if (!empty($value)) {
                        $value = json_encode($value, JSON_HEX_QUOT | JSON_HEX_TAG);
                    }
                }

                break;

            case 'downloads':
                $tmp = array();

                if (!empty($value)) {
                    foreach ($value as $f) {
                        $tmp[] = $f['name'];
                        $tmp[] = $f['file'];
                    }

                    //***

                    if (count($tmp) < $this->max_download_columns * 2) {
                        for ($i = count($tmp); $i < $this->max_download_columns * 2; $i++) {
                            $tmp[] = ''; //fill empty columns to avoid data shifting in csv
                        }
                    }
                }

                $value = $tmp;
                break;

            case 'upsells':
            case 'cross_sells':
            case 'grouped':
                if (!empty($value)) {
                    $tmp = array();
                    foreach ($value as $p_id) {
                        $product = $this->products->get_product($p_id);
                        $sku = '';
                        if (is_object($product) AND method_exists($product, 'get_sku')) {
                            $sku = $product->get_sku();
                            if (!empty($sku)) {
                                $tmp[] = $sku;
                            } else {
                                $tmp[] = 'id:' . $p_id;
                            }
                        }
                    }

                    $value = implode(',', $tmp);
                } else {
                    $value = '';
                }

                break;

            case 'prop':

                if ($field_key == 'backorders') {
                    switch ($value) {
                        case 'notify' :
                            $value = 'notify';
                            break;
                        default :
                            $value = wc_string_to_bool($value) ? 1 : 0;
                            break;
                    }
                }

                //***

                if ($field_key == 'stock_status') {
                    $value = ('instock' == $value ? 1 : 0);
                }

                //***

                if ($field['type'] == 'number') {
                    if ($field['sanitize'] == 'floatval') {
                        $value = floatval($value);
                    }

                    if ($field['sanitize'] == 'intval') {
                        $value = intval($value);
                    }
                }

                //***

                if ($field['type'] == 'timestamp') {
                    if (!empty($value)) {
                        $value = preg_replace('([+-](\d+):(\d+))', ' ', $value, 1);
                        $value = date('Y-m-d', strtotime($value)) . ' 0:00:00';
                    } else {
                        $value = '';
                    }
                }

                //***

                if ($field['edit_view'] == 'switcher') {
                    $value = intval($value);
                }

                break;

            case 'field':
                if ($field_key == 'post_status') {

                    if ($value == 'publish') {
                        $value = 1;
                    }

                    if ($value == 'draft') {
                        $value = -1;
                    }

                    if ($value == 'private') {
                        $value = 0;
                    }
                }

                if ($field_key == 'post_parent') {
                    $value = intval($value);
                    if ($value > 0) {
                        $value = 'id:' . $value;
                    }
                }
                break;
        }

        return $value;
    }

    //**********************************************************************

    private function implode_values($values) {
        $values_to_implode = array();

        foreach ($values as $value) {
            $value = (string) is_scalar($value) ? $value : '';
            $values_to_implode[] = str_replace(',', '\\,', $value);
        }

        return implode(', ', $values_to_implode);
    }

    public function get_active_fields() {
        static $fields_observed = array(); //cache

        if (empty($fields_observed)) {
            $fields_observed = $this->settings->active_fields;
            //Parent - post_parent - for variations is absolutely nessesary!!
            foreach ($fields_observed as $f) {
                if ($f['field_type'] == 'attribute' AND ! isset($fields_observed['post_parent'])) {
                    $fields_observed['post_parent'] = woobe_get_fields()['post_parent'];
                    break;
                }
            }
        }


        return $fields_observed;
    }

    //ajax
    public function woobe_bulk_get_att_terms_export() {

        $drop_downs = '';
        if (!empty($_REQUEST['attributes'])) {
            foreach ($_REQUEST['attributes'] as $pa) {
                $terms = WOOBE_HELPER::get_taxonomies_terms_hierarchy($pa);
                if (!empty($terms)) {
                    $options = array();
                    $options[''] = __('not selected', 'woo-bulk-editor');
                    foreach ($terms as $t) {
                        $options[$t['slug']] = $t['name'];
                    }

                    $drop_downs .= WOOBE_HELPER::draw_select(array(
                                'field' => 0,
                                'product_id' => 0,
                                'class' => '',
                                'options' => $options,
                                'name' => $pa 
                    ));
                }
            }
        }

        die($drop_downs);
    }    
}
