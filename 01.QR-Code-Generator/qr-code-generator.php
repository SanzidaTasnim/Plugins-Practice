<?php
/*
* Plugin Name:       Display QR Code
* Plugin URI:        https://wordpress.org/plugins/
* Description:       This plugin shows the QR Code generating from the URL.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Sanzida
* Author URI:        https://sanzida.me/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Update URI:        https://example.com/my-plugin/
* Text Domain:       display-qr-code
* Domain Path:       /languages
*/

function qrc_activation_hook(){}
register_activation_hook(__FILE__ , "qrc_activation_hook");
function qrc_deactivation_hook(){}
register_deactivation_hook(__FILE__, "qrc_deactivation_hook");
function qrc_text_domain(){
    load_plugin_textdomain("display-qr-code",false , dirname(__FILE__). "/languages");
}
add_action("plugins_loaded", "qrc_text_domain");

function qrc_show_qr_code($content){
    $current_id = get_the_ID();
    $current_uri = urlencode(get_the_permalink($current_id));
    $current_title = get_the_title($current_id);
    $current_post_type = get_post_type($current_id);
    $post_arr = apply_filters("qrc_post_type_add", array());
    if(in_array($current_post_type, $post_arr)){
        return $content;
    }
    $img_size = "100x100";
    $qr_code_size = apply_filters("qrc_apply_size", $img_size);
    $img_src = sprintf("https://api.qrserver.com/v1/create-qr-code/?data=%s!&size=%s", $current_uri , $qr_code_size);
    $result = sprintf("<div class='qrcode'><img src='%s' alt='%s'></img></div>", $img_src , $current_title);
    return $content .= $result;
}
add_filter("the_content", "qrc_show_qr_code");
function change_img_size($img_size){
    return "200x200";
}
add_filter('qrc_apply_size' , "change_img_size");
function qrc_remove_page_qrcode($post_arr){
    $post_arr[] = 'post';
    return $post_arr;
}
add_filter("qrc_post_type_add", "qrc_remove_page_qrcode");


