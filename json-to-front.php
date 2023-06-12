<?php

function rbit_get_json_for_front($product_id) {
    $groups_array = [];
    $product_meta_array = get_post_meta($product_id, 'rbit_product_values');
    $groups_array = json_decode($product_meta_array[0], true);

    //get groups, options and values ids for WP_Query
    $group_ids = [];
    $option_ids = [];
    $value_ids = [];
    foreach ($groups_array as $group_id => $options) {
        $group_ids[] = $group_id;
        foreach ($options as $option_id => $values) {
            $option_ids[] = $option_id;
            foreach ($values as $value_id => $costs) {
                $value_ids[] = $value_id;
            }
        }

    }

    $args = array(
        'post_type'=>'is_options_group',
        'post__in'=>$group_ids,
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $group_posts = $news_query->posts;
    $group_posts_array = [];
    foreach ($group_posts as $group_post) {
        $group_posts_array[$group_post->ID] = $group_post;
    }


    $args = array(
        'post_type'=>'is_option',
        'post__in'=>$option_ids,
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $option_posts = $news_query->posts;
    $option_posts_array = [];
    foreach ($option_posts as $option_post) {
        $option_posts_array[$option_post->ID] = $option_post;
    }


    $args = array(
        'post_type'=>'is_option_value',
        'post__in'=>$value_ids,
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $value_posts = $news_query->posts;
    $value_posts_array = [];
    foreach ($value_posts as $value_post) {
        $value_posts_array[$value_post->ID] = $value_post;
    }

    $output_array = [];

    foreach ($groups_array as $group_id => $options) {

        $current_group = $group_posts_array[$group_id];
        $output_array[$group_id]['title'] = $current_group->post_title;

        foreach ($options as $option_id => $values) {
            $current_option = $option_posts_array[$option_id];
            $output_array[$group_id]['options'][$option_id]['title'] = $current_option->post_title;

            foreach ($values as $value_id => $cost) {
                $current_value = $value_posts_array[$value_id];
                $output_array[$group_id]['options'][$option_id]['values'][$value_id]['title'] = $current_value->post_title;

                if( has_post_thumbnail( $value_id) ) {
                    //$output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = get_the_post_thumbnail_url($current_value, 'post-thumbnail');
                    $output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = wp_get_attachment_image_url($current_value, 'values-tumb');
                    //$output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = get_the_post_thumbnail_url($current_value, 'values-tumb');
                }
                else {
                    $output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = '';
                }

                $output_array[$group_id]['options'][$option_id]['values'][$value_id]['cost'] = $cost;

            }
        }

    }

    return $output_array;

}


add_action( 'rest_api_init', function(){

    // namespace
    $namespace = 'rbit-configurator/v1';

    // route
    $route = '/product-options/(?P<product_id>\d+)';

    // route endpoint
    $route_params = [
        'methods'  => 'GET',
        'callback' => 'rbit_configurator_data_for_product',
        'args'     => [
            'product_id' => [
                'type'    => 'integer', // it must be integer
                //'default' => 10,        // default
                'required' => true,
            ],
        ],
        'permission_callback' => '__return_true',
    ];

    register_rest_route( $namespace, $route, $route_params );

} );


function rbit_configurator_data_for_product( WP_REST_Request $request ){

    $posts = get_posts( [
        'author' => (int) $request['id'],
    ] );

    $response = rbit_get_json_for_front($request['product_id']);

    if ( count( $response ) < 1 ) {
        return new WP_Error( 'no_product_configurator_data', 'No product configurator data', [ 'status' => 404 ] );
    }

    return json_encode($response);
}

function rbit_get_json_for_front_v2($product_id) {
    $groups_array = [];
    $product_meta_array = get_post_meta($product_id, 'rbit_product_values');
    $groups_array = json_decode($product_meta_array[0], true);

    //get groups, options and values ids for WP_Query
    $group_ids = [];
    $option_ids = [];
    $value_ids = [];
    foreach ($groups_array as $group_id => $options) {
        $group_ids[] = $group_id;
        foreach ($options as $option_id => $values) {
            if(is_numeric($option_id)) {
                $option_ids[] = $option_id;
                foreach ($values as $value_id => $costs) {
                    $value_ids[] = $value_id;
                }
            }
        }

    }

    $all_ids = array_merge($group_ids, $option_ids, $value_ids);

    $args = array(
        'post_type'=>['is_options_group', 'is_option', 'is_option_value'], //'is_options_group',
        'post__in'=>$all_ids,
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $conf_posts_result = $news_query->posts;

    foreach ($conf_posts_result as $conf_post) {
        $conf_posts[$conf_post->ID] = $conf_post;
    }


    $output_array = [];
    $step = 1;
    foreach ($groups_array as $group_id => $options) {

        $current_group = $conf_posts[$group_id];
        $output_array[$group_id]['id'] = $group_id;
        $output_array[$group_id]['title'] = $current_group->post_title;
        $output_array[$group_id]['group_description'] = $groups_array[$group_id]['group_description'];
        $output_array[$group_id]['step'] = $step;

        foreach ($options as $option_id => $values) {
            if(is_numeric($option_id)) {
                $current_option = $conf_posts[$option_id];
                $output_array[$group_id]['options'][$option_id]['id'] = $option_id;
                $output_array[$group_id]['options'][$option_id]['title'] = $current_option->post_title;

                foreach ($values as $value_id => $cost) {
                    $current_value = $conf_posts[$value_id];
                    $output_array[$group_id]['options'][$option_id]['values'][$value_id]['id'] = $value_id;
                    $output_array[$group_id]['options'][$option_id]['values'][$value_id]['title'] = $current_value->post_title;

                    if (has_post_thumbnail($value_id)) {
                        //$output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = get_the_post_thumbnail_url($current_value, 'post-thumbnail');
                        //$output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = get_the_post_thumbnail_url($current_value, 'values-tumb');
                        $output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = get_the_post_thumbnail_url(
                            $current_value,
                            'medium'
                        );
                        //$output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = wp_get_attachment_image_url($current_value, 'values-tumb');
                    } else {
                        $output_array[$group_id]['options'][$option_id]['values'][$value_id]['img'] = '';
                    }

                    $output_array[$group_id]['options'][$option_id]['values'][$value_id]['cost'] = $cost;
                }
            }
        }
        $step++;
    }

    return array('groups' => $output_array);

}

add_action( 'rest_api_init', function(){

    // namespace
    $namespace = 'rbit-configurator/v2';

    // route
    $route = '/product-options/(?P<product_id>\d+)';

    // route endpoint
    $route_params = [
        'methods'  => 'GET',
        'callback' => 'rbit_configurator_data_for_product_v2',
        'args'     => [
            'product_id' => [
                'type'    => 'integer', // it must be integer
                //'default' => 10,        // default
                'required' => true,
            ],
        ],
        'permission_callback' => '__return_true',
    ];

    register_rest_route( $namespace, $route, $route_params );

} );


function rbit_configurator_data_for_product_v2( WP_REST_Request $request ){

    $posts = get_posts( [
        'author' => (int) $request['id'],
    ] );

    $response = rbit_get_json_for_front_v2($request['product_id']);

    if ( count( $response ) < 1 ) {
        return new WP_Error( 'no_product_configurator_data', 'No product configurator data', [ 'status' => 404 ] );
    }

   //return json_encode($response);
    return $response;
}


//function rbitInitCors( $value ) {
//    $origin_url = '*';
//
//    // Check if production environment or not
//    /*if (ENVIRONMENT === 'production') {
//        $origin_url = 'https://linguinecode.com';
//    }*/
//
//    //header( 'Access-Control-Allow-Origin: ' . $origin_url );
//    header("Access-Control-Allow-Origin: *");
//    header( 'Access-Control-Allow-Methods: GET' );
//    //header( 'Access-Control-Allow-Credentials: true' );
//    header( 'Access-Control-Allow-Headers: Content-Type' );
//    return $value;
//}
//
//add_action( 'rest_api_init', function() {
//
//    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
//
//    add_filter( 'rest_pre_serve_request', 'rbitInitCors');
//}, 15 );
//
//$allow_headers = array(
//    'Authorization',
//    'X-WP-Nonce',
//    'Content-Disposition',
//    'Content-MD5',
//    'Content-Type',
//);
//
//
//$allow_headers = apply_filters( 'rest_allowed_cors_headers', $allow_headers );
