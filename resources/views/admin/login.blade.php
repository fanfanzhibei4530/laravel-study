<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/static/admin/login/css/bootstrap.min.css">

    <!-- Loding font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,700" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="/static/admin/login/css/styles.css">

    <title>Login</title>
</head>
<body>

    @include('admin.nav')

    <!-- Backgrounds -->
    <div id="login-bg" class="container-fluid">
        <div class="bg-img"></div>
        <div class="bg-color"></div>
    </div>

    <!-- End Backgrounds -->
    <div class="container" id="login">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="login">
                    <h1>Login</h1>
                    <!-- Loging form -->
                    <form id="login-form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="verify" placeholder="Verify">
                        </div>
    <!--                     <div class="form-check">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            <label class="forgot-password"><a href="#">Forgot Password?<a></label>
                        </div> -->
                        <button type="button" class="btn btn-lg btn-block btn-success btn-login" style="margin-top: 40px;">Sign in</button>
                    </form>
                    <!-- End Loging form -->
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    版权所有
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/static/admin/login/js/jquery-3.6.0.min.js"></script>
<script src="/static/admin/layer/layer.js"></script>
<script>
    $('.btn-login').click(function(){
        var username=$("#login-form input[name='username']");
        var password=$("#login-form input[name='password']");
        if(!username.val()){
            layer.msg('请输入用户名');
            return false;
        }
        if(!password.val()){
            layer.msg('请输入密码');
            return false;
        }
        $.ajax({
            type:'post',
            url:"/admin/login/login",
            data:{
                username:username.val(),
                password:password.val(),
                _token:"{{ csrf_token() }}",
            },
            dataType:'json',
            timeout:5000,
            success:function(data){
                if(data.code==200){
                    layer.msg(data.msg);
                    setTimeout(function() {
                        window.location.href = "/admin";
                    }, 1000);
                }else{
                    layer.msg(data.msg, {
                        icon: 5
                    });
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    })
</script>

</html>