<!DOCTYPE html>
<html lang="en">

<head>    
    <!-- Browser Defaults -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="/assets/css/layouts/default.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Questrial&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        <!-- Icons -->
    <script src="https://kit.fontawesome.com/93e3a80b1b.js"></script>
    <!-- Index Title -->
    <title><?= $this->getTitle(); ?></title>
    <!-- Insert additional HEAD content here. -->
    <?= $this->content('head'); ?>
</head>

<body>

    <div class="nav-container">
        <div class="nav-cntnr-left">
            <a class="nav-logo-link" href="/home/index" title="Return Home">plant<b class="logo-accent">Tracker</b></a>
        </div>
        <div class="nav-cntnr-right">
            <ul class="nav-list">
                <li class="nav-list-item">
                    <a class="login-link" href="/plants/index" title="Plant Search">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
                <li class="nav-list-item">
                    <a class="login-link" href="/register/index" title="Login/Register">
                        <i class="far fa-user-circle"></i>
                    </a>
                </li>
                <li class="nav-list-item">
                    <a class="login-link" href="/register/logout" title="Navigation">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Insert BODY content here. -->
    <?= $this->content('body'); ?>

</body>