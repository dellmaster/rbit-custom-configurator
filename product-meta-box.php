<?php
// add new tab to product edit page
add_filter('woocommerce_product_data_tabs', function($tabs) {
    $tabs['rbit_configurator'] = [
        'label' => __('Configurator', 'rbit-custom-configurator'),
        'target' => 'configurator_product_data',
        'class' => ['hide_if_external'],
        'priority' =>  75
    ];
    return $tabs;
});

add_action('woocommerce_product_data_panels','rbit_options_product_tab_display');

function rbit_options_product_tab_display() {
    global $post;
    ?>
    <div id="configurator_product_data" class="panel woocommerce_options_panel hidden">
        <p style="color: #ff0b0b;"><?php echo __('Check to clear configurator data', 'rbit-custom-configurator'); ?>: <input type="checkbox" name="rbit_configurator_clear" value="clear" /></p>
        <?php  rbit_options_product_block_display();  ?>

        <input type="hidden" name="rbit_configurator_save" value="save">
    </div>

    <?php

}

// START display options metabox for product

//add_action( 'woocommerce_product_options_advanced', 'rbit_options_product_block_display' );
function rbit_options_product_block_display(){
    global $post;

    $groups_array = [];
    $product_meta_array = get_post_meta($post->ID, 'rbit_product_values');
    $groups_array = json_decode($product_meta_array[0], true);

    $args = array(
        'post_type'=>'is_options_group',
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $groups = $news_query->posts;


    ?>

    <div class="options_group rbit-custom-options">
        <div class="rbit-all-groups-block-header">
            <p class="form-field _regular_price_field ">
                <label for="_groups_list"><?php echo __( 'Group', 'rbit-custom-configurator' ) ?></label>
                <select name="_groups_list" class=" rbit-groups-list" id="_groups_list" >
                    <?php foreach ($groups as $group) {
                        echo '<option value="'.$group->ID.'">'.$group->post_title.'</option>';
                    }
                    ?>

                </select>

                <button type="button" class="button add_custom_attribute rbit_add_group" id="rbit_add_group" >Add group</button>

                <span class="rbit-item-error" style="display: none;" id="group_error"><?php echo __( 'This Group already in list!', 'rbit-custom-configurator' ) ?></span>

            </p>
        </div>

        <div class="rbit-all-groups-block-content rbit-conf-content" id="rbit_all_groups_block_content">
            <?php
            // display product groups
            foreach ($groups_array as $group_id => $group_array) {
                display_group_block($group_id, $group_array);
            }
            ?>
        </div>

    </div>

    <style>

    </style>

<?php
    //var_dump($groups_array);

}

// END display custom metabox for product



// START Ajax response for group selected

add_action("wp_ajax_rbit_get_options_list", "rbit_get_options_list");
function rbit_get_options_list(){
    //$params_in = json_encode($_POST);
    //print_r($params_in);
    //wp_die();
    $group_id = $_POST['group_id'];

    display_group_block($group_id);

    wp_die();
}
// END Ajax response for group selected

// START display group block with options list
function display_group_block($group_id, $group_array = false) {
    $group = get_post($group_id);

    //if (!$group) wp_die();

    $args = array(
        'post_type'=>'is_option',
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1,
        'meta_query' => array(
            array(
                'key' => 'option_group', // name of custom field
                'value' =>  '"' . $group_id . '"' , // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    //echo 'options - ' . count($news_query);
    //print_r($news_query);
    $options = $news_query->posts;

    ?>
    <div class="rbit-one-group-block " id="one_group_block_<?php echo $group_id ; ?>">
        <input type="hidden" name="groups[<?php echo $group_id ; ?>]" value="<?php echo $group_id ; ?>">
        <div class="rbit-one-group-block-header">
            <button type="button" class="button add_custom_attribute rbit-remove-block rbit_remove_group_item"  id="rbit_remove_group_item" data-group-id="<?php echo $group->ID ; ?>" onclick="deleteGroupFromList(<?php echo $group->ID ; ?>);">X</button>
            <h2>
                <?php echo $group->post_title; ?>
                <button type="button" class="button add_custom_attribute rbit_group_up" id="rbit_group_up" data-group-id="<?php echo $group_id ; ?>" onclick="" >&uArr;</button>
                <button type="button" class="button add_custom_attribute rbit_group_down" id="rbit_group_down" data-group-id="<?php echo $group_id ; ?>" onclick="" >&dArr;</button>

            </h2>
            <p class="rbit-group-description"><?php echo __( 'Group description', 'rbit-custom-configurator' ) ?>: <input type="text" name="group_description[<?php echo $group->ID ; ?>]" value="<?php echo $group_array['group_description']; ?>"></p>
            <p class="form-field _regular_price_field ">
                <label for="_options_list"><?php echo __( 'Select option', 'rbit-custom-configurator' ) ?></label>
                <select name="_options_list" class=" rbit-options-list" id="_options_list_<?php echo $group->ID ; ?>" >
                    <?php foreach ($options as $option) {
                        echo '<option value="'.$option->ID.'">'.$option->post_title.'</option>';
                    }
                    ?>

                </select>

                <button type="button" class="button add_custom_attribute rbit_add_option" id="rbit_add_option" data-group-id="<?php echo $group_id ; ?>" onclick="rbit_add_option_to_list(<?php echo $group_id ; ?>);" ><?php echo __( 'Add option', 'rbit-custom-configurator' ) ?></button>


                <span class="rbit-item-error" style="display: none;" id="option_error_<?php echo $group_id ; ?>"><?php echo __( 'This Option already in list!', 'rbit-custom-configurator' ) ?></span>

            </p>
        </div>
        <div class="rbit-one-group-block-content rbit-conf-content">
            <?php
            if ($group_array) {
                // display group options
                foreach ($group_array as $option_id => $option_array) {
                    display_option_block($group_id, $option_id, $option_array);
                }
            }

            ?>
        </div>

    </div>
    <?php
}

// END display group block with options list






// START Ajax response for option selected
// and we send response with option values list and set

add_action("wp_ajax_rbit_get_values_list", "rbit_get_values_list");
function rbit_get_values_list(){

    $option_id = $_POST['option_id'];
    $group_id = $_POST['group_id'];

    display_option_block($group_id, $option_id);

    wp_die();
}

// END Ajax response for option selected


// START display options block function

function display_option_block( $group_id, $option_id, $option_array = false ) {
    $option = get_post($option_id);

    //if (!$group) wp_die();

    $args = array(
        'post_type'=>'is_option_value',
        'status'=>'publish',
        'order'=>'ASC',
        'posts_per_page'=>-1,
        'meta_query' => array(
            array(
                'key' => 'option', // name of custom field
                'value' =>  '"' . $option->ID . '"' , //
                'compare' => 'LIKE'
            )
        )
    );
    //query_posts($args);
    $news_query = new WP_Query( $args );
    $values = $news_query->posts;

    ?>
    <div class="rbit-one-option-block rbit-conf-content" id="one_option_block_<?php echo $group_id.'_'.$option->ID ; ?>">
        <input type="hidden" name="options[<?php echo $group_id; ?>][<?php echo $option->ID ; ?>]" value="<?php echo $option->ID ; ?>">
        <div class="rbit-one-option-block-header">
            <button type="button" class="button add_custom_attribute rbit-remove-block rbit_remove_option_item"  id="rbit_remove_option_item" data-option-id="<?php echo $option->ID ; ?>" data-group-id="<?php echo $group_id ; ?>" onclick="deleteOptionFromList(<?php echo $group_id ; ?>, <?php echo $option->ID ; ?>);">X</button>
            <h2><?php echo $option->post_title; ?></h2>
            <p class="form-field ">
                <label for="_values_list"><?php echo __( 'Select value', 'rbit-custom-configurator' ) ?></label>
                <select name="_values_list" class=" rbit-values-list" id="_values_list_<?php echo $group_id.'_'.$option->ID ; ?>" >
                    <?php foreach ($values as $value) {
                        echo '<option value="'.$value->ID.'">'.$value->post_title.'</option>';
                    }
                    ?>

                </select>

                <button type="button" class="button add_custom_attribute rbit_add_value" id="rbit_add_value" data-option-id="<?php echo $option->ID ; ?>" data-group-id="<?php echo $group_id ; ?>" onclick="rbit_add_value_to_list(<?php echo $group_id ; ?>, <?php echo $option->ID ; ?>);"><?php echo __( 'Add value', 'rbit-custom-configurator' ) ?></button>
                <span class="rbit-item-error" style="display: none;" id="value_error_<?php echo $group_id ; ?>_<?php echo $option->ID ; ?>"><?php echo __( 'This Value already in list!', 'rbit-custom-configurator' ) ?></span>

            </p>
        </div>
        <div class="rbit-one-option-block-content rbit-conf-content">
            <?php
            if ($option_array) {
                foreach ($option_array as $value_id => $value_cost) {
                    rbit_display_value_item($group_id, $option_id, $value_id, $value_cost);
                }
            }
            else {
                foreach ($values as $value) {
                    rbit_display_value_item($group_id, $option_id, $value->ID);
                }
            }

            ?>
        </div>

    </div>
    <?php
}

// END display options block function


// START Ajax response for value selected
//

add_action("wp_ajax_rbit_get_value_item", "rbit_get_value_item");
function rbit_get_value_item(){

    $option_id = $_POST['option_id'];
    $group_id = $_POST['group_id'];
    $value_id = $_POST['value_id'];

    rbit_display_value_item($group_id, $option_id, $value_id);

    wp_die();
}

// END Ajax response for option selected


// START display value item

function rbit_display_value_item($group_id, $option_id, $value_id, $value_cost = false ) {

    $value = get_post($value_id);
    $value_cost = ($value_cost === false) ? '' : $value_cost;
    // get value image
    $value_image = '#';
    if( has_post_thumbnail( $value_id) ) {
        $value_image = get_the_post_thumbnail_url($value, 'post-thumbnail');
    }
    ?>
    <div class="rbit-one-value-block" id="one_value_block_<?php echo $group_id.'_'.$option_id.'_'.$value->ID ; ?>">

        <div class="rbit-one-option-block-content rbit-conf-content" id="">
            <p class="form-field ">

                <img src="<?php echo $value_image; ?>" alt="<?php echo $value->post_title; ?>" class="rbit-item-image">

                <button type="button" class="button add_custom_attribute rbit_remove_value_product_item"  id="rbit_remove_value_product_item" data-value-id="<?php echo $value_id ; ?>" data-option-id="<?php echo $option_id ; ?>" data-group-id="<?php echo $group_id ; ?>" onclick="delete_value_from_list(<?php echo $group_id ; ?>, <?php echo $option_id ; ?>, <?php echo $value_id ; ?>);" >X</button>



                <label for="_values_item"><?php echo $value->post_title; ?></label>

                <input type="text" name="product_value_item[<?php echo $group_id; ?>][<?php echo $option_id; ?>][<?php echo $value->ID; ?>]" class="" value="<?php echo $value_cost; ?>">

            </p>
        </div>

    </div>
    <?php
}

// END display value item




// START save product meta

add_action( 'woocommerce_process_product_meta', 'rbit_save_values_field' );
function rbit_save_values_field( $id ){
    if (isset( $_POST[ 'rbit_configurator_save' ]) && 'save' == $_POST[ 'rbit_configurator_save' ] ) {

        if (!empty($_POST[ 'product_value_item' ])) {
            $values_array = $_POST[ 'product_value_item' ];
            //update_post_meta( $id, 'rbit_product_values', $values_json );
        }
        else {
            $values_array = '';
            //update_post_meta( $id, 'rbit_product_values', '' );
        }

        if(!empty($_POST[ 'group_description' ])) {
            foreach ($_POST[ 'group_description' ] as $group_id => $group_descr) {
                $values_array[$group_id]['group_description'] = $group_descr;
            }
        }
        $values_json = json_encode($values_array);
        update_post_meta( $id, 'rbit_product_values', $values_json );

        //update_post_meta( $id, 'super_product', $super );
    }

    if (isset( $_POST[ 'rbit_configurator_clear' ]) && 'clear' == $_POST[ 'rbit_configurator_clear' ] ) {
        //update_post_meta( $id, 'rbit_product_values', '' );
    }
    //$super = isset( $_POST[ '' ] ) && 'yes' === $_POST[ 'spr' ] ? 'yes' : 'no';
    //update_post_meta( $id, 'super_product', $super );

}

// END save product meta

