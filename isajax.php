<?php
// this function is to check whether it is an AJAX call or a simple page load.
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $isAjax = true;
} else {
    $isAjax = false;
}
?>