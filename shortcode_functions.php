// Function to fetch and display the latest articles from the source site
function display_latest_articles($atts)
{
    // Set the REST API endpoint of the source site
    $api_endpoint = 'https://yourdomain.com/wp-json/wp/v2/posts';



    // Set the number of articles to retrieve
    $num_articles = 5;

    // Fetch the articles from the API
    $response = wp_remote_get($api_endpoint . '?per_page=' . $num_articles);

    // Check if the request was successful
    if (is_wp_error($response)) {
        return 'Error retrieving articles.';
    }

    // Parse the JSON response
    $articles = json_decode(wp_remote_retrieve_body($response));

    // Check if any articles were found
    if (empty($articles)) {
        return 'No articles found.';
    }

    // Generate HTML to display the articles
    $output = '<ul style="list-style: none;padding: 0;" class="article-list">';
    foreach ($articles as $article) {
        $title = $article->title->rendered;
        $link = $article->link;

        // Check if the article has a featured image
        if (isset($article->fimg_url) && !empty($article->fimg_url)) {
            $image_url = $article->fimg_url;

            // Add the image and title to the output
            $output .= '<li style="margin-bottom: 5%;"><a href="' . $link . '" target="_blank"><img src="' . $image_url . '" alt="' . $title . '"></a>';
            $output .= '<a href="' . $link . '" target="_blank">' . $title . '</a></li>';
        }
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('latest_articles', 'display_latest_articles');
