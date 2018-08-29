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
            <div id="user_model_details"></div>
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
        
        function make_chat_dialog_box(to_user_id, to_user_name){

            var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chaet with '+to_user_name+'">';

            modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
            modal_content +='</div>';
            modal_content +='<div class="form-group">';

            modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';

            modal_content += '</div><div class="form-group" align="right">';

            modal_content += '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn bt-info send_chat">Send</button></div></div>';

            $('#user_model_details').html(modal_content);
        }

        $(document).on('click', '.start_chat', function () {
            var to_user_id = $(this).data('touserid');
            var to_user_name = $(this).data('tousername');
            make_chat_dialog_box(to_user_id, to_user_name);
            $("#user_dialog_"+to_user_id).dialog({
                autoOpen: false,
                width:400
            });
            $('#user_dialog_'+to_user_id).dialog('open');
        });
        
    });
</script>