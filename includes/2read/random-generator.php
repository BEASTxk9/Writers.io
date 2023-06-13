<?php
// register shortcode
add_shortcode('random-card', 'random_card');
// create function
function random_card()
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

    // if content is added/submitted/posted take the data and do the msql add query
    if (isset($_POST['submit'])) {
        // id is automatically set
        $groupname = $_POST['groupname'];
        $participants = $_POST['participants'];
        $answer_text = $_POST['answer_text'];
 
        // mysql add query
        $sql = "INSERT INTO $table_name (groupname, participants, answer_text) 
        values('$groupname', '$participants', '$answer_text')";

        $result = $wpdb->query($sql);
        
        // if successful redirect
        if ($result) {
            echo "Data added successfully";
            wp_redirect(site_url() . '/results/');
            exit;           
        } 
        // else do this
        else {
            die($wpdb->last_error);
        }
    }


    // HTML DISPLAY

    // external links
    $output = '
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    ';

    $output .= '
    <div class="container">
    <div class="row justify-content-center text-center">

    <!-- button and form -->
    <div class="col-sm-12">

<button id="generateButton" class="btn">START</button>

 <!-- timer -->
            <div class="row justify-content-center text-center">
                <div class="col-sm-8" id="timer" style="display: none;">
                    <h4> TIME REMAINING: <span id="time"></span> </h4>
                </div>
            </div>
            <div class="row justify-content-center text-center">

            <!-- topic -->
            <div class="col-sm-8" id="topic" style="display: none;">
                <h4></h4>
            </div>
            <!-- describe -->
            <div class="col-sm-8" id="t_description" style="display: none;">
                <h4></h4>
            </div>
         
            <!-- answer --> <!-- OFFCANVAS BTN -->
            <div class="col-sm-8" id="answer" style="display: none;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
    <h4>CLICK HERE TO WRITE/SUBMIT ANSWERS</h4>
            </div>

            </div>
    </div>

    </div>
</div>
    ';


    $output .= '
    <!-- OFFCANVAS CONTENT -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title" id="offcanvasScrollingLabel">Answers</h3>
    <button type="button" class="btn-close bg-light text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

    <form method="POST" action="">
    <div class="answers-body">
    <p>Welcome, the form below allows you to take notes which is then displayed after the 10 min timer is up or if the user clicks submit...<br>
    **TIPS**<br>
    - If you click enter it will submit your answers<br>
    - If you want to make a space in your notes then click <b>" ctrl " & " shift "</b><br>
    </p>

           <!-- groupname -->
        <input type="text" id="groupname" name="groupname" placeholder="Enter Group Name here..." required><br>
        <!-- participants -->
        <textarea type="text" id="participants" name="participants" placeholder="Enter Participants here..." required></textarea>
        <!-- answer_text -->
        <textarea type="text" id="answer_text" name="answer_text" placeholder="Enter answers here..." required></textarea>
    </div>
 
        <!-- submit -->
        <input class="submit-btn px-5 my-2" type="submit" name="submit" value="SUBMIT">
    </form>

  </div>
</div>

    ';

    // custom CSS
    $output .= '
    <style scoped>
    #topic, #t_description {
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 2vh;
        background-color: grey;
        color: black;
        padding: 30px; 
        width: fit-content;
        width: 100%;
        font-family: raleway, roboto mono;
    }

    #generateButton{
       background-color: grey;
       color: black;
    }

    #timer{
        font-weight: bold;
        margin-top: 1vh;
        background-color: grey;
        color: black;  
        padding: 30px;  
        width: fit-content;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        width: 100%;
        font-family: raleway, roboto mono;
    }

    #answer{
        margin-top: 2vh;
        width: 100%;
        padding: 30px;
        margin: none;
        outline: none !important;
        border: none !important;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;  
        background-color: grey;
        color: black;
   
    }
    #answer:hover{
        background-color: grey;
        color: black;
        transition: all 0.3s ease-in-out;
    }

  

    .offcanvas{
        font-family: raleway, roboto mono;
        background-color: grey;
        box-shadow: black 5px 5px 10px;
    }

.offcanvas-header{
    background-color: #171717;
    color: grey;
}

.offcanvas-title{
    padding-top: 2vh;
}

.answers-body{
    min-height: 74vh;
}

input, textarea{
    width: 100%;
    margin-top: 10px !important;
    margin-bottom: 10px !important;
    padding: 15px !important;
    background-color: #171717 !important;
    color: grey !important;
    border: none !important;
}
::placeholder, input::placeholder{
    color: grey !important;
}

#groupname{
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;  
}
#answer_text{
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;  
}

.submit-btn{
width: 100%;
background-color: #171717;
color: grey;
font-weight: bold;
border: none;
border-radius: 10px;
padding: 10px;
}
    </style>
    ';

    // JavaScript code
    $output .= '
    <script>
        document.getElementById("generateButton").addEventListener("click", function() {
            // Disable the button after clicking
            document.getElementById("generateButton").style.display = "none";

            // Show the timer
            document.getElementById("timer").style.display = "block";

            // answer
            document.getElementById("answer").style.display = "block";

            // Set the timer duration (in minutes)
            var duration = 10;

            // Calculate the end time
            var endTime = new Date().getTime() + duration * 60 * 1000;

            // Update the timer display
            var timer = setInterval(function() {
                // Calculate the remaining time
                var now = new Date().getTime();
                var distance = endTime - now;

                // Check if the timer has ended
                if (distance <= 0) {
                    // Clear the timer interval
                    clearInterval(timer);

                    // Hide the timer and show the button again
                    document.getElementById("timer").style.display = "none";
                    document.getElementById("generateButton").disabled = false;
                } else {
                    // Calculate minutes and seconds
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Format the time display
                    var timeDisplay = minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");

                    // Update the time display
                    document.getElementById("time").textContent = timeDisplay;
                }
            }, 1000);

            // Send an AJAX request to a PHP script that generates random items
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "' . admin_url("admin-ajax.php") . '?action=generate_random_items", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    document.getElementById("topic").innerHTML = "<h1>" + response.topic + "</h1>";
                    document.getElementById("t_description").innerHTML = "<h1>" + response.t_description + "</h1>";

                    // Show the generated items
                    document.getElementById("topic").style.display = "block";
                    document.getElementById("t_description").style.display = "block";
                } else {
                    console.error("Error: " + xhr.status);
                }
            };

            xhr.send();
        });
    </script>
    ';

    return $output;
}

// AJAX handler for generating random items
add_action('wp_ajax_generate_random_items', 'generate_random_items');
add_action('wp_ajax_nopriv_generate_random_items', 'generate_random_items'); // for non-logged-in users
function generate_random_items()
{
    // Connect to the database
    global $wpdb;
    if (is_null($wpdb)) {
        $wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    }

    // Set the table name
    $table_name = $wpdb->prefix . 'admin';

    // Fetch a random card name and t_description from the table
    $sql1 = "SELECT topic FROM $table_name ORDER BY RAND() LIMIT 1";
    $topic = $wpdb->get_var($sql1);

    $sql2 = "SELECT t_description FROM $table_name ORDER BY RAND() LIMIT 1";
    $t_description = $wpdb->get_var($sql2);

    // Prepare the response
    $response = array(
        'topic' => $topic ? $topic : '',
        't_description' => $t_description ? $t_description : '',
    );

    // Return the response as JSON
    wp_send_json($response);
}

?>