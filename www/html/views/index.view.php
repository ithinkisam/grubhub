<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="All your recipes. In one place. Available everywhere.">
        <meta name="author" content="Sam Butler">
        <meta name="keywords" content="recipe,food,sam butler">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="apple-touch-icon" href="/img/apple-touch-icon.png" />
        <meta name="apple-touch-startup-image" href="/img/apple-touch-startup.png" />
        
        <link href="/css/font-awesome.css" rel="stylesheet">
        <link href="/css/bootstrap_journal.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/fullcalendar.css" rel="stylesheet">
        <link rel="icon" type="image/ico" href="/img/favicon.ico">
        
        <title>The Grub Hub</title>
    </head>
    <body class="landing-page">

        <script>
            function checkLogin() {
                console.log("checkLogin() called");
                if (document.getElementById("loginUsername").value == "") {
                    $("#error").html("Enter a valid username.");
                    $("#error-div").show('normal');
                    return false;
                }
                if (document.getElementById("loginPassword").value == "") {
                    $('#error').html("Enter a valid password.");
                    $('#error-div').show('normal');
                    return false;
                }
                processLogin();
                return false;
            }

            function processLogin() {
                var abc123 = $("#loginUsername").val();
                var def456 = $("#loginPassword").val();
                $.post("/grubhubv2/web/_custom_pages/process_login.php",
                    { user: abc123, pass: def456 })
                    .done( function(data) {
                                if (data == "") {
                                    location = "/grubhubv2/web/";
                                } else {
                                    $("#error").html("Invalid username/password.");
                                    $("#error-div").show("normal");
                                }
                           });
            }
        </script>
        
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://ithinkisam.com">ithinkisam</a></li>
                        <li><a href="tutorials/">Tutorials</a></li>
                        <li><a href="signup/">Sign Up</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container center text-center">
        
            <div class="hidden-xs" style="padding-top: 4em;"></div>
            
            <div class="col-lg-5 col-md-5 col-sm-4 hidden-xs pull-right">
                <div class="row visible-sm" style="padding-top: 5em;"></div>
                <div id="carousel-logos" class="carousel slide" data-ride="carousel" data-interval=3500>
                    <ol class="carousel-indicators"></ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="/img/logos/logo_plain_cookies.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_tomatoes.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_pasta.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_roasted.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_strawberries.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_dessert.png" class="img-responsive">
                        </div>
                        
                        <div class="item">
                            <img src="/img/logos/logo_plain_kiwi.png" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-12 pull-left">
                <div class="page-header text-left">
                    <h1>The Grub Hub</h1>
                    <p class="lead">All your recipes. In one place. Available everywhere.</p>
                </div>
                
                <div id="error-div" class="text-danger">
                    <p id="error"></p>
                </div>
                
                <form class="form-inline" role="form" action="" method="post" onsubmit="return checkLogin();">
                    <div class="form-group">
                        <label class="sr-only" for="loginUsername">Username</label>
                        <input type="text" class="form-control" id="loginUsername" placeholder="Username..." />
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="loginPassword">Password</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Password..." />
                    </div>
                    <button type="submit" class="btn btn-success">Sign In</button>
                </form>
            </div>
            
        </div>

        <script src="/js/jquery.min.js" ></script>
        <script src="/js/jquery-ui.min.js" ></script>
        <script src="/js/bootstrap.min.js" ></script>
        <script src="/js/script.js" ></script>
        <script src="/js/fullcalendar.min.js" ></script>
        <script src="/js/gcal.js" ></script>
        <script src="/js/jquery.ui.touch-punch.min.js" ></script>
    </body>
</html>
