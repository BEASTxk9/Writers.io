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
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM $table_name WHERE user_id = $current_user_id ORDER BY id DESC LIMIT 1";
    
    $results = $wpdb->get_results($sql);

    // HTML DISPLAY
    // external links
    $output = '
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    ';

    if ($results) {
        foreach ($results as $i) {
$output .='
<section id="Results-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <h2 id="groupname">Group Name: ' . $i->groupname . '</h2>
                <p id="answer_text">Answers: ' . $i->answer_text . '</p>
            </div>
            <div id="results-participants-card" class="col-sm-2">
                <p id="participants">Participants: ' . $i->participants . '</p>
            </div>
        </div>
    </div>
</section>
';
        }
    } else {
        $output .= '<p>No submitted answers found.</p>';
    }

    return $output;
}
?>
