<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: DETAIL Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/update.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

    <!-- Javascript -->
    <script type= "text/javascript" src="/assets/js/delete.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <body>
    
        <!-- Update Page Container -->
        <div class="update-page-cntnr">
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

            <!-- Update Title Container -->
            <div class="update-title-cntnr">

                <!-- Title Image Div -->
                <div class="title-image-div">
                    <div class="plant-image-cntnr">
                        <?= '<img src="/assets/images/' . $plant->genus . '_' . $plant->species . '.jpg' . '" alt="' . $plant->genus . ' ' . $plant->species . '">'; ?>
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
                                <a class="plant-detail-link" href="/plants/detail/<?= $plant->plant_id?>" title="Plant Informartion"><i class="fas fa-info-circle"></i></a>
                                <i class="fas fa-trash-alt" id="delete-icon" title="Delete this Plant"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Update Body Container -->
            <div class="update-body-cntnr">

                <!-- Update LEFT-TOP Div -->
                <div class="update-left">
                    <div class="update-left-cntnr">
                        <div class="update-left-wrapper">
                            <h2>Plant Specifics</h2>
                            <form class="plant-update-form" action="/plants/update/<?= $plant->plant_id ?>" method="POST">
                            <ul class="plant-specifics-list">
                                <li class="plant-specifics-item">
                                    <p><b>Order:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="order_" value="<?= $plant->order_; ?>">
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Family:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="family" value="<?= $plant->family; ?>" required>
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Genus:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="genus" value="<?= $plant->genus; ?>" required>
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Species:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="species" value="<?= $plant->species; ?>" required>
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Subspecies:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="subspecies" value="<?= $plant->subspecies; ?>">
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Variety:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="variety" value="<?= $plant->variety; ?>">
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Cultivar:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="cultivar" value="<?= $plant->cultivar; ?>">
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Common Name:&nbsp;</b></p>
                                    <input class="plant-commonname-input" type="text" name="common_name" value="<?= $plant->common_name; ?>" required>
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Mature Size:&nbsp;</b></p>
                                    <input class="plant-specifics-input" type="text" name="mature_size" value="<?= $plant->mature_size; ?>">
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Requirements:&nbsp;</b></p>
                                    <textarea class="plant-requirements-input" rows="5" cols="50" name="requirements"><?= $plant->requirements; ?></textarea>
                                </li>
                                <li class="plant-specifics-item">
                                    <p><b>Range & Ecology:&nbsp;</b></p>
                                    <textarea class="plant-requirements-input" rows="5" cols="50" name="range_ecology"><?= $plant->range_ecology; ?></textarea>
                                </li>
                            </ul>
                            <p class="inventory-para"> Inventory: &nbsp;
                                <input class="inventory-input" type="number" name="inventory" value="<?= $plant->inventory; ?>">
                        </div>
                    </div>

                    <!-- Update LEFT-BOTTOM Div -->
                    <div class="update-left-btm">
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

                <!-- Update RIGHT-TOP Div -->
                <div class="update-right-top">
                        <div class="right-top-wrapper">
                            <h2>Online Resources</h2>
                            <ul class="plant-resources-list">
                                <li class="plant-resources-item">
                                    <p>Calflora</p><br>
                                    <input class="resource-input" type="url" name="calflora" value="<?= $plant->calflora ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Calscape</p><br>
                                    <input class="resource-input" type="url" name="calscape" value="<?= $plant->calscape ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Jepson Herbarium</p><br>
                                    <input class="resource-input" type="url" name="jepson_herbarium" value="<?= $plant->jepson_herbarium ?>">
                                </li>
                                
                                <li class="plant-resources-item">
                                    <p>Las Pilitas</p><br>
                                    <input class="resource-input" type="url" name="las_pilitas" value="<?= $plant->las_pilitas ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Theodore Payne</p><br>
                                    <input class="resource-input" type="url" name="theodore_payne" value="<?= $plant->theodore_payne ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Wikipedia</p><br>
                                    <input class="resource-input" type="url" name="wiki" value="<?= $plant->wiki ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>San Marcos Growers</p><br>
                                    <input class="resource-input" type="url" name="san_marcos" value="<?= $plant->san_marcos ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Annie's Annuals</p><br>
                                    <input class="resource-input" type="url" name="annies_annuals" value="<?= $plant->annies_annuals ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>Inland Valley Garden Planner</p><br>
                                    <input class="resource-input" type="url" name="inland_planner" value="<?= $plant->inland_planner ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>California Flora Nursery</p><br>
                                    <input class="resource-input" type="url" name="california_flora" value="<?= $plant->california_flora ?>">
                                </li>
                                <li class="plant-resources-item">
                                    <p>OC Natural History</p><br>
                                    <input class="resource-input" type="url" name="oc_natural_history" value="<?= $plant->oc_natural_history ?>">
                                </li>
                            </ul>
                            <input class="update-submit-button" type="submit" name="update-submit" value="Submit Update">
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </body>

<?php $this->end(); ?>