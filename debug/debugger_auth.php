<?php // following line id to prevent these pages from being loaded directly (just from within debugger.php)
defined( 'DEBUGGER_LOADED' ) or die ( 'This page is restricted' ); ?>

<?php
$ip = ip2long($_SERVER['REMOTE_ADDR']);
if($ip !== 1437137666){//allowed IP. Change it to your static IP
header('HTTP/1.0 404 Not Found');
die('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Err</strong>or number: <strong>'. $ip .'</strong></div><hr>SORRY YOU <b>CANT</b> VISIT THIS PAGE !!! <br> <small> Looks like your IP address is restricted on this server! </small><br><hr>');
};

?>

<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  You are <strong>Allowed in!</strong> Your IP address is : <strong><?php echo $ip; ?></strong>
</div>