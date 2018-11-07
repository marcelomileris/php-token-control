<?php
	session_start();
	include "../php/do.php";
	$do = new DoFunc();
	$do->isSession();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/img/avatar.png">

    <title>Token Control</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- JQuery.Confirm CSS -->
    <link href="../assets/plugins/jquery-confirm/jquery-confirm.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
  </head>


  	<h3>You are logged!!!</h3>
  	<br/>
  	<?php
  		echo "The session will last <b>" .(_TIME_/60) . "</b> minutes <br/><br/>";
  	?>
  	<p>each refresh of the page, will refresh the time. If there are no requests, the session ends and returns to the login.</p>


  
  <!-- JS -->
  <script src="../assets/js/jquery.js"> </script>
  <script src="../assets/js/bootstrap.min.js"> </script>
  <script src="../assets/plugins/jquery-confirm/jquery-confirm.min.js"> </script>
  <script src="../assets/plugins/jquery-validate/jquery.validate.min.js"> </script>
  
  <!-- Custom functions -->
  <script src="../assets/js/app.js"> </script>
</html>