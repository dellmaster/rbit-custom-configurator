<?php

// START Option Group custom post type

function rbit_italiastyle_options_group_custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'IS Options group', 'Post Type General Name', 'rbit-custom-configurator' ),
        'singular_name'       => _x( 'IS Group', 'Post Type Singular Name', 'rbit-custom-configurator' ),
        'menu_name'           => __( 'IS Groups', 'rbit-custom-configurator' ),
        'parent_item_colon'   => __( 'Parent Group', 'rbit-custom-configurator' ),
        'all_items'           => __( 'All Groups', 'rbit-custom-configurator' ),
        'view_item'           => __( 'View Group', 'rbit-custom-configurator' ),
        'add_new_item'        => __( 'Add New Group', 'rbit-custom-configurator' ),
        'add_new'             => __( 'Add New', 'rbit-custom-configurator' ),
        'edit_item'           => __( 'Edit Group', 'rbit-custom-configurator' ),
        'update_item'         => __( 'Update Group', 'rbit-custom-configurator' ),
        'search_items'        => __( 'Search Group', 'rbit-custom-configurator' ),
        'not_found'           => __( 'Not Found', 'rbit-custom-configurator' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'rbit-custom-configurator' ),
    );


// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'IS Options Group', 'rbit-custom-configurator' ),
        'description'         => __( 'Options Groups for ItaliaStyle', 'rbit-custom-configurator' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        //'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 35,
        'can_export'          => true,
        'has_archive'         => true,
        'rewrite'     => array( 'slug' => 'options-group' ), // my custom slug
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    register_post_type( 'is_options_group', $args );
}

// END Option Group custom post type


// START Option custom post type

function rbit_italiastyle_option_custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'IS Option', 'Post Type General Name', 'rbit-custom-configurator' ),
        'singular_name'       => _x( 'IS Option', 'Post Type Singular Name', 'rbit-custom-configurator' ),
        'menu_name'           => __( 'IS Options', 'rbit-custom-configurator' ),
        'parent_item_colon'   => __( 'Parent Option', 'rbit-custom-configurator' ),
        'all_items'           => __( 'All Options', 'rbit-custom-configurator' ),
        'view_item'           => __( 'View Option', 'rbit-custom-configurator' ),
        'add_new_item'        => __( 'Add New Option', 'rbit-custom-configurator' ),
        'add_new'             => __( 'Add New', 'rbit-custom-configurator' ),
        'edit_item'           => __( 'Edit Option', 'rbit-custom-configurator' ),
        'update_item'         => __( 'Update Option', 'rbit-custom-configurator' ),
        'search_items'        => __( 'Search Option', 'rbit-custom-configurator' ),
        'not_found'           => __( 'Not Found', 'rbit-custom-configurator' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'rbit-custom-configurator' ),
    );


// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'IS Option', 'rbit-custom-configurator' ),
        'description'         => __( 'Options for ItaliaStyle', 'rbit-custom-configurator' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        //'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 35,
        'can_export'          => true,
        'has_archive'         => true,
        'rewrite'     => array( 'slug' => 'option' ), // my custom slug
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    register_post_type( 'is_option', $args );
}
// END Option custom post type


// START Option value custom post type

function rbit_italiastyle_option_value_custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'IS Option value', 'Post Type General Name', 'rbit-custom-configurator' ),
        'singular_name'       => _x( 'IS Option value', 'Post Type Singular Name', 'rbit-custom-configurator' ),
        'menu_name'           => __( 'IS Option values', 'rbit-custom-configurator' ),
        'parent_item_colon'   => __( 'Parent Option value', 'rbit-custom-configurator' ),
        'all_items'           => __( 'All Option values', 'rbit-custom-configurator' ),
        'view_item'           => __( 'View Option value', 'rbit-custom-configurator' ),
        'add_new_item'        => __( 'Add New Option value', 'rbit-custom-configurator' ),
        'add_new'             => __( 'Add New', 'rbit-custom-configurator' ),
        'edit_item'           => __( 'Edit Option value', 'rbit-custom-configurator' ),
        'update_item'         => __( 'Update Option value', 'rbit-custom-configurator' ),
        'search_items'        => __( 'Search Option value', 'rbit-custom-configurator' ),
        'not_found'           => __( 'Not Found', 'rbit-custom-configurator' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'rbit-custom-configurator' ),
    );


// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'IS Option value', 'rbit-custom-configurator' ),
        'description'         => __( 'Option values for ItaliaStyle', 'rbit-custom-configurator' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        //'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 35,
        'can_export'          => true,
        'has_archive'         => true,
        'rewrite'     => array( 'slug' => 'option-value' ), // my custom slug
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    register_post_type( 'is_option_value', $args );
}

// End Option value custom post type

// START Custom filter by option for value
add_action('restrict_manage_posts', 'rbit_filter_option_values_by_acf_option');
function rbit_filter_option_values_by_acf_option() {
    global $typenow;
    $post_type = 'is_option_value'; // change to your post type
    $taxonomy  = 'is_option_filter'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';

        $args = array(
            'post_type'=>'is_option',
            //'post__in'=>$option_ids,
            'status'=>'publish',
            'orderby' => 'post_title',
            'order'=>'ASC',
            'posts_per_page'=>-1
        );
        //query_posts($args);
        $news_query = new WP_Query( $args );
        $option_posts = $news_query->posts;

        //$info_taxonomy = get_taxonomy($taxonomy);
        echo "<select name='$taxonomy' id='$taxonomy' class='postform'>";
        echo "<option value=''>All Options</option>";
        foreach ($option_posts as $option_post) {
            $option_posts_array[$option_post->ID] = $option_post;
            echo '<option value='. $option_post->ID. ($_GET[$taxonomy] == $option_post->ID ? ' selected="selected"' : '').'>' . $option_post->post_title .'</option>';
        }

        echo "</select>";


    }
}

add_filter('parse_query', 'rit_option_filter_query');
function rit_option_filter_query($query) {
    global $pagenow;
    $post_type = 'is_option_value'; // change to your post type
    $taxonomy  = 'is_option_filter'; // change to your taxonomy
    //$q_vars    = $query->query_vars;
    if ( $pagenow == 'edit.php' && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == $post_type && isset($_GET[$taxonomy]) && is_numeric($_GET[$taxonomy]) && $_GET[$taxonomy] != 0 ) {
        $option_id = intval($_GET[$taxonomy]);
        //unset($query->query_vars[$taxonomy]);

        $meta_query = array(
            array(
                'key' => 'option', // name of custom field
                'value' => '"' . $option_id . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        );

        $query->set( 'meta_query', $meta_query );

        //print_r($query);
    }

}

//add_action( 'pre_get_posts', 'rit_option_filter_query2' );
function rit_option_filter_query2( $query ) {
    global $pagenow;
    $post_type = 'is_option_value'; // change to your post type
    $filter_name  = 'is_option_filter'; // change to your taxonomy
    //$q_vars    = &$query->query_vars;
    if ( $pagenow == 'edit.php' && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == $post_type && isset($query->query_vars[$filter_name]) && is_numeric($query->query_vars[$filter_name]) && $query->query_vars[$filter_name] != 0 ) {
        $option_id = intval($query->query_vars[$filter_name]);
        //unset($query->query_vars[$filter_name]);

        $meta_query = array(
            array(
                'key' => 'option', // name of custom field
                'value' => '"' . $option_id . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        );

        $query->set( 'meta_query', $meta_query );
        //$query->meta_query =  $meta_query ;

        //print_r($query);
    }

}
// END Custom filter by option for value


// START Custom filter by group for option
add_action('restrict_manage_posts', 'rbit_filter_options_by_acf_group');
function rbit_filter_options_by_acf_group() {
    global $typenow;
    $post_type = 'is_option'; // change to your post type
    $taxonomy  = 'is_group_filter'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';

        $args = array(
            'post_type'=>'is_options_group',
            //'post__in'=>$option_ids,
            'status'=>'publish',
            'orderby' => 'post_title',
            'order'=>'ASC',
            'posts_per_page'=>-1
        );
        //query_posts($args);
        $news_query = new WP_Query( $args );
        $option_posts = $news_query->posts;

        //$info_taxonomy = get_taxonomy($taxonomy);
        echo "<select name='$taxonomy' id='$taxonomy' class='postform'>";
        echo "<option value=''>All Option Groups</option>";
        foreach ($option_posts as $option_post) {
            $option_posts_array[$option_post->ID] = $option_post;
            echo '<option value='. $option_post->ID. ($_GET[$taxonomy] == $option_post->ID ? ' selected="selected"' : '').'>' . $option_post->post_title .'</option>';
        }

        echo "</select>";

    }
}

add_filter('parse_query', 'rit_group_filter_query');
function rit_group_filter_query($query) {
    global $pagenow;
    $post_type = 'is_option'; // change to your post type
    $taxonomy  = 'is_group_filter'; // change to your taxonomy
    //$q_vars    = $query->query_vars;
    if ( $pagenow == 'edit.php' && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == $post_type && isset($_GET[$taxonomy]) && is_numeric($_GET[$taxonomy]) && $_GET[$taxonomy] != 0 ) {
        $group_id = intval($_GET[$taxonomy]);
        //unset($query->query_vars[$taxonomy]);

        $meta_query = array(
            array(
                'key' => 'option_group', // name of custom field
                'value' => '"' . $group_id . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        );

        $query->set( 'meta_query', $meta_query );

        //print_r($query);
    }

}

// END Custom filter by option for value


// START Register custom tumb size for values
add_image_size( 'values-tumb', 100, 100, true );
// START Register custom tumb size for values

