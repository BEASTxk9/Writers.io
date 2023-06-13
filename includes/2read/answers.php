<?php
// Register the shortcode
add_shortcode('answers', 'answers');

// create function
function answers(){
// ____________________________________________________________________________
// connect to database.
  global $wpdb;
// check connection
  if (!$wpdb) {
    $wpdb->show_errors();
  }

  // ____________________________________________________________________________
  // Set table name that is being called
  $table_name = $wpdb->prefix . 'answers';

  // SQL query to retrieve data from the table
  $answers = $wpdb->get_results("SELECT * FROM $table_name");


  // ____________________________________________________________________________
// HTML DISPLAY

// external links
$output = '
<!-- bootstrap css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
';


$output .='
<section id="answers-section">
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <table class="table-bordered table table-responsive w-100 d-block d-md-table">
                <thead>
                    <tr>
                        <th id="th-id">ID</th>
                        <th id="th-groupname">GROUPNAME</th>
                        <th id="th-participants">PARTICIPANTS</th>
                        <th id="th-answer_text">ANSWERS</th>
                        <th id="th-user_id">USERID</th>
                        <th id="th-user_name">USERNAME</th>
                        <th id="th-operators">OPERATORS</th>
                    </tr>
                </thead>

                <tbody>
';

// fetch and display data from wpdb
foreach ($answers as $i) {
    $output .= '<tr>';
    $output .= '<td id="td-id">' . $i->id . '</td>';
    $output .= '<td id="td-groupname">' . $i->groupname . '</td>';
    $output .= '<td id="td-participants">' . $i->participants . '</td>';
    $output .= '<td id="td-answer_text">' . $i->answer_text . '</td>';
    $output .= '<td id="td-user_id">' . $i->user_id . '</td>';
    $output .= '<td id="td-user_name">' . $i->user_name . '</td>';
    $output .= '<td id="td-operators">
    <!-- DELETE BUTTON -->
    <a href="' . admin_url('./4delete/delete.php?page=wp_answers&action=delete(answers)&id=' . $i->id) . '" class="button-delete btn">Delete</a>
    </td>';
    $output .= '<tr>';
  }

$output .='
</tbody>
</table>

</div>
</div>
</div>
</section>
';


  // ____________________________________________________________________________
  // Return the table html
  return $output;
}
?>
