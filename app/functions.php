<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/functions/libs/context.php');
require_once(__DIR__ . '/functions/routes.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

define('ENV', $_ENV);

/**
 * --------------------------------------------------------------------------
 * Functions
 * --------------------------------------------------------------------------
 *
 */
array_map(function ($file) {
    require_once get_theme_file_path("functions/") . "{$file}.php";
}, ['helpers', 'setup', 'enqueues', 'filters', 'acf', 'login', 'api/main']);

array_map(function ($file) {
    require_once get_theme_file_path("functions/") . "{$file}.php";
}, ['admin/pages/example/main', 'admin/pages/bookings/main']);

/**
 * --------------------------------------------------------------------------
 * Post Types
 * --------------------------------------------------------------------------
 *
 */
array_map(function ($file) {
    require_once get_theme_file_path("registers/post-types/") . "{$file}";
}, __autoload_functions_by_dir('/registers/post-types'));


/**
 * --------------------------------------------------------------------------
 * Taxonomies
 * --------------------------------------------------------------------------
 *
 */
array_map(function ($file) {
    require_once get_theme_file_path("registers/taxonomies/") . "{$file}";
}, __autoload_functions_by_dir('/registers/taxonomies'));

/**
 * --------------------------------------------------------------------------
 * Plguins
 * --------------------------------------------------------------------------
 *
 */

require_once(__DIR__ . '/plugins/main.php');


add_action('login_init', 'no_weak_password_header');
add_action('admin_head', 'no_weak_password_header');
function no_weak_password_header()
{
echo"<style>.pw-weak{display:none!important}</style>";
echo'<script>document.getElementById("pw-checkbox").disabled = true;</script>';
}
 
function wpse_159462_login_form() {
    echo <<<html
    <script>
        document.getElementById( "user_pass" ).autocomplete = "off";
        document.getElementById( "user_login" ).autocomplete = "off";
    </script>
    html;
}
add_action( 'login_form', 'wpse_159462_login_form' );
