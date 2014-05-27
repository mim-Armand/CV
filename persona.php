<?php
function checkPersona() {
    global $adminEmail;
    global $isUserLogedIn;
    global $beingParanoid;
    global $jsonArray;
    global $act;
    global $commandToClient;
    $isUserLogedIn = false;
    if($act =='killUser'){
        $isUserLogedIn = false;
        $beingParanoid = true;
        session_destroy();
        setcookie('mimses', "", time() - 3600);
        $commandToClient = 'refresh';
    }
    $isUserLogedIn = false;
    if (!$beingParanoid && $act!=='auth' && isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        $isUserLogedIn = true;
        $jsonArray['PARANOID'] = false;
    } else {
        $jsonArray['PARANOID'] = true;
        if (isset($_POST['assertion']) && !empty($_POST['assertion'])) {
            
            // if asserstion value exist in the received package then it is an auth request (or combined):
            $persona = new Persona();
            $result = $persona->verifyAssertion($_POST['assertion']);
            if ($result->status === 'okay') {
                
                // if the result of Persona Auth is successful
                if ($result->email === $adminEmail) {

                    // and if the e-mail being authenticated is exactly the same as was provided (ad admin), then ... well! everything is set so we gain the user access to admin page
                    $isUserLogedIn = true;
                    $_SESSION['userLoggedIn'] = true;
                } else {
                    $isUserLogedIn = false;
                    
                    //TODO: should it die here ???!
                    // otherwise, it means that sombody else (or user her/himself) is trying to login with a different e-mail, which we won't let them to! (here we should tell them that you can login JUST and Just using the admin email)
                    //TODO: let the user know that s/he needs to login with his admin email
                }
            } else {
                $isUserLogedIn = false;
                $jsonArray['WHY PERSONA?!'] = $result->reason;
                // in case of getting an error from Persona, we through out propper info to user here:
            }
        } else {
            // Auth request with no assertion will result in logging out and destroying the session
            $isUserLogedIn = false;
            $_SESSION['userLoggedIn'] = false;
        } 
    }
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
?>