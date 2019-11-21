<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: DETAIL Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/delete.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <body>
        
        <?php $plant = $this->getData(); ?>
        <div class="delete-popup-outer">
                <div class="delete-popup-inner">
                    <a href="/plants/index">
                        <span class="delete-close-span">
                            X
                        </span>
                    </a>
                    <div class="delete-popup-wrapper">
                        <ul class="delete-popup-list">
                            <li class="delete-popup-item"><h2>Confirm Delete for . . .</h2></li>
                            <li class="delete-popup-item"><p><?=$plant->genus?> <?=$plant->species?></p></li>
                            <li class="delete-popup-item"><form class="delete-popup-form" action="/plants/delete/<?=$plant->plant_id?>" method="POST"><input class="delete-submit" type="submit" name="delete-submit" value="Delete"></form><a class="delete-cancel-link" href="/plants/index"><button class="delete-cancel-btn">Wait! Stop!</button></a></li>
                        </ul>
                    </div>
                </div>
            </div>

    </body>

<?php $this->end(); ?>
