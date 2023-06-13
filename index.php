<?php
/**
 * Writers.io
 *
 * @package   Writers.io
 * @author    Shane Stevens.
 * @copyright Stellenbosch Business School | @2023
 *
 * @wordpress-plugin 
 * Plugin Name: Writers.io
 * Description: This is a game...idk what else to add here :)
 * Version: 1.0
 * Author: Shane Stevens.
 * License: Free
 */

// _________________________________________
// IMPORT ALL FILES HERE !IMPORTANT HAS TO BE ONTOP OF THE PAGE BEFORE ANY OTHER CODE IS ADDED
// eg.  require_once plugin_dir_path(__FILE__) . './file.php';

// 1CREATE
require_once plugin_dir_path(__FILE__) . './includes/1create/admin.php';

// 2READ
require_once plugin_dir_path(__FILE__) . './includes/2read/admin.php'; 
require_once plugin_dir_path(__FILE__) . './includes/2read/answers.php'; 
require_once plugin_dir_path(__FILE__) . './includes/2read/random-generator.php';
require_once plugin_dir_path(__FILE__) . './includes/2read/results.php';

// 3UPDATE
require_once plugin_dir_path(__FILE__) . './includes/3update/admin.php';

// 4DELETE
require_once plugin_dir_path(__FILE__) . './includes/4delete/delete.php';




// _________________________________________
// CREATE DATABASE TABLES ON ACTIVATING PLUGIN
function create_table_on_activate()
{
    // connect to WordPress database
    global $wpdb;

    // set table names
    $admin = $wpdb->prefix . 'admin'; // The table name is wp_admin
    $answers = $wpdb->prefix . 'answers'; // The table name is wp_answers

    $charset_collate = $wpdb->get_charset_collate();

    // mysql create tables query
    $sql = "CREATE TABLE $admin (
                id INT(10) PRIMARY KEY AUTO_INCREMENT,
                topic VARCHAR(100) NOT NULL,
                t_description VARCHAR(255) NOT NULL
            ) $charset_collate;";

$sql .= "CREATE TABLE $answers (
    id INT(10) PRIMARY KEY AUTO_INCREMENT,
    groupname VARCHAR(255) NOT NULL,
    participants VARCHAR(255) NOT NULL,
    answer_text VARCHAR(255) NOT NULL,
    files VARCHAR(255) NOT NULL,
    user_id INT(10) NOT NULL,
    user_name VARCHAR(255) NOT NULL
) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $result = dbDelta($sql);
    if (is_wp_error($result)) {
        echo 'There was an error creating the tables';
        return;
    }
}

register_activation_hook(__FILE__, 'create_table_on_activate');







// _________________________________________
// (!IMPORTANT DO NOT TOUCH)  CREATE PAGE FUNCTION  (!IMPORTANT DO NOT TOUCH)
function create_page($title_of_the_page, $content, $parent_id = NULL)
{
	$objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
	if (!empty($objPage)) {
		echo "Page already exists:" . $title_of_the_page . "<br/>";
		return $objPage->ID;
	}
	$page_id = wp_insert_post(
		array(
			'comment_status' => 'close',
			'ping_status' => 'close',
			'post_author' => 1,
			'post_title' => ucwords($title_of_the_page),
			'post_name' => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
			'post_status' => 'publish',
			'post_content' => $content,
			'post_type' => 'page',
			'post_parent' => $parent_id //'id_of_the_parent_page_if_it_available'
		)
	);
	echo "Created page_id=" . $page_id . " for page '" . $title_of_the_page . "'<br/>";
	return $page_id;
}




// _________________________________________
// ACTIVATE PLUGIN
function on_activating_your_plugin()
{
    // _________________________________________
	//  CREATE WP PAGES AUTOMATICALLY ANLONG WITH SHORT CODE TO DISPLAY THE CONTENT
	// eg.  create_page('page-name', '[short-code]');
    // _________________________________________
    
    // 1CREATE
    create_page('admin-create', '[admin-create]');

    // 2READ
    create_page('admin', '[admin]');
    create_page('answers', '[answers]');
    create_page('random-generator', '[random-card]');
    create_page('results', '[results]');

    // 3UPDATE
    create_page('admin-update', '[admin-update]');

}
register_activation_hook(__FILE__, 'on_activating_your_plugin');




// _________________________________________
// DEACTIVATE PLUGIN
function on_deactivating_your_plugin()
{
    // _________________________________________
	//  DELETE WP PAGES AUTOMATICALLY ANLONG WITH SHORT CODE TO DISPLAY THE CONTENT
	// eg. 	
    // $page_name = get_page_by_path('page_name');
	// wp_delete_post($page_name->ID, true);
    // _________________________________________

    // 1CREATE
   $admin_create = get_page_by_path('admin-create');
	wp_delete_post($admin_create->ID, true); // admin create

    // 2READ
    $admin = get_page_by_path('admin');
	wp_delete_post($admin->ID, true); // admin
    $answers = get_page_by_path('answers');
	wp_delete_post($answers->ID, true); // answers
    $random_generator = get_page_by_path('random-generator');
	wp_delete_post($random_generator->ID, true); // random generator
    $results = get_page_by_path('results');
	wp_delete_post($results->ID, true); // results

    // 3UPDATE
    $admin_update = get_page_by_path('admin-update');
	wp_delete_post($admin_update->ID, true); // admin update

}
register_deactivation_hook(__FILE__, 'on_deactivating_your_plugin');

?>