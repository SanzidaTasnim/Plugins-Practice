<?php
/**
 * Plugin Name:         User Profile Some field added
 * Description:         Some more fields added for user's descriptive information.
 * Plugin URI:          https://wordpress.org/plugins/
 * Author:              Sanzida Tasnim
 * Author URI:          http://sanzida.tasnim.me
 * Version:             1.0.0
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:          https://github.com/SanzidaTasnim/
 * Text Domain:         user-field-add
 * Domain Path:         /languages
 */

/**
 * Copyright (c) 2014 Sanzida Tasnim (email: tasnim5sanzida@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

/**
 * Cant call the file directly
 */

if ( !defined( 'ABSPATH' ) ){
    exit;
}
if ( is_admin() ){
    require_once dirname(__FILE__) . "/includes/admin/profile_update.php";
}
function usfa_content_add($content){
    global $post;

    $author = get_user_by("id" , $post->post_author);

    $bio       = get_user_meta($author->ID , "description" , true);
    $twitter   = get_user_meta($author->ID , "twitter" , true);
    $linkedIn  = get_user_meta($author->ID , "linkedIn" , true);
    $facebook  = get_user_meta($author->ID , "facebook" , true);

    ob_start();
    ?>
    <div class="usfa-bio-wrap">

        <div class="avatar-image">
            <?php echo get_avatar( $author->ID, 64 ); ?>
        </div>

        <div class="usfa-bio-content">
            <div class="author-name"><?php echo $author->display_name; ?></div>

            <div class="usfa-author-bio">
                <?php echo wpautop( wp_kses_post( $bio ) ); ?>
            </div>

            <ul class="usfa-socials">
                <?php if ( $twitter ) { ?>
                    <li><a href="<?php echo esc_url( $twitter ); ?>"><?php _e( 'Twitter', 'user-field-add' ); ?></a></li>
                <?php } ?>

                <?php if ( $facebook ) { ?>
                    <li><a href="<?php echo esc_url( $facebook ); ?>"><?php _e( 'Facebook', 'user-field-add' ); ?></a></li>
                <?php } ?>

                <?php if ( $linkedIn ) { ?>
                    <li><a href="<?php echo esc_url( $linkedIn ); ?>"><?php _e( 'LinkedIn', 'user-field-add' ); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php

    $bio_content = ob_get_clean();
    return $content . $bio_content;
}
add_filter("the_content" , "usfa_content_add");

/**
 * custom css file enqueue
 * @return void
 */
function usfa_enqueue_script(){
    wp_enqueue_style( "custom-usfa-css" , plugins_url("/assets/css/style.css", __FILE__));
}
add_action("wp_enqueue_scripts", "usfa_enqueue_script");