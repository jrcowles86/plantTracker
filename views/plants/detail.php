<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: DETAIL Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/detail.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

    <!-- Javascript -->
    <script type="text/javascript" src="/assets/js/delete.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <body>
    
        <!-- Plants Detail Page Container -->
        <div class="detail-page-cntnr">
        <?php $plant = $this->getData(); ?>
            
        <!-- Delete Confirm Pop-Up -->
        <div class="delete-popup-outer" style="visibility: hidden;">
            <div class="delete-popup-inner">
                <span class="delete-close-span">
                    X
                </span>
                <div class="delete-popup-wrapper">
                    <ul class="delete-popup-list">
                        <li class="delete-popup-item"><h2>Confirm Delete for . . .</h2></li>
                        <li class="delete-popup-item"><p><?=$plant->genus?> <?=$plant->species?></p></li>
                        <li class="delete-popup-item"><form class="delete-popup-form" action="/plants/delete/<?=$plant->plant_id?>" method="POST"><input class="delete-submit" type="submit" name="delete-submit" value="Delete"></form><button class="delete-cancel-btn">Wait! Stop!</button></li>
                    </ul>
                </div>
            </div>
        </div>

            <!-- Detail Title Container -->
            <div class="detail-title-cntnr">

                <!-- Title Image Div -->
                <div class="title-image-div">
                    <div class="plant-image-cntnr">
                        <?= '<img src="/assets/images/' . $plant->genus . '_' . $plant->species . '.jpg' . '" title="' . $plant->genus . ' ' . $plant->species . '">'; ?>
                    </div>
                </div>

                <!-- Title Description Div -->
                <div class="title-descr-div">
                    <div class="title-descr-cntnr">
                        <ul class="title-descr-list">
                            <li><p class="plant-genus"><?= $plant->genus; ?></p><p class="plant-species"><?= $plant->species; ?></p></li>
                            <li>
                                <p class="plant-order-family">Member of the <?php if (!empty($plant->order_)): ?>order <b><?= $plant->order_ ?></b> and the <?php endif; ?>family <b><?= $plant->family ?></b></p>
                            </li>
                            <li class="plant-icons-item">
                                <a class="plant-index-link" href="/plants/index" title="Back to Plants"><i class="fas fa-arrow-alt-circle-left"></i></a>
                                <a class="plant-update-link" href="/plants/update/<?= $plant->plant_id?>" title="Edit this Plant"><i class="fas fa-edit"></i></a>
                                <i class="fas fa-trash-alt" id="delete-icon" title="Delete this Plant"></i>

                                <?php  
                                
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "updatesuccess") {
                                        echo '<p class="update-message-success">Record updated successfully!</p>';
                                    } else if ($_GET['error'] == "updatefailed") {
                                        echo '<p class="update-message-error">Failed to update record!</p>';
                                    }
                                }
                                
                                ?>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Detail Body Container -->
            <div class="detail-body-cntnr">

                <!-- Detail LEFT-TOP Div -->
                <div class="detail-left">
                    <div class="detail-left-cntnr">
                        <div class="detail-left-wrapper">
                            <h2>Plant Specifics</h2>
                            <ul class="plant-specifics-list">
                                <?php if (!empty($plant->order_)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Order:&nbsp;</b></p>
                                        <a href="https://en.wikipedia.org/wiki/<?= $plant->order_; ?>"><?= $plant->order_; ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->family)): ?>
                                <li class="plant-specifics-item">
                                    <p><b>Family:&nbsp;</b></p>
                                    <a href="https://en.wikipedia.org/wiki/<?= $plant->family; ?>"><?= $plant->family; ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->genus)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Genus:&nbsp;</b></p>
                                        <a href="https://en.wikipedia.org/wiki/<?= $plant->genus; ?>"><?= $plant->genus; ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->species)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Species:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->species; ?></p>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->subspecies)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Subspecies:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->subspecies; ?></p>
                                </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->variety)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Variety:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->variety; ?></p>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->cultivar)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Cultivar:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->cultivar; ?></p>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->common_name)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Common Name:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->common_name; ?></p>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->mature_size)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Mature Size:&nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->mature_size; ?></p>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->requirements)): ?>
                                    <li class="plant-specifics-item">
                                        <p><b>Requirements: &nbsp;</b></p>
                                        <p class="detail-para"><?= $plant->requirements; ?></p>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <p class="inventory-para"> Inventory: &nbsp;<b><?= $plant->inventory; ?></b>
                        </div>
                    </div>

                    <!-- Detail LEFT-BOTTOM Div -->
                    <div class="detail-left-btm">
                        <div class="left-btm-wrapper">
                            <h2>API Project</h2><br><br>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit nostrum non assumenda molestias 
                                numquam architecto labore consequatur accusantium error sapiente, fugiat fuga mollitia cum? Vel 
                                corporis voluptatibus veniam blanditiis ipsa facilis? Id, explicabo. Officiis sapiente illum, odio 
                                distinctio facere fuga explicabo dolores earum officia voluptatum molestiae, veniam tempore 
                                nesciunt repellendus rerum expedita cupiditate corporis, magnam perspiciatis quo eveniet pariatur. 
                                Officia repellat deleniti, iusto unde nobis atque illum voluptatum tempora officiis. Odit quasi 
                                delectus accusamus? Modi, nostrum iste provident aspernatur quas amet repellat doloribus facilis 
                                omnis, ratione est enim vitae harum minima quam eaque natus maxime obcaecati dolor! Necessitatibus,
                                animi maiores quam quasi consequuntur consequatur.</p>
                        </div>
                    </div>
                </div>

                <!-- Detail RIGHT-TOP Div -->
                <div class="detail-right-top">
                        <div class="right-top-wrapper">
                            <h2>Online Resources</h2>
                            <ul class="plant-resources-list">
                                <?php if (!empty($plant->calflora)): ?>
                                    <li class="plant-resources-item">
                                        <p>Calflora</p><br>
                                        <a href="<?= $plant->calflora ?>"><?= $plant->calflora ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->calscape)): ?>
                                    <li class="plant-resources-item">
                                        <p>Calscape</p><br>
                                        <a href="<?= $plant->calscape ?>"><?= $plant->calscape ?></a>
                                    </li>
                                <?php endif; ?>                  
                                <?php if (!empty($plant->jepson_herbarium)): ?>
                                    <li class="plant-resources-item">
                                        <p>Jepson Herbarium</p><br>
                                        <a href="<?= $plant->jepson_herbarium ?>"><?= $plant->jepson_herbarium ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->las_pilitas)): ?>
                                    <li class="plant-resources-item">
                                        <p>Las Pilitas</p><br>
                                        <a href="<?= $plant->las_pilitas ?>"><?= $plant->las_pilitas ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->theodore_payne)): ?>
                                    <li class="plant-resources-item">
                                        <p>Theodore Payne</p><br>
                                        <a href="<?= $plant->theodore_payne ?>"><?= $plant->theodore_payne ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->wiki)): ?>
                                    <li class="plant-resources-item">
                                        <p>Wikipedia</p><br>
                                        <a href="<?= $plant->wiki ?>"><?= $plant->wiki ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->san_marcos)): ?>
                                    <li class="plant-resources-item">
                                        <p>San Marcos Growers</p><br>
                                        <a href="<?= $plant->san_marcos ?>"><?= $plant->san_marcos ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->annies_annuals)): ?>
                                    <li class="plant-resources-item">
                                        <p>Annie's Annuals</p><br>
                                        <a href="<?= $plant->annies_annuals ?>"><?= $plant->annies_annuals ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($plant->inland_planner)): ?>
                                    <li class="plant-resources-item">
                                        <p>Inland Valley Garden Planner</p><br>
                                        <a href="<?= $plant->inland_planner ?>"><?= $plant->inland_planner ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </body>

<?php $this->end(); ?>