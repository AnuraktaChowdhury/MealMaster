<?php
session_start();
include('dbconnect.php');

if (isset($_GET['token'])) {

    $token = $_GET['token'];
    $verify_query = "SELECT verify_token,verify_status FROM account WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);


    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if ($row['verify_status'] == "0") {
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE account SET verify_status='1'WHERE verify_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if ($update_query_run) {
                echo '
		        <script>
		    	alert("Verification Successfull.");
			    window.location.href = "index.php";
		        </script>
		        ';

            } else {
                echo '
		        <script>
		    	alert("Verification failed.!");
			    window.location.href = "index.php";
		        </script>
		        ';
            }
        } else {
            echo '
            <script>
            alert("Email Already Verified. please Login");
            window.location.href = "index.php";
            </script>
            ';
        }
    }
} else {
    $_SESSION['status'] = "Not Allowed";
    header("Location: Login.php");
}



?>