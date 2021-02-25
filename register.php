<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="static/css/register.css">
    <script>
        $(function() {
            // 
            $("form[name=register-form]").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        minlength: 6
                    },
                    re_password: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email: "Please enter a valid email address"
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: 'post',
                        url: 'controller/register.php',
                        data: $('form').serialize(),
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
                                errors.forEach(err => {
                                    var message = document.getElementById("register-error");
                                    message.innerHTML = err;
                                    var alert = document.getElementsByClassName("alert-warning");
                                    $(alert).show();
                                })
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
                        <div class="alert alert-success">
                            <strong>Success!</strong> Your account has been created!.
                        </div>
                        <div class="alert alert-warning">
                            <strong>Error!</strong><span id='register-error'></span>
                        </div>
                        <form id="register-form" name="register-form" class="register-form" action="" method="post">
                            <h3 class="text-center text-info">Register</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Email:*</label><br>
                                <input type="text" required name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:*</label><br>
                                <input type="password" required name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Repeat Password:*</label><br>
                                <input type="password" required name="re_password" id="re_password" class="form-control">

                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Name:*</label><br>
                                <input type="text" required name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Bio</label><br>
                                <input type="text" name="bio" id="bio" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="sex" class="text-info">Sex*</label><br>
                                <select class="form-select" name="sex" aria-label="Default select example">
                                    <option selected value="male">male</option>
                                    <option value="female">female</option>
                                    <option value="other">other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Birth Day</label><br>
                                <input type="date" id="birthday" required name="birthday">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Register">
                            </div>
                            <div class="container signin">
                                <p>Already have an account? <a href="login.php">Sign in</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>