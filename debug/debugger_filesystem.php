<?php



function isAjax(){
    return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

//Check if it is an AJAX request or a simple page load:
if( isAjax() ){// it's AJAX so we call AJAX function to respond it
   answerAjax();
}else{ // it is not AJAX, so we go on
    answerPageReq();
}
$current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$current_dir = getcwd();
function answerAjax(){
    $arr = array();
    $current_dir = htmlspecialchars($_POST["new_dir"]);
//    diskSpace($current_dir, 4);
    $arr["diskSpaceFree"] = diskSpace($current_dir, 1);
    $arr["diskSpaceTotal"] = diskSpace($current_dir, 2);
    $arr["diskSpacePercent"] = diskSpace($current_dir, 3);
    $arr["diskSpaceColor"] = diskSpace($current_dir, 4);
    $arr["dirTree"]= print_r(debugDir($current_dir), true); // the true parameter is to capture the results of print_r without printing it!
    echo json_encode($arr);
    die();
};
function answerPageReq(){
    // following line id to prevent these pages from being loaded directly (just from within debugger.php)
    defined( 'DEBUGGER_LOADED' ) or die ( 'This page is restricted' );
};

function diskSpace($current_dir, $whatYouWant){// this piece of code shows the available and used space of the servers hard drive
    $df = round(disk_free_space($current_dir)/(1024*1024*1024), 2); // $df contains the number of bytes available on "/"
    $ds = round(disk_total_space($current_dir)/(1024*1024*1024), 2);// $ds contains the total number of bytes available on "/"
    $dp = round((disk_free_space($current_dir)) / (disk_total_space($current_dir)) * 100, 2); // percentage of the available space
    $dc = "progress-bar-info"; // this is to determine the color of the progressbar (which shows the percentage) dependent om bootstrap classes...
    if( $dp < 50) {$dc = "progress-bar-success";}else if( $dp < 75){$dc = "progress-bar-warning";}else{$dc = "progress-bar-danger";};
    if ( $whatYouWant == 1){
        return ($df);
    } else if ( $whatYouWant == 2){
        return ($ds);
    } else if ( $whatYouWant == 3){
        return ($dp);
    } else {
        return ($dc);
    }
}

function debugDir($current_dir){
    $dh  = opendir($current_dir);
    while (false !== ($filename = readdir($dh))) {
        if( is_file($filename) ){
            $files[] = '<a href="http://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI].$filename.'"  target="_blank">'.'<button title="A link to this file" type="button" class="btn btn-default btn-xs"><span class="fa fa-file fa-lg fa-fw" style="color:darkcyan;"></span>'.$filename.'</button>'.'</a>';
        }else {
            if( $filename !== '.'){ // we don't need the current directory to be listed
                if( $filename !== '..'){ // if it is not parent dir...
                    if( is_dir($filename) ){ // so it is a directory for sure:
                        $files[] = '<button title="Directory (click to browse it)" id="'.$filename.'" onclick="change_dir(this);" type="button" class="btn btn-default btn-xs"><span class="fa fa-folder-open fa-lg fa-fw" style="color:orange;"></span>'.$filename.'<span style="margin-left:6px;" class="label label-info fa fa-plus-square"> '.count(glob($current_dir.'/'.$filename.'/*')).'</span></button>';
                    }else{ // so we don't know what it is exactly! (security restriction)
                        $files[] = '<button title="Unknown (because of security restrictions we can not read the file/type)" id="'.$filename.'" onclick="change_dir(this);" type="button" class="btn btn-default btn-xs"><span class="fa fa-question-circle fa-lg fa-fw" style="color:red;"></span>'.$filename.'<span style="margin-left:6px;" class="label label-info fa fa-plus-square"> '.count(glob($current_dir.'/'.$filename.'/*')).'</span></button>';
                    }
                }else{ // so it is the parent dir one (..)
                $files[] = '<button title="Parent folder.." id="'.$filename.'" onclick="change_dir(this);" type="button" class="btn btn-default btn-xs"><span class="fa fa-arrow-up fa-lg fa-fw" style="color:#333;"></span>'.$filename.'</button>';
                };
            };
        };
    };
    return($files);
    closedir($current_dir);
};
?>



<div class="panel panel-default">
    <div class="panel-heading">FileSystem</div>
    <ul class="list-group">
        <li class="list-group-item">Hard Drive Space:
            <div class="progress progress-striped active">
                <div id="disk_space_bar" class="progress-bar <?php echo diskSpace($current_dir, 4); ?>" role="progressbar" aria-valuenow="<?php echo diskSpace($current_dir, 2); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo diskSpace($current_dir, 3); ?>%">
                    <span><b><?php echo diskSpace($current_dir, 3); ?></b> % <small>( <?php echo diskSpace($current_dir, 1) . " of ".  diskSpace($current_dir, 2)." GB"; ?> )</small></span>
                </div>
            </div>
        </li>
    </ul>
    <ul class="list-group">
        <li class="list-group-item"><div style="width: 100%;" class="btn-group btn-group-sm"><button title="Link to this page." class="btn btn-default"><a href="<?php echo $current_url; ?>"><span style="margin: 0 10px;" class="fa fa-link fa-lg"></span></a></button><button id="current_dir" onclick="copyToClipboard(&quot;<?php echo $current_dir; ?>&quot;)" class="btn btn-default" title="Click to copy in the address to clipboard."><span style="margin: 0 10px;" class="fa fa-sitemap fa-lg"></span> <?php echo $current_dir; ?></button></div>
            <pre id="debug_dir_tree">
                <?php
                print_r(debugDir($current_dir));
                ?>
            </pre>
        </li>
    </ul>
</div>

<script>
//    url: "http://s429042910.onlinehome.fr/cv_cms_01/debug/debugger_filesystem.php",
var current_dir =  "<?php echo $current_dir; ?>/" ;
function change_dir(a){
        current_dir =  current_dir + (a.id) + "/" ;
        $.ajax({
        type: "POST",
        url: "http://s429042910.onlinehome.fr/cv_cms_01/debug/debugger_filesystem.php",
        data: { new_dir: current_dir }
        })
        .done(function( msg ) {
            console.log( "Data Saved: " + msg);
            $("#debug_dir_tree").replaceWith('<pre id="debug_dir_tree">'+jQuery.parseJSON(msg).dirTree+'</pre>');
            $("#disk_space_bar").replaceWith('<div id="disk_space_bar" class="progress-bar ' + jQuery.parseJSON(msg).diskSpaceColor + '" role="progressbar" aria-valuenow="'+ jQuery.parseJSON(msg).diskSpacePercent +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ jQuery.parseJSON(msg).diskSpacePercent +'%"><span><b>'+ jQuery.parseJSON(msg).diskSpacePercent +'</b> % <small>( '+  jQuery.parseJSON(msg).diskSpaceFree  + ' of '+  jQuery.parseJSON(msg).diskSpaceTotal +' GB )</small></span></div>');
            $("#current_dir").replaceWith('<button id="current_dir" onclick="copyToClipboard(&quot;'+current_dir+'&quot;)" class="btn btn-default" title="Click to copy in the address to clipboard."><span style="margin: 0 10px;" class="fa fa-sitemap fa-lg"></span>'+current_dir+'</button>');
        });
}


function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
</script>

