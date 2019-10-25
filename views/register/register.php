<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Register Page Styles -->
    <link rel="stylesheet" type="text/css" href="/public/css/register/register.css" />
    <link rel="stylesheet" type="text/css" href="/public/css/global/error.css"/>

<?php $this->end(); ?>

<?php $this->start('body') ?>

    <!-- Register Page Content -->
    <main>
        <div class="reg-cntnr-div">

            <div class="reg-cntnr-left">
                <div class="reg-img-cntnr">
                    <img class="reg-image" src="/public/images/salviaCarduacea.jpg" alt="">
                    <blockquote class="reg-blockquote">
                        "And forget not that the earth delights to feel your bare feet and the winds long to play with your hair."<br>
                    </blockquote>
                    <cite class="reg-blockquote-cite">― Khalil Gibran</cite>
                </div>
            </div>

            <div class="reg-cntnr-right">
                <form class="reg-form" action="/register/register" method="post">
                    <div class="reg-form-top-div">
                        <h2 class="reg-form-header">CREATE AN ACCOUNT</h2>
                        <?= $this->getErrors(); ?>
                        <input class="reg-form-fname" type="text" name="first_name" placeholder="FIRST NAME" value="<?=$this->_post['first_name']?>" required>
                        <input class="reg-form-lname" type="text" name="last_name" placeholder="LAST NAME" value="<?=$this->_post['last_name']?>" required>
                        <input class="reg-form-input" type="email" name="email" placeholder="EMAIL ADDRESS" value="<?=$this->_post['email']?>" required>
                        <input class="reg-form-input" type="text" name="username" placeholder="CHOOSE A USERNAME" value="<?=$this->_post['username']?>" required>
                        <input class="reg-form-input" type="password" name="password" placeholder="PASSWORD" required>
                        <input class="reg-form-input" type="password" name="password_confirm" placeholder="CONFIRM PASSWORD" required>
                        <textarea class="reg-form-text" name="use_case" cols="30" rows="10" placeholder="DESCRIBE USE CASE"></textarea>
                    </div>
                    <div class="reg-form-bttm-div">
                        <div><a class="reg-form-gohome" href="/home/index">RETURN HOME</a></div>
                        <div><input class="reg-form-btn" type="submit" value="REGISTER"></div>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php $this->end(); ?>
