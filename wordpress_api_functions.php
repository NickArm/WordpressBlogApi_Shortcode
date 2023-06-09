function register_rest_images()
{
    register_rest_field(
        'post',
        'fimg_url',
        array(
            'get_callback' => 'get_rest_featured_image',
            'update_callback' => null,
            'schema' => null,
        )
    );
}
add_action('rest_api_init', 'register_rest_images');

// Callback function to get the featured image URL
function get_rest_featured_image($object, $field_name, $request)
{
    if ($object['featured_media']) {
        $img_id = $object['featured_media'];
        $img_url = wp_get_attachment_image_url($img_id, 'full');

        // Modify the image URL by including the domain
        $img_url = str_replace('/wp-content', 'https://yourdomain.com/wp-content', $img_url);

        return $img_url;
    }
    return false;
}
