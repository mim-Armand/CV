<?php

//TODO: keep email adress in BCRYPTED format only
error_reporting(-1);
mimSesManager();

// it should be the first call in the page! (session and NOUNCE manager
$adminEmail = 'mim3dot@gmail.com';

//FixMe: this should be dynamic in final realease!
$isUserLogedIn = false;
$admin_page_address = findAdminPageAddress();
//Check if it is an AJAX request or a simple page load and call the appropriate function for each:
if (isAjax()) {
    answerAjax();
} else {
    answerPageReq();
}

/*************************************************** FUNCTIONS: **************************************************/
function answerAjax() {
    checkPersona();
    die;
}
function answerPageReq() {
}
function isAjax() {
    
    // this function is to check whether it is an AJAX call or a simple page load.
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}
function mimSesManager() {
    
    // Session and NOUNCE manager function
    session_name("mimses");
    
    // cookie and session name!
    session_start();
    if (!isset($_SESSION['CSRFToken'])) {
        
        // so: First time user (that means s/he should be landed on login page (logged-out) and that her/his session is expired - but it' ok and is not suspicious!
        echo 'is not set yet!';
        
        // each time regenerating the session ID and change the session cookie value (NOUNCE)
        $_SESSION['CSRFToken'] = UUIDGen(6);
        
        // set the CSRF protection in the session (serverside) --> we need to send it back to client each time it changes!
        echo "$_SESSION[CSRFToken]";
    } else {
        if (isset($_POST['tok']) and $_POST['tok'] === $_SESSION['CSRFToken']) {
            
            //check the received value against the one in session, if it matches go ahead, otherwise...
            session_regenerate_id(TRUE);
            
            // each time regenerating the session ID and change the session cookie value (NOUNCE)
            $_SESSION['CSRFToken'] = UUIDGen(6);
            
            // set the CSRF protection in the session (serverside) --> we need to send it back to client each time it changes!
            echo "$_SESSION[CSRFToken]";
        } else {
            if (isAjax()) {
                
                //If it is AJAX it is VERYYYYY suspicious!!! if it is not AJAX we should simply log-out (if in) and show the log-in page
                echo 'YOU ARE A BAAAAAAAAAAAAD PERSON!';
                
                //                die;
                
            }
        }
    }
}
function UUIDGen($len) {
    
    // Function to create a UUID in each call (to use with session and nounce manager function and/or other parts if needed)
    return bin2hex(openssl_random_pseudo_bytes($len, $cstrong));
}
function findAdminPageAddress() {
    $adadd = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $adadd.= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
    return $adadd;
}
function checkPersona() {
    global $isUserLogedIn;
    $isUserLogedIn = false;
    // the default value, later we'll set true if proved to be.
    global $adminEmail;
    if (isset($_POST['assertion'])) {
        // if asserstion value exist in the received package then it is an auth request:
        $persona = new Persona();
        $result = $persona->verifyAssertion($_POST['assertion']);
        if ($result->status === 'okay') {
            // if the result of Persona Auth is successful
            if ($result->email === $adminEmail) {
                // and if the e-mail being authenticated is exactly the same as was provided (ad admin), then ... well! everything is set so we gain the user access to admin page
                $isUserLogedIn = true;
                buildAdminPage();
            } else {
                die;
                 //TODO: should it die here ???!
                // otherwise, it means that sombody else (or user her/himself) is trying to login with a different e-mail, which we won't let them to! (here we should tell them that you can login JUST and Just using the admin email)
                //TODO: let the user know that s/he needs to login with his admin email
                
            }
        } else {
            echo $result->reason;
            
            // in case of getting an error from Persona, we through out propper info to user here:
            $body = "<p>Error: " . $result->reason . "</p>";
        }
    } elseif (!empty($_GET['logout'])) {
        
        // logout
        $body = "<p>You have logged out.</p>";
    } else {
        
        // here we show login page and options to user:
        $body = "<p><a class=\"persona-button\" href=\"javascript:navigator.id.request()\"><span>Login with Persona</span></a></p>";
    }
    
    //    echo $isUserLogedIn ? 'true' : 'false';
    
    
}

// this is the persona verification class:
class Persona
{
    protected $audience;
    public function __construct($audience = NULL) {
        $this->audience = $audience ? $audience : $this->guessAudience();
    }
    public function verifyAssertion($assertion) {
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
    protected function guessAudience()
    
    /*Guesses the audience from the web server configuration*/ {
        $audience = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $audience.= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . ':' . $_SERVER['SERVER_PORT'];
        /* To make the user logged-in JUST in the admin.php file and nowhere else in the server (in the case where somewhere else in the same server Persona is used again and you don't want the current auth verification be valid -otherwise remove the PHP_SELF part-) */
        return $audience;
    }
}

/********************************************************** VIEW CONSTRUCTORS ********************************************/
function buildAdminPage() {
  global $isUserLogedIn;
  if($isUserLogedIn){
    echo 'ZZZZZZZZZzzzzzzzzzzZZZzzzZZZZZZZzzs';
  }
}

/********************************************************** VIEWS ********************************************************/

$header = <<<'MIM'
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
MIM;
$footer = <<<MIM
<script type="text/javascript">
    admin_page_address = "$admin_page_address";
    tok = "$_SESSION[CSRFToken]";
  </script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1-rc2/jquery.min.js"></script>
  <script src="https://login.persona.org/include.js"></script>
  <script src="mim.js"></script>
</body>
</html>
MIM;
$loginBody = <<<'MIM'
<p><a id="signout" href="javascript:navigator.id.logout()">Logout</a></p>

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
MIM;
?> 
<?php
echo $header;
echo $loginBody;
echo $footer; ?>