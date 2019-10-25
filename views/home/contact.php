<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
    
    <div>
        
        <h2>Subscribe to our Newsletter</h2>
        <i>The plantTracker newsletter is sent out once per month on the second Friday.</i>
        <hr><br><br>

        <div>
            <?php

            /* Use alternate expression with function filter_has_var instead of isset($_POST['submit']) pattern. */
            if(filter_has_var(INPUT_POST, 'submit')) {
                /* Place form data into $variables. */
                $firstName = $_POST['first-name'];
                $lastName  = $_POST['last-name'];
                $email     = $_POST['email'];
                $message   = $_POST['message'];
                /* Check for required fields. */
                if ( !empty($firstName) && !empty($lastName) && !empty($email) && !empty($message) ) {
                    header('Location: ../index.php?result=success');
                } else {
                    header('Location: ../index.php?result=error&first-name=' . $firstName . '&last-name=' . $lastName . '&email=' . $email);
                }
            }

            if (isset($_GET['result'])) {
                if ($_GET['result'] == 'success') {
                    echo '<i>Thank you for the submission!</i><br><br>';
                } else if ($_GET['result'] == 'error') {
                    echo '<i>Please fill out all fields!</i><br><br>';
                }
            }

            ?>
        </div>

        <form method="POST" action="index.php">
            <label>First Name</label><br>
            <input type="text" name="first-name" placeholder="first name" value="<?php if (isset($_GET['first-name'])) { echo $_GET['first-name']; } ?>" ><br><br>
            <label>Last Name</label><br>
            <input type="text" name="last-name" placeholder="last name" value="<?php if (isset($_GET['last-name'])) { echo $_GET['last-name']; } ?>"><br><br>
            <label>Email</label><br>
            <input type="email" name="email" placeholder="email address" value="<?php if (isset($_GET['email'])) { echo $_GET['email']; } ?>"><br><br>
            <label>Message</label><br>
            <textarea cols="30" rows="10" name="message"></textarea><br><br>
            <input type="submit" name="submit" value="Submit!">
        </form>

    </div>

<?php $this->end(); ?>