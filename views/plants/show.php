<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: INDEX/SHOW Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/show.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

    <!-- Javascript -->
    <script type= "text/javascript" src="../assets/js/plantsIndex.js"></script>

<?php $this->end(); ?>

<?php $this->start('body') ?>

    <!-- Plants Index/Show Page Content -->
    <body>

        <!-- Floating Div for Insert Form -->
        <div class="insert-div-outer" style="visibility: hidden;">
                <div class="insert-div-inner">
                    <div class="insert-cntnr-left">
                        <h2>Add a new plant</h2>
                        <button class="insert-cancel-btn">Cancel</button>
                    </div>
                    <div class="insert-cntnr-right">
                        <span class="insert-cntnr-close"><p>X</p></span>
                        <div class="insert-form-wrapper">
                            <form class="insert-form" action="/plants/insert" method="POST">
                                <ul class="insert-list">
                                    <li><label class="insert-label" for="family">Family</label><input class="insert-form-input" name="family" type="text"></li>
                                    <li><label class="insert-label" for="genus">Genus</label><input class="insert-form-input" name="genus" type="text"></li>
                                    <li><label class="insert-label" for="species">Species</label><input class="insert-form-input" name="species" type="text"></li>
                                    <li><label class="insert-label" for="subspecies">Subspecies</label><input class="insert-form-input" name="subspecies" type="text"></li>
                                    <li><label class="insert-label" for="cultivar">Cultivar</label><input class="insert-form-input" name="cultivar" type="text"></li>
                                    <li><label class="insert-label" for="common_name">Common Name</label><input class="insert-form-input" name="common_name" type="text"></li>
                                    <li><label class="insert-label" for="calflora">Calflora URL</label><input class="insert-form-input" name="calflora" type="text"></li>
                                    <li><label class="insert-label" for="calscape">Calscape URL</label><input class="insert-form-input" name="calscape" type="text"></li>
                                    <li><label class="insert-label" for="wiki">Wikipedia URL</label><input class="insert-form-input" name="wiki" type="text"></li>
                                    <li><input class="insert-form-submit" type="submit" name="insert-submit" value="Add Plant"></li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <div class="plants-inventory-cntnr">

            <!-- Search Title Container -->
            <div class="plants-title-cntnr">
                <h1 class="plants-search-header">Search Inventory</h1>
                <p class="plants-search-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi, numquam expedita quasi tempore soluta aut animi excepturi adipisci corrupti error hic, dolor quas eaque ducimus. Quos, odio. Veniam accusantium atque consectetur! Esse corporis qui quam pariatur veritatis architecto quod consectetur excepturi harum officiis at, tempore provident eveniet. Atque vel quod ipsam cumque laudantium animi maiores alias quam saepe. Vero, sint dolorum voluptates fuga animi commodi dignissimos alias neque, libero, fugit ex harum maiores. Dolorem dolor cum dignissimos animi corporis, quisquam necessitatibus magnam? Aperiam, adipisci dolores.</p>
            </div>

            <!-- Search and Insert Menu Container -->
            <div class="plants-menu-cntnr">
                <div class="plants-search-cntnr">
                    <div class="plants-search-wrapper">
                        <form class="plants-search-form" action="/plants/search" method="POST">
                            <input class="plants-search-input" type="text" name="plants-search" placeholder="Search..." value="<?=$this->_post?>">
                            <button class="plants-search-btn" type="submit" title="Search for a Plant"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="plants-message-cntnr">
                    <div class="plants-message-wrapper">
                        <?php 
                        
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "deletesuccess") {
                                echo '<p class="plants-message-success">Plant record successfully deleted!</p>';
                            } else if ($_GET['error'] == "deletefailed") {
                                echo '<p class="plants-message-error">Failed to delete plant record!</p>';
                            } else if ($_GET['error'] == "insertsuccess") {
                                echo '<p class="plants-message-success">Successfully added new plant!</p>';
                            } else if ($_GET['error'] == "recordexists") {
                                echo '<p class="plants-message-error">Not added. Record already exists!</p>';
                            }
                        }
                        
                        ?>
                    </div>
                </div>
                <div class="plants-insert-cntnr">
                    <div class="plants-insert-wrapper">
                        <button class="plants-insert-btn" title="Insert a New Plant">Add New</button>
                    </div>
                </div>
            </div>

            <!-- Search Results/Data Container -->
            <div class="plants-table-cntnr">
                <table class="plants-table">
                    <tr class="plants-table-header">
                        <th>Order</th>
                        <th>Family</th>
                        <th>Genus</th>
                        <th>Species</th>
                        <th>Subspecies</th>
                        <th>Variety</th>
                        <th>Cultivar</th>
                        <th>Common Name(s)</th>
                        <th>Calflora</th>
                        <th>Calscape</th>
                        <th>Wiki</th>
                        <th>Inventory</th>
                        <th>Details</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php $plantsResults = $this->getData();
                    if (!is_array($plantsResults)) {
                        $plants = [
                            $plantsResults
                        ];
                    } else {
                        $plants = $plantsResults;
                    }
                    //dnd($plants);
                    foreach ($plants as $plant) {
                        echo '<tr class="plants-table-row">';
                        echo '<td>' . $plant->order_ . '</td>' . '<td>' . $plant->family . '</td>' . '<td>' . $plant->genus . '</td>' . '<td>' . $plant->species . '</td>' . '<td>' . $plant->subspecies . '</td>' . '<td>' . $plant->variety . '</td>' .  '<td>' . $plant->cultivar . '</td>' . '<td>' . $plant->common_name . '</td>';
                        if ($plant->calflora != '') {
                            echo '<td>' . '<a href="' . $plant->calflora . '" class="plants-link">Calflora</a>' . '</td>';
                        } else {
                            echo '<td></td>';
                        }
                        if ($plant->calscape != '') {
                            echo '<td>' . '<a href="' . $plant->calscape . '" class="plants-link">Calscape</a>' . '</td>';
                        } else {
                            echo '<td></td>';
                        } 
                        if ($plant->wiki != '') {
                            echo '<td>' . '<a href="' . $plant->wiki . '" class="plants-link">Wiki</a>' . '</td>';
                        } else {
                            echo '<td></td>';
                        }
                        echo '<td class="text-cell">' . $plant->inventory . '</td>' . '<td class="text-cell">' . '<a class="plants-button" href="/plants/detail/' . $plant->plant_id . '"><i class="fas fa-info"></i></a>' . '</td>' . '<td class="text-cell">' . '<a class="plants-button" href="/plants/update/' . $plant->plant_id . '"><i class="fas fa-pencil-alt"></i></a>' . '</td>' . '<td class="text-cell">' . '<a class="delete-link" href="/plants/indexDelete/' . $plant->plant_id . '"><i class="far fa-trash-alt" id="delete-icon"></i></span>' . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>

<?php $this->end(); ?>
