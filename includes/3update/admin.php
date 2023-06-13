<?php
// ADMIN
add_shortcode('admin-update', 'admin_update');
function admin_update($id)
{
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

    // Get the id from the URL
    $id = $_GET['id'];

    // SQL query to retrieve data from the table
    $admin = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$id");

    // ____________________________________________________________________________    
    // Update activities
    if (isset($_POST['submit'])) {
        $topic = $_POST['topic'];
        $t_description = $_POST['t_description'];

        // update mysql query
        $sql = "UPDATE $table_name set topic='$topic', t_description='$t_description' where id=$id";
        $result = $wpdb->query($sql);

        if ($result) {
            // doesnt work idk why / works idk why
            wp_redirect(site_url() . '/admin/');
            exit;
        } else {
            die(mysqli_error($wpdb));
        }

    }

    // ____________________________________________________________________________    
// HTML DISPLAY

    // external links
    $output = '
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  ';

    //   header
    $output .= '
<div class="container mb-5">
<div class="row justify-content-center">
<div class="col-sm-8 col-md-6">
<h1>UPDATE PARENT FORM</h1>
</div>
</div>
</div>
';

    $output .= '
<div class="container">
<div class="row justify-content-center">
<div class="col-sm-8 col-md-6">
';
    // ID
    $output .= '<form method="post">';
    $output .= '<input type="hidden" name="id" value="' . $admin->id . '">';
    // topic
    $output .= '
    <p>
    <label for="topic">topic</label>
    <input type="text" id="topic" name="topic" value="' . $admin->topic . '" required>
    </p>';

    // description
    $output .= '
    <p>
    <label for="t_description">t_description</label>
    <input type="text" id="t_description" name="t_description" value="' . $admin->t_description . '" required>
    </p>';

    // submit btn
    $output .= '
    <div class="container">
    <div class="row justify-content-center ">
    <div class="col-sm-5 pt-3">
    <input class="submit-btn px-5" type="submit" name="submit" value="Update">
    <div>
    </div>
    </div>';

    $output .= '</form>';

    $output .= '
    </div>
    </div>
    </div>
    ';

    // ____________________________________________________________________________  
    return $output;

};