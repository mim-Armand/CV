<?php
//session_start();
//if(isset($_SESSION['views']))
//    $_SESSION['views'] = $_SESSION['views']+ 1;
//else
//    $_SESSION['views'] = 1;
//
//echo "views = ". $_SESSION['views'];
?>
<?php define( 'DEBUGGER_LOADED', TRUE ); //<!-- this is to prevent people to access other php files directly (the boolean is set to true just here and in included pages we check for the variable)
//include ("debugger_persona.php");
?>

<?php // Report all PHP errors (see changelog)
      error_reporting(E_ALL);
//      // Report all errors except E_NOTICE
//        error_reporting(E_ALL & ~E_NOTICE);
      ?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="debug/debugger.css">


<div class="container">
<div class="page-header">
<?php
 include ("debugger_auth.php");
 ?>
  <h1>PHP Debugger files<small> -<b> NOT</b> in production !!!</small></h1>
</div>
    <div class="jumbotron">





<?php
include ("debugger_sqlite3.php");
//include ("debugger_filesystem.php");
//include ("debugger_cookie.php");
include ("debugger_server_header.php");
?>


  </div>
</div>