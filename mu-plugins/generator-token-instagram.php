<?php
/*
Plugin Name:  Generator token instagram
Plugin URI:   https://roots.io/bedrock/
Description:  Reset token Instagram
Version:      1.0.0
Author:       Roots
Author URI:   https://roots.io/
License:      MIT License
*/

add_action('init', 'gti_init');
function gti_init()
{
    if (!get_option('gti_init')) {
        add_option('clientid', $_POST['clientid']);
        add_option('userid', $_POST['userid']);
        add_option('accesstoken', $_POST['accesstoken']);
        add_option('gti_init', 1);
        setlocale(LC_TIME, 'fr_FR');
        date_default_timezone_set('Europe/Paris');
        add_option('api_generate_token_date', strftime("%d/%m/%Y"));
    }
}

add_action('admin_menu', 'gti_menu');
function gti_menu()
{
    add_menu_page(
        __('Generator token Instagram'),
        __('GTI'),
        'manage_options',
        'generator-token-instagram',
        'gti_page',
        'dashicons-instagram',
        80
    );
}

function gti_page()
{
    gti_init();
    gti_update();

    $token = isset($_GET['token']) && $_GET['token'] ? $_GET['token'] : FALSE;
    if ($token) gti_api();

    setlocale(LC_TIME, 'fr_FR');
    date_default_timezone_set('Europe/Paris');
    $date_now = get_option('api_generate_token_date');
    $lifedate = date_interval_create_from_date_string('60 days');

    $current_date = date_create_from_format('d/m/Y', $date_now);
    $end_date = date_add(date_create_from_format('d/m/Y', $date_now), $lifedate);
    $datediff = date_diff($current_date, $end_date);

    echo '<h1>Generator token Instagram</h1>';
    echo '<form action="?page=generator-token-instagram" method="POST">';
    echo '<div>
    <label for="clientid">Client ID :</label>
    <input type="text" name="clientid" id="clientid" value="' . get_option('clientid') . '">
    </div>';
    echo '<div>
    <label for="userid">User ID : </label>
    <input type="text" name="userid" id="userid" value="' . get_option('userid') . '">
    </div>';
    echo '<div>
    <label for="accesstoken">Access Token : </label>
    <input type="text" name="accesstoken" id="accesstoken" value="' . get_option('accesstoken') . '">
    </div>';
    echo '<a href="?page=generator-token-instagram&token=true">Réinitialiser le token</a>';
    echo '<div>Dernière réinitialisation : ' . get_option('api_generate_token_date') . '</div>';
    echo '<div>Date de fin : ' . $end_date->format('d/m/Y') . '</div>';
    echo '<div>Il reste : ' . $datediff->days . ' jours</div>';
    submit_button();
    echo '</form>';
}

function gti_update()
{
    $empty = false;
    if (empty($_POST['clientid']) || empty($_POST['userid']) || empty($_POST['accesstoken'])) $empty = true;
    if (!$empty) {
        update_option('clientid', $_POST['clientid']);
        update_option('userid', $_POST['userid']);
        update_option('accesstoken', $_POST['accesstoken']);
    }
}

function gti_api()
{
    $url = 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . get_option(['accesstoken']);
    $content = file_get_contents($url);
    $content = json_decode($content);
    update_option('accesstoken', $content->access_token);
    setlocale(LC_TIME, 'fr_FR');
    date_default_timezone_set('Europe/Paris');
    update_option('api_generate_token_date', strftime("%d/%m/%Y"));
    echo "<script>location.href = '?page=generator-token-instagram';</script>";
}
