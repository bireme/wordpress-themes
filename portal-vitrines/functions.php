<?php

/*
Plugin Name: VHL Unfiltered MU
Description: Modificaton of 'Unfiltered MU' plugin that allow adds the <code>unfiltered_html</code> capablitiy to Administrators so that content posted by users with those roles is not filtered by KSES; Embeds, Iframe, etc. are preserved.
Author: BIREME based on Automattic Unfiltered MU Plugin
Version: 1.3.1
Author URI: http://www.bireme.org/
*/

/* 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License (v2) as published 
    by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Remove KSES if user has unfiltered_html cap
if(!function_exists('kses_init')):
function kses_init() {
    if ( current_user_can( 'unfiltered_html' ) )
        kses_remove_filters();
}
add_action( 'init', 'kses_init', 11 );
add_action( 'set_current_user', 'kses_init', 11 );
endif;

if(!function_exists('unfilter_roles')):
function unfilter_roles() {
    // Makes sure $wp_roles is initialized
    get_role( 'administrator' );

    global $wp_roles;
    // Dont use get_role() wrapper, it doesn't work as a one off.
    // (get_role does not properly return as reference)
    $wp_roles->role_objects['administrator']->add_cap( 'unfiltered_html' );
}
endif;

if(!function_exists('unfilter_roles_one_time')):
function unfilter_roles_one_time() {
    get_role( 'administrator' );

    global $wp_roles, $current_user;

    $use_db = $wp_roles->use_db;
    $wp_roles->use_db = false; // Don't store in db.  Just do a one off mod to the role.
    unfilter_roles(); // Add caps for this page load only: - ^^^^^^^
    $wp_roles->use_db = $use_db;

    if ( is_user_logged_in() ) // Re-prime the current user's caps
        $current_user->_init_caps();
}
add_action( 'init', 'unfilter_roles_one_time', 1 );
endif;

// Add the unfiltered_html capability back in to WordPress 3.0 multisite.
if(!function_exists('unfilter_multisite')):
function unfilter_multisite( $caps, $cap, $user_id, $args ) {
    if ( $cap == 'unfiltered_html' ) {
        unset( $caps );
        $caps[] = $cap;
    }
    return $caps;
}
add_filter( 'map_meta_cap', 'unfilter_multisite', 10, 4 );
endif;

if(!function_exists('http_request_local')):
function http_request_local( $args, $url ) {
    if ( preg_match('/xml|rss|feed/', $url) ) {
        $args['reject_unsafe_urls'] = false;
    }

   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );
endif;

?>
