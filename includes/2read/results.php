<?php
// register shortcode
add_shortcode('results', 'display_submitted_answers');

// create function
function display_submitted_answers()
{
    // ____________________________________________________________________________    
    // connect to database.
    global $wpdb;
    // check connection
    if (is_null($wpdb)) {
        $wpdb->show_errors();
    }

    // ____________________________________________________________________________    
    // Set table name that is being called
    $table_name = $wpdb->prefix . 'answers';

    // fetch the submitted answers
    $sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1";
    $results = $wpdb->get_results($sql);

    // HTML DISPLAY
    $output = '';

    if ($results) {
        $output .= '<div class="container">';
        $output .= '<div class="row justify-content-center text-center">';
        $output .= '<div class="col-sm-12">';

        foreach ($results as $i) {
            $output .= '<h2>Group Name: ' . $i->groupname . '</h2>';
            $output .= '<p>Participants: ' . $i->participants . '</p>';
            $output .= '<p>Answers: ' . $i->answer_text . '</p>';
        }

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    } else {
        $output .= '<p>No submitted answers found.</p>';
    }

    return $output;
}
?>
