<?php
/*
 * Add Custom Product Part ID
 */
add_action('woocommerce_after_shop_loop_item', 'ddiipp_after_add_to_cart_btn');
add_action('woocommerce_after_add_to_cart_button', 'ddiipp_after_add_to_cart_btn');
function ddiipp_after_add_to_cart_btn() {
    $pro_id          = get_the_ID();
    $pro_part_number = '';
    if (class_exists('acf')) {
        $pro_part_number = get_field('part_number', $pro_id);
        $pro_part_number = !empty($pro_part_number) ? 'BOX' . $pro_part_number : '';
    }
    echo '<input type="hidden" class="ddiipp_pro_id" value="' . $pro_id . '"/>';
    echo '<input type="hidden" class="ddiipp_pro_part_id" value="' . strtoupper($pro_part_number) . '"/>';
}
/*
 * Template Redirect
 */
add_action('template_redirect', 'custom_redirects');
function custom_redirects() {
    $store_page_url = 'https://www.blueoxstore.com/shop';
    if (is_cart()) {
        wp_redirect($store_page_url . '/cart');
        die;
    }
    if (is_checkout()) {
        wp_redirect($store_page_url . '/checkout');
        die;
    }
    if (is_account_page()) {
        wp_redirect($store_page_url . '/checkout');
        die;
    }
}
/*
 * 
 */
//add_filter('manage_edit-product_sortable_columns', 'ddiipp_set_custom_colum_product_page',99);
add_filter('manage_product_posts_columns', 'ddiipp_set_custom_colum_product_page',99);
function ddiipp_set_custom_colum_product_page($columns) {
    unset($columns['product_tag']);
    foreach ($columns as $key => $status) {
        $new_columns[$key] = $status;
        if ('name' === $key){
            $new_columns['pro_code'] = 'Part Number';
        }
    }
    return $new_columns;
}
add_action('manage_product_posts_custom_column', 'ddiipp_set_custom_colum_data', 10, 2);
function ddiipp_set_custom_colum_data($column, $post_id) {
    switch ($column) {
        case 'pro_code' :
            $part_number = get_field('part_number', $post_id);
            echo !empty( $part_number ) ? $part_number : '-';
            break;
    }
}
