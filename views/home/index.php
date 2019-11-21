<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>
    <!-- The css link below only provides styles for the body of the idnex page. Each page should have their own
         specific CSS link in the page head. The layout/navbar/footer CSS is provided through the layout. -->
    <link rel="stylesheet" type="text/css" href="/assets/css/home/index.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <div class="page-head-cntnr">
        <div>
            <h2 class="page-headline">Welcome!</h2>
            <p class="page-detail">Log in to access the plantTracker application.</p>
            
            <br><br><br><br><br>

            <h2>Session:</h2><br> <?php 
                                echo '<pre>';
                                var_dump($_SESSION); 
                                echo '</pre>';
                               ?>
            
            <br><br><br><br>

            <h2>Cookie</h2><br> <?php
                                  echo '<pre>';
                                  var_dump($_COOKIE);
                                  echo '</pre>';
                                ?>
            <br><br><br><br><br>
            <?php echo 'ROOT: ' . ROOT; ?>

        </div>
    </div>

<?php $this->end(); ?>
