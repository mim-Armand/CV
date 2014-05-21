<?php // following line id to prevent these pages from being loaded directly (just from within debugger.php)
defined( 'DEBUGGER_LOADED' ) or die ( 'This page is restricted' ); ?>

<?php

function printServerHeader(){
    $sl = sizeof($_SERVER);
    foreach ( $_SERVER as $key => $value) {
        echo "<tr> <td>$key</td><td>$value</td> </tr>";
    }
}
echo '<div class="panel panel-default"><div class="panel-heading">Server Header and Environment Information:</div> <div class="table-responsive"><table class="table table-striped table-bordered table-hover table-condensed"> <th class="info">Server Header key</th><th class="info">Server Header value</th>';
printServerHeader();
//echo $_SERVER['SCRIPT_FILENAME']."<br>";
echo '</table></div></div>';
?>
