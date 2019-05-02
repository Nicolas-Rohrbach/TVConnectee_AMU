<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 02/05/2019
 * Time: 17:17
 */

class processing_upload
{
    public function upload_process() {
        // WordPress environment
        require( dirname(__FILE__) . '../../../../wp-load.php' );

        $wordpress_upload_dir = wp_upload_dir();
// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
// $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
        $i = 1; // number of tries when the file with the same name is already exists

        $image = $_FILES['image'];
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $image['name'];
        $new_file_mime = mime_content_type( $image['tmp_name'] );

        if( empty( $image ) )
            die( 'File is not selected.' );

        if( $image['error'] )
            die( $image['error'] );

        if( $image['size'] > wp_max_upload_size() )
            die( 'It is too large than expected.' );

        if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
            die( 'WordPress doesn\'t allow this type of uploads.' );

        while( file_exists( $new_file_path ) ) {
            $i++;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $image['name'];
        }

// looks like everything is OK
        if( move_uploaded_file( $image['tmp_name'], $new_file_path ) ) {


            $upload_id = wp_insert_attachment( array(
                'guid'           => $new_file_path,
                'post_mime_type' => $new_file_mime,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $image['name'] ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path );

            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once( ABSPATH . 'wp-admin/includes/image.php' );

            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

            // Show the uploaded file in browser
            wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );

        }

    }
}