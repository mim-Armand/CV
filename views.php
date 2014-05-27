<?php
/********************************************************** VIEWS ********************************************************/
$view_menu_top = <<<'MIM'
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <span class="navbar-brand" href="#">Hi <strong>user</strong>, welcome to mim CV!</span>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Edit your CV content!</a></li>
                            <li><a href="#">Edit skins!</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings... <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" onclick="logout()">Log out</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-question-circle"></span>  <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li role="presentation" class="dropdown-header">Usefull stuff!</li>
                                    <li><a href="#">Help</a></li>
                                    <li><a href="#">About CV!</a></li>
                                    <li><a href="#">Project website</a></li>
                                    <li><a href="#"><span style="color: red;" class="fa fa-git-square"></span> Project repository</a></li>
                                    <li class="divider"></li>
                                    <li role="presentation" class="dropdown-header">CV! Creators</li>
                                    <li><a href="#">3Dot's Art group</a></li>
                                    <li><a href="#">mim.Armand</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
MIM;
$loader = <<<'MIM'
<div id="page_loader_mask" class="loader">Loading...</div>
MIM;
$login = <<<'MIM'
<div id="page_loader_mask"><div class="loader">Loading...</div></div>
<p><a id="signout" href="javascript:navigator.id.logout()">Logout</a></p>

  <div class="container"><br>
    <div id="jumbotron">
    <div id="login_form">
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
  </div>
MIM;
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
  <link rel="stylesheet" href="css/mim.css">
</head>
<body>
MIM;
$footer = <<<MIM
<script type="text/javascript">
    var admin_page_address = "$admin_page_address";
    var tok = "$_SESSION[CSRFToken]";
  </script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1-rc2/jquery.min.js"></script>
  <script src="https://login.persona.org/include.js"></script>
  <script src="mim.js"></script>
</body>
</html>
MIM;
?>