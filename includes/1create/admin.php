<?php
// register shortcode
add_shortcode('admin-create', 'admin_create');
// create function
function admin_create()
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
    $table_name = $wpdb->prefix . 'admin';

    // if content is added/submitted/posted take the data and do the msql add query
    if (isset($_POST['submit'])) {
        // id is automatically set
        $topic = $_POST['topic'];
        $t_description = $_POST['t_description'];
 
        // mysql add query
        $sql = "INSERT INTO $table_name (topic, t_description) 
        values('$topic', '$t_description')";

        $result = $wpdb->query($sql);
        
        // if successful redirect
        if ($result) {
            $redirect_url = site_url('/admin/');
            ?>
            <script>
                window.location.href = "<?php echo $redirect_url; ?>";
            </script>
            <?php
            exit;
        } else {
            wp_die($wpdb->last_error);
        }
    }

    // ____________________________________________________________________________
    // HTML DISPLAY

    // external links
    $output = '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>';

    $output .= '
    <div class="container">
    <div class="row">
        <div class="col-sm-12">

            <form method="POST" action="">
                <!-- topic -->
                <label for="topic">TOPIC</label><br>
                <input type="text" id="topic" name="topic" required><br>
                <!-- description -->
                <label for="t_description">Description</label><br>
                <input type="text" id="t_description" name="t_description" required><br>
                <!-- submit -->
                <input class="submit-btn px-5 my-2" type="submit" name="submit" value="Add Details">
            </form>

        </div>
    </div>
</div>
    ';


    // Return the create item form in html
    return $output;
}
?>
