<?php 
    $prefix = 'tz_';

    $organizers_fields = array(
         'id' => 'Organizers',
         'title' => 'Organizers',
         'page' => 'dal_country',
         'context' => 'normal',
         'priority' => 'high',
         'fields' => array(
            array(
                'name' => 'Add ',
                'desc' => 'This meta box is under development',
                'id' => $prefix . 'organizers',
                'type' => 'text',
                'std' => ''
            ),                        
        )
    );

    /*-------------------------------------*/
    /* Add Meta Box to CPT screen 
    /*-------------------------------------*/

    function tz_add_box() {
        global $organizers_fields;

        add_meta_box($organizers_fields['id'], $organizers_fields['title'], 'tz_show_box_organizers', $organizers_fields['page'], $organizers_fields['context'], $organizers_fields['priority']);


    }

 

 add_action('admin_menu', 'tz_add_box');

    /*------------------------------------------*/
    /* Callback function/show fields in meta box
    This is taken directly from: http://wordpress.stackexchange.com/questions/19838/create-more-meta-boxes-as-needed
    /*------------------------------------------*/


    function tz_show_box_organizers() {
        global $organizers_fields, $post;
        // Use nonce for verification
        echo '<input type="hidden" name="tz_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


        ?>




        <div id="meta_inner">
        <?php

        //get the saved meta as an arry
        $orgs = get_post_meta( $post->ID, 'orgs', true );
        $c = 0;
        if ( count( $orgs ) > 0 ) {
            foreach ( (array)$orgs as $orglink ) {
                if ( isset( $orglink['title'] ) || isset( $orglink['orglink'] ) ) {
                    printf( '<p>Org Name<input type="text" name="orgs[%1$s][title]" value="%2$s" /> -- orglink number : <input type="text" name="orgs[%1$s][orglink]" value="%3$s" /><span class="remove">%4$s</span></p>', $c, $orglink['title'], $orglink['orglink'], __( 'Remove orglink' ) );
                    $c++;
                }
            }
        }

        ?>
        <span id="here"></span>
        <span class="add"><?php _e('Add organizer'); ?></span>
        <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
        count = count + 1;

        $('#here').append('<p> Org Name <input type="text" name="orgs['+count+'][title]" value="" /> -- Link: <input type="url" name="orgs['+count+'][orglink]" value="" /><span class="remove">Remove organization link</span></p>' );
        return false;
        });
        $(".remove").live('click', function() {
        $(this).parent().remove();
        });
        });
        </script>
        </div>
        <?php

    }

/*-------------------------------------*/
/* Save data when post is edited
/*-------------------------------------*/


function tz_save_data($post_id) {
    global $organizers_fields, $post;
    // verify nonce
    if (!wp_verify_nonce($_POST['tz_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }


 $orgs = $_POST['orgs'];
    update_post_meta($post_id,'orgs',$orgs);


}

add_action('save_post', 'tz_save_data');
?>