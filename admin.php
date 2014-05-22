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
function answerAjax(){
echo 'OK!';
die;
}
function answerPageReq(){
echo 'page request!';
}
class Persona
{
    /**
     * Scheme, hostname and port
     */
    protected $audience;

    /**
     * Constructs a new Persona (optionally specifying the audience)
     */
    public function __construct($audience = NULL)
    {
        $this->audience = $audience ? $audience : $this->guessAudience();
    }

    /**
     * Verify the validity of the assertion received from the user
     *
     * @param string $assertion The assertion as received from the login dialog
     * @return object The response from the Persona online verifier
     */
    public function verifyAssertion($assertion)
    {
        $postdata = 'assertion=' . urlencode($assertion) . '&audience=' . urlencode($this->audience);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://verifier.login.persona.org/verify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Guesses the audience from the web server configuration
     */
    protected function guessAudience()
    {
        $audience = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $audience .= $_SERVER['SERVER_NAME'] . ':'.$_SERVER['SERVER_PORT'];
        return $audience;
    }
}
?>



<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MIM CV! V0.1</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/amelia/bootstrap.min.css">-->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
 </head>
 <body>

 <!--<?php // include ("debug/debugger.php");
 ?> -->

<div class="container"><br>
<div class="jumbotron">


<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Hi there!</strong><br> You need to log-in to be able to edit your CV!<br>
  Cookies shoul be enabled for this CMS to work properly.
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Please Login</h3>
  </div>
  <div class="panel-body">
    <button id="signin" class="btn btn-default btn-block"><i class="fa fa-3x fa-key text-muted"></i></button>
  </div>
  <div class="panel-footer text-muted"><small>mim CV uses best <a href="#">security practices</a> to protect you!</small>
    <a href="#" class="pull-right">More info <i class="fa fa-question-circle"></i></a>
  </div>
</div>

</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1-rc2/jquery.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<script src="mim.js"></script>
 </body>
</html>