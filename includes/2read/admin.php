<?php
// Register the shortcode
add_shortcode('admin', 'admin');

// create function
function admin(){
// ____________________________________________________________________________
// connect to database.
  global $wpdb;
// check connection
  if (!$wpdb) {
    $wpdb->show_errors();
  }

  // ____________________________________________________________________________
  // Set table name that is being called
  $table_name = $wpdb->prefix . 'admin';

  // SQL query to retrieve data from the table
  $admin = $wpdb->get_results("SELECT * FROM $table_name");


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
<section id="admin-section">
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <a href="' . site_url() . '/admin-create/" class="btn button-add my-3">CREATE A CARD</a>
            <table class="table-bordered table table-responsive w-100 d-block d-md-table">
                <thead>
                    <tr>
                        <th id="th-id">ID</th>
                        <th id="th-topic">TOPIC</th>
                        <th id="th-t_description">DESCRIPTION</th>
                        <th id="th-OPERATORS">OPERATORS</th>
                    </tr>
                </thead>

                <tbody>
';

// fetch and display data from wpdb
foreach ($admin as $i) {
    $output .= '<tr>';
    $output .= '<td id="td-id">' . $i->id . '</td>';
    $output .= '<td id="td-topic">' . $i->topic . '</td>';
    $output .= '<td id="td-t_description">' . $i->t_description . '</td>';
    $output .= '<td id="td-OPERATORS">
    <!-- UPDATE BUTTON -->
    <a href="' . '/admin-update/?page=wp_admin&action=admin_update&id=' . $i->id . '" class="button-update btn my-2">Update</a>
    <!-- DELETE BUTTON -->
    <a href="' . admin_url('./4delete/delete.php?page=wp_admin&action=delete(admin)&id=' . $i->id) . '" class="button-delete btn">Delete</a>
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


// $output .='
// <style>
// .button-add{
//     width: 100%;
// }
// </style>
// ';


  // ____________________________________________________________________________
  // Return the table html
  return $output;
}
?>
