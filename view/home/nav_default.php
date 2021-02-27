<?php
$uri = $_SERVER["REQUEST_URI"];
$current_uri = ltrim($uri, "/");
$login_view = '/user/login.php';
$register_view = '/user/register.php';
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a id="flechazo-logo" class="navbar-brand" href="/"><img src="/static/images/logo.png" alt="Flechazo Shop"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $register_view . $current_uri; ?>">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $login_view . $current_uri; ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>