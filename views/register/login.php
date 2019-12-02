<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Login Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/register/login.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

<?php $this->end(); ?>

<?php $this->start('body') ?>

    <!-- Login Page Content -->
    <body>
        <div class="login-cntnr-div">

            <div class="login-cntnr-left">
                <div class="login-img-cntnr">
                    <img class="login-image" src="/assets/images/oakWoodcutCP.jpg" alt="" class="login-image">
                    <blockquote class="login-blockquote">
                        "An Oak tree is a daily reminder that great things often have small beginnings."<br>
                    </blockquote>
                    <cite class="login-blockquote-cite">― Matshona Dhliwayo</cite>
                </div>
            </div>

            <div class="login-cntnr-right">

            <form class="login-form" action="/register/login" method="post">
                <div class="login-form-top-div">
                    <h2 class="login-form-header">LOG IN</h2>

                        <?php $errors = (!empty($this->getErrors())) ? $this->getErrors() : [] ; ?>
                        <?php foreach ($errors as $error): ?>
                            <div class="login-errors-cntnr">
                                <p><?= $error; ?></p>
                            </div>
                        <?php endforeach; ?>

                    <input class="login-form-input" type="text" name="username" placeholder="USERNAME OR EMAIL" required>
                    <input class="login-form-input" type="password" name="password" placeholder="PASSWORD" required>
                    <label class="login-form-checkbox" for="remember_me">Remember Me  <input type="checkbox" id="remember_me" name="remember_me" checked=checked></label>
                    <a class="login-form-create" href="/register/register">Create an Account +</a>
                </div>
                <div class="login-form-bttm-div">
                    <input class="login-form-btn" type="submit" value="LOG IN">
                </div>

            </form>
        </div>
    </body>

<?php $this->end(); ?>
