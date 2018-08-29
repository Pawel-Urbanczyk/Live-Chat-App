<?php

include ('database_connection.php');

session_start();

if(!isset($_SESSION['user_id'])){

    header('Location:login.php');

}

?>

<html>
<head>
    <title>Live Chat Application</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div class="container">
        <h3 align="center">Live Chat Application</h3>

        <div class="table-responsive">
            <h4 align="center">Online User</h4>
            <p align="right">Hi -<b> <?php echo $_SESSION['username']; ?></b>-<a href="logout.php">LogOut</a></p>
            <div id="user_details"></div>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function () {

        fetch_user();
        
        setInterval(function(){
            update_last_activity();
            fetch_user();
        }, 5000);

        function fetch_user() {

            $.ajax({
                url:"fetch_user.php",
                method: "POST",
                success:function(data){
                    $('#user_details').html(data);
                }
            })

        }
        
        function update_last_activity() {

            $.ajax({
                url:"update_last_activity.php",
                success:function () {

                }
            })
        }
        
    });
</script>