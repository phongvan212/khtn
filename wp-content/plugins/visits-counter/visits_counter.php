<?php
/**

Plugin Name: Simple Visitors Counter
Plugin URI: http://kaplonski.pl/
Description: Simple visitors and online users counter on Your site
Version: 1.5.4
Author: Sławek Kapłoński
Author URI: http://kaplonski.pl/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

include_once 'visits_counter_option.class.php';
include_once 'visits_counter_settings.class.php';
include_once 'visits_counter_adminPage.class.php';
include_once 'visits_counter_counter.class.php';
include_once 'visits_counter_widget_class.php';
include_once 'visits_counter_whoisdata.class.php';

load_plugin_textdomain('visits_counter', false, basename( dirname( __FILE__ ) ) . '/languages/');


function vc_installation(){
    $adminPage = new vs_adminPage();
    $adminPage->installation();
}

function vc_adminInit(){
    $adminPage = new vs_adminPage();
    $adminPage->adminInit();
}

function vc_adminMenu(){
    $adminPage = new vs_adminPage();
    $main_page_slug = "visits-counter";
    add_options_page("Visits Counter", "Visit Counter", "manage_options", $main_page_slug, array(&$adminPage, 'dislay_options_page'));
}

function vc_initWidget($args){
    $widget = new visits_counter_widget();
    $widget->drawWidget($args);
}

function vs_initShortcode(){
    ob_start();
    $widget = new visits_counter_widget();
    echo $widget->displayWidgetContent();
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}

function vc_ajaxGetIpInfo(){
	$whois = new vs_whoisdata($_POST['ip']);
	echo $whois->getIPData();
	die();
}

register_activation_hook(__FILE__, 'vc_installation');

add_action('admin_init', 'vc_adminInit');
add_action('admin_menu', 'vc_adminMenu');

add_action('wp_ajax_vccheckIP', 'vc_ajaxGetIpInfo');

wp_register_sidebar_widget('visits_counter_widget', __('Visits Counter Widget','visits_counter'), 'vc_initWidget');

add_shortcode('visits_counter', 'vs_initShortcode');
?>
