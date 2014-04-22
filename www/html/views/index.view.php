
<script>
    function checkLogin() {
        if ($('#loginUsername').val() == "") {
            $('#error').html("Enter a valid username.");
            $('#errorDiv').show("normal");
            return false;
        }
        if ($('#loginPassword').val() == "") {
            $('#error').html("Enter a valid password");
            $('#errorDiv').show("normal");
            return false;
        }
        return true;
    }
    
    function setFocus() {
        if ($('#username').val() == "") {
            $('#username').focus();
        } else if ($('#password').val() == "") {
            $('#password').focus();
        }
    }

    window.onload = setFocus;
    
</script>

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
        
        <div id="errorDiv" class="text-danger">
            <p id="error"></p>
        </div>
        
        <form class="form-inline" role="form" action="/auth/login" method="post" onsubmit="return checkLogin();">
            <div class="form-group">
                <label class="sr-only" for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username..." />
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password..." />
            </div>
            <button type="submit" class="btn btn-success">Sign In</button>
        </form>
    </div>
    
</div>
