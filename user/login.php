<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: /?route=login_success");
}
?>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="/static/css/login.css">
    <script>
        $(function() {
            // 
            $("form[name=login-form]").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: "Please enter a valid email address"
                },
                submitHandler: function(form) {
                    var url = window.location.href;
                    var url_split = url.split("?");
                    var params = "";
                    if (url_split.length > 1) {
                        params = '*' + url_split[1];
                    }
                    data = $('form').serialize();
                    if (params) {
                        data = data + encodeURIComponent(params);
                    }
                    $.ajax({
                        type: 'post',
                        url: '/controller/login.php',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.location);
                            if (response.location) {
                                var message = document.getElementsByClassName("alert-success");
                                $(message).show();
                                window.location.href = response.location;
                            }

                            if (response.errors) {
                                var errors = response.errors;

                                var message = document.getElementById("login-error");

                                message.innerHTML = "Incorrect information";
                                var alert = document.getElementsByClassName("alert-warning");
                                $(alert).show();
                                $(alert).hide(2000);

                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</head>

<!------ Include the above in your HEAD tag ---------->

<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <div class="alert alert-warning">
                            <strong>Error!</strong><span id='login-error'></span>
                        </div>
                        <form id="login-form" name="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="register.php" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>