<?php

/**
 * Add new page in admin menu
 */
function my_admin_menu() {
    add_menu_page(
        __( 'Sync ACF Blocks', 'my-textdomain' ),
        __( 'Sync ACF Blocks', 'my-textdomain' ),
        'manage_options',
        'sync-acf',
        'my_admin_page_contents',
        'dashicons-update-alt',
        80
    );
}
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_page_contents() {
    echo '<h1>Synchroniser les blocs ACF</h1>';

    $sync = isset($_GET['sync']) && $_GET['sync'] ? $_GET['sync'] : FALSE;

    if ($sync) {
        echo '<p>Synchronisation en cours...</p>';

        sync_acf_blocks();

        echo '<a href="?page=sync-acf">Revenir à la page de synchronisation</a>';
    } else {
        echo '<a href="?page=sync-acf&sync=true">Synchroniser les blocs ACF</a>';
    }
}

function sync_acf_blocks() {
    $path = get_template_directory() . '/acf-json';
    $acf_json_data = file_get_contents($path . '/blocks/blocks.json');
    $new_blocks = [];

    if ($acf_json_data) {
        $custom_fields = json_decode($acf_json_data, true);

        foreach ($custom_fields as $custom_field) {
            $exists = is_field_group_exists($custom_field['key']);
            $new_blocks[] = $exists;

            if (!$exists) {
                acf_import_field_group($custom_field);
                echo '<p>✔️ Ajout du bloc ' . $custom_field['title'] . '...</p>';
            }
        }
    }

    if (in_array(true, $new_blocks) || empty($new_blocks)) {
        echo '<p>Aucun nouveau bloc à synchroniser.</p>';
    }
}

function is_field_group_exists($key) {
    $exists = false;
    $fields_groups = acf_get_field_groups();
    $field_groups = get_posts(['post_type' => 'acf-field-group']);

    if ($field_groups) {
        foreach($field_groups as $field_group) {
            if ($field_group->post_name === $key) $exists = true;
        }
    }

    return $exists;
}
