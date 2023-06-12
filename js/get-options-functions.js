
var valuesListRequest;
var optionsListRequest;
var valueItemRequest;

jQuery(function ($) {

    // select2 init for group list select
    $(document).ready(function() {
        //$('#_groups_list').select2();
        $('.rbit_configurator_options').click( function () {
            rebuildAllSelect2();
        });
    });





    // START Create AJAX request to get options list
    optionsListRequest = {
        init: function (groupID) {
            optionsListRequest.callAjaxMethod(groupID);
        },
        callAjaxMethod:function(groupID){
            var data = {
                'action': 'rbit_get_options_list',  // your action name
                'group_id': groupID
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {



                    $('.rbit-all-groups-block-content').append(response);
                    console.log(response);

                    // $('.rbit_add_option').click( function () {
                    //         console.log('options select');
                    //
                    //         let group_id = $(this).data('group-id');
                    //         let option_id = $('#_options_list_' + group_id).val();
                    //         valuesListRequest.init(group_id, option_id);
                    //     }
                    // );

                    // $(document).ready(function() {
                    //     $('#_options_list_'+groupID).select2();
                    // });
                    // $('#_options_list_'+groupID).select2();

                    rebuildAllSelect2();

                }
            });
        }
    }

    $('.rbit_add_group').click( function () {

        let group_id = $('#_groups_list').val();
        console.log('group_id - '+group_id);

        let we_have_this_value = false;
        $('.rbit_remove_group_item', $('#rbit_all_groups_block_content')).each(function(){
            current_val = $(this).data('group-id');
            if (current_val == group_id) we_have_this_value = true;
            console.log('check current group id: '+current_val);
            console.log('check group id: '+group_id);
        });

        if (!we_have_this_value){
            console.log('group select, we dont have this group in this list');

            optionsListRequest.init(group_id);
        }
        else {
            console.log('we have this group in list');
            $('#group_error').show(500);
            setTimeout(function(){
                $('#group_error').hide(500);
            }, 2000);
        }


        }
    );
    //optionsListRequest.init();


    // END Create AJAX request to get options list


    // START values list

    valuesListRequest = {
        init: function (groupID, optionID) {
            valuesListRequest.callAjaxMethod(groupID, optionID);
        },
        callAjaxMethod:function(groupID, optionID){
            var data = {
                'action': 'rbit_get_values_list',  // your action name
                'group_id': groupID,
                'option_id': optionID
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    //let options_group_content = $('#one_option_block_' + groupID + '_' + optionID).children('rbit-one-option-block-content').first();
                    let options_group_content = $('#one_group_block_' + groupID ).children('.rbit-one-group-block-content').first();
                    $(options_group_content).append(response);
                    console.log('#one_group_block_' + groupID + ' - ' + 'rbit-one-group-block-content');
                    console.log(response);


                    $('.rbit_add_value').click( function () {

                        // let group_id = $(this).data('group-id');
                        // let option_id = $(this).data('option-id');
                        //
                        // let value_id = $('#_values_list_' + group_id + '_' + option_id).val();
                        //
                        // let we_have_this_value = false;
                        // $('.rbit_remove_value_product_item', $('#one_option_block_'+group_id+'_'+option_id)).each(function(){
                        //     current_val = $(this).data('value-id');
                        //     if (current_val == value_id) we_have_this_value = true;
                        //     console.log('check current value id: '+current_val);
                        //     console.log('check value id: '+value_id);
                        // });
                        //
                        //     if (!we_have_this_value){
                        //         console.log('value select, we dont have this value in this option');
                        //
                        //         valueItemRequest.init(group_id, option_id, value_id );
                        //
                        //     }
                        //     else {
                        //         console.log('we havr this value in this option');
                        //         $('#value_error_'+group_id+'_'+option_id).show(500);
                        //         setTimeout(function(){
                        //             $('#value_error_'+group_id+'_'+option_id).hide(500);
                        //         }, 2000);
                        //     }




                    });



                    // $(document).ready(function() {
                    //     $('#_values_list_'+'_'+groupID+'_'+optionID).select2();
                    // });
                    // $('#_values_list_'+groupID+'_'+optionID).select2();

                    rebuildAllSelect2();
                }
            });
        }
    }

    // END values list


    // START value item request

    valueItemRequest = {
        init: function (groupID, optionID, valueID) {
            valueItemRequest.callAjaxMethod(groupID, optionID, valueID);
        },
        callAjaxMethod:function(groupID, optionID, valueID){
            var data = {
                'action': 'rbit_get_value_item',  // your action name
                'group_id': groupID,
                'option_id': optionID,
                'value_id': valueID
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function (response) {
                    //let options_group_content = $('#one_option_block_' + groupID + '_' + optionID).children('rbit-one-option-block-content').first();
                    let values_group_content = $('#one_option_block_' + groupID + '_' + optionID ).children('.rbit-one-option-block-content').first();
                    $(values_group_content).append(response);
                    console.log('#one_option_block_' + groupID + ' - ' + 'rbit-one-option-block-content');
                    console.log('valueID - ' + valueID);
                    console.log(response);


                    $('.rbit_remove_value_product_item').click( function () {
                            // console.log('value delete');
                            //
                            // let group_id = $(this).data('group-id');
                            // let option_id = $(this).data('option-id');
                            // let value_id = $(this).data('value-id');
                            //
                            // $('#one_value_block_'+group_id+'_'+option_id+'_'+value_id).remove();

                        }
                    );



                    // $(document).ready(function() {
                    //     $('#_values_list_'+'_'+groupID+'_'+optionID).select2();
                    // });
                    // $('#_values_list_'+'_'+groupID+'_'+optionID).select2();

                    rebuildAllSelect2();
                }
            });
        }
    }





    // END value item request










});

// END Create AJAX request to get options list


// START function add option to list
function rbit_add_option_to_list(groupID) {
    jQuery(function ($) {
        console.log('options selected');
        let option_id = $('#_options_list_' + groupID).val();
        //let group_id = groupID;

        let we_have_this_value = false;
        $('.rbit_remove_option_item', $('#one_group_block_'+groupID)).each(function(){
            current_val = $(this).data('option-id');
            if (current_val == option_id) we_have_this_value = true;
            console.log('check current value id: '+current_val);
            console.log('check value id: '+option_id);
        });

        if (!we_have_this_value){
            console.log('option select, we dont have this value in this option');

            valuesListRequest.init(groupID, option_id);

        }
        else {
            console.log('we havу this value in this option');
            $('#option_error_'+groupID).show(500);
            setTimeout(function(){
                $('#option_error_'+groupID).hide(500);
            }, 2000);
        }

    });
}

// START function add option to list

// START function add value to list
function rbit_add_value_to_list(groupID, optionID) {
    jQuery(function ($) {
        console.log('value selected');
        let group_id = groupID;
        let option_id = optionID;

        let value_id = $('#_values_list_' + group_id + '_' + option_id).val();

        let we_have_this_value = false;
        $('.rbit_remove_value_product_item', $('#one_option_block_'+group_id+'_'+option_id)).each(function(){
            current_val = $(this).data('value-id');
            if (current_val == value_id) we_have_this_value = true;
            console.log('check current value id: '+current_val);
            console.log('check value id: '+value_id);
        });

        if (!we_have_this_value){
            console.log('value select, we dont have this value in this option');

            valueItemRequest.init(group_id, option_id, value_id );

        }
        else {
            console.log('we havr this value in this option');
            $('#value_error_'+group_id+'_'+option_id).show(500);
            setTimeout(function(){
                $('#value_error_'+group_id+'_'+option_id).hide(500);
            }, 2000);
        }
    });

}
// START function add value to list


// START Delete value from list

function delete_value_from_list(groupID, optionID, valueID) {
    jQuery(function ($) {
        console.log('value delete');

        $('#one_value_block_'+groupID+'_'+optionID+'_'+valueID).remove();
    });
}

// END Delete value from list

// START delete option from list

function deleteOptionFromList(groupID, optionID) {
    jQuery(function ($) {
        console.log('option delete');

        $('#one_option_block_'+groupID+'_'+optionID).remove();
    });
}

// END delete option from list

// START delete group from list

function deleteGroupFromList(groupID) {
    jQuery(function ($) {
        console.log('option delete');

        $('#one_group_block_'+groupID).remove();
    });
}

// END delete group from list


// START rebuild all select2

function rebuildAllSelect2() {
    jQuery(function ($) {
        $(document).ready(function() {

            // Groups selects
            $('.rbit-groups-list').each(function(){
                select_id = $(this).attr('id');

                console.log('group select2 id: '+select_id);
                //$('#'+select_id).select2();
                $(this).select2();
                //$(this).select2('destroy').select2();
            });

            //Options selects
            $('.rbit-options-list').each(function(){
                select_id = $(this).attr('id');

                console.log('option select2 id: '+select_id);
                //$('#'+select_id).select2();
                $(this).select2();
                //$(this).select2('destroy').select2();
            });

            // Values lists
            $('.rbit-values-list').each(function(){
                select_id = $(this).attr('id');

                console.log('value select2 id: '+select_id);
                //$('#'+select_id).select2();
                $(this).select2();
                //$(this).select2('destroy').select2();
            });
        });

    });
}

// END rebuild all select2

// START groups up/down
jQuery(function ($) {
    $(document).ready(function () {
        $('.rbit_group_up').on('click', function(e) {
            var wrapper = $(this).closest('.rbit-one-group-block')
            wrapper.insertBefore(wrapper.prev())
        });
        $('.rbit_group_down').on('click', function(e) {
            var wrapper = $(this).closest('.rbit-one-group-block')
            wrapper.insertAfter(wrapper.next())
        });
    });
});
// END groups up/down



