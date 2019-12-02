<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: INSERT Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/insert.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <body>

        <!-- Insert Form INNER & OUTER Containers-->
        <div class="insert-div-outer">
                <div class="insert-div-inner">
                    
                    <!-- TOP-RIGHT Close Button -->
                    <a class="insert-close-link" href="/plants/index">
                        <p>X</p>
                    </a>
                    
                    <!-- LEFT Container -->
                    <div class="insert-cntnr-left">

                        <!-- LEFT-TOP: Headline Container -->
                        <div class="cntnr-left-top">
                            <div class="headline-wrapper">
                                <h2>Add a new plant</h2>
                            </div>
                        </div>

                        <!-- LEFT-MIDDLE: Error/Validation Container -->
                        <div class="cntnr-left-middle">
                            <?= $this->getErrors() ?>
                        </div>

                        <!-- LEFT-BOTTOM: Cancel Button Container -->
                        <div class="cntnr-left-bottom">
                            <div class="cancel-btn-wrapper">
                                <a href="/plants/index"><button class="cancel-button">Cancel</button></a>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT Container -->
                    <div class="insert-cntnr-right">
                        <div class="cntnr-right-top-left">
                            <div class="top-left-list-wrapper">
                                <form class="insert-form" action="/plants/insert" method="POST">
                                <ul class="top-left-list">
                                    <li><label class="insert-form-label" for="order_">Order</label><input class="insert-form-input" name="order_" type="text" value="<?=$this->_post['order_']?>" required></li>
                                    <li><label class="insert-form-label" for="family">Family</label><input class="insert-form-input" name="family" type="text" value="<?=$this->_post['family']?>" required></li>
                                    <li><label class="insert-form-label" for="genus">Genus</label><input class="insert-form-input" name="genus" type="text" value="<?=$this->_post['genus']?>" required></li>
                                    <li><label class="insert-form-label" for="species">Species</label><input class="insert-form-input" name="species" type="text" value="<?=$this->_post['species']?>" required></li>
                                    <li><label class="insert-form-label" for="subspecies">Subspecies</label><input class="insert-form-input" name="subspecies" type="text" value="<?=$this->_post['subspecies']?>"></li>
                                    <li><label class="insert-form-label" for="variety">Variety</label><input class="insert-form-input" name="variety" type="text" value="<?=$this->_post['variety']?>"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="cntnr-right-top-right">
                            <div class="top-right-list-wrapper">
                                <ul class="top-right-list">
                                    <li><label class="insert-form-label" for="cultivar">Cultivar</label><input class="insert-form-input" name="cultivar" type="text" value="<?=$this->_post['cultivar']?>"></li>
                                    <li><label class="insert-form-label" for="common_name">Common Name</label><input class="insert-form-input" name="common_name" type="text" value="<?=$this->_post['common_name']?>" required></li>
                                    <li><label class="insert-form-label" for="mature_size">Mature Size</label><input class="insert-form-input" name="mature size" type="text" value="<?=$this->_post['mature_size']?>"></li>
                                    <li><label class="insert-form-label" for="requirements">Requirements</label><textarea class="insert-form-textarea" rows="5" cols="50" name="requirements"><?=$this->_post['requirements']?></textarea></li>
                                    <li><label class="insert-form-label" for="range_ecology">Native Range & Ecology</label><textarea class="insert-form-textarea" rows="5" cols="50" name="range_ecology"><?=$this->_post['range_ecology']?></textarea></li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-bottom-left-div">
                            <div class="bottom-left-list-wrapper">
                                <ul class="bottom-left-list">
                                    <li><label class="insert-form-label" for="calflora">Calflora</label><input class="insert-form-input" name="calflora" type="url" placeholder="URL" value="<?=$this->_post['calflora']?>"></li>
                                    <li><label class="insert-form-label" for="calscape">Calscape</label><input class="insert-form-input" name="calscape" type="url" placeholder="URL" value="<?=$this->_post['calscape']?>"></li>
                                    <li><label class="insert-form-label" for="jepson_herbarium">Jepson Herbarium</label><input class="insert-form-input" name="jepson_herbarium" type="url" placeholder="URL" value="<?=$this->_post['jepson_herbarium']?>"></li>
                                    <li><label class="insert-form-label" for="las_pilitas">Las Pilitas</label><input class="insert-form-input" name="las_pilitas" type="url" placeholder="URL" value="<?=$this->_post['las_pilitas']?>"></li>
                                    <li><label class="insert-form-label" for="inland_planner">Inland Valley Garden Planner</label><input class="insert-form-input" name="inland_planner" type="url" placeholder="URL" value="<?=$this->_post['inland_planner']?>"></li>
                                    <li><label class="insert-form-label" for="wiki">Wikipedia</label><input class="insert-form-input" name="wiki" type="url" placeholder="URL" value="<?=$this->_post['wiki']?>"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-bottom-right-div">
                            <div class="bottom-right-list-wrapper">
                                <ul class="bottom-right-list">
                                    <li><label class="insert-form-label" for="theodore_payne">Theodore Payne</label><input class="insert-form-input" name="theodore_payne" type="url" placeholder="URL" value="<?=$this->_post['theodore_payne']?>"></li>
                                    <li><label class="insert-form-label" for="san_marcos">San Marcos</label><input class="insert-form-input" name="san_marcos" type="url" placeholder="URL" value="<?=$this->_post['san_marcos']?>"></li>
                                    <li><label class="insert-form-label" for="annies_annuals">Annie's Annuals</label><input class="insert-form-input" name="annies_annuals" type="url" placeholder="URL" value="<?=$this->_post['annies_annuals']?>"></li>
                                    <li><label class="insert-form-label" for="california_flora">California Flora Nursery</label><input class="insert-form-input" name="california_flora" type="url" placeholder="URL" value="<?=$this->_post['california_flora']?>"></li>
                                    <li><label class="insert-form-label" for="oc_natural_history">Orange County Natural History</label><input class="insert-form-input" name="oc_natural_history" type="url" placeholder="URL" value="<?=$this->_post['oc_natural_history']?>"></li>
                                </ul>
                                <input class="insert-form-submit" type="submit" name="insert-submit" value="Add New Plant">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </body>

<?php $this->end(); ?>