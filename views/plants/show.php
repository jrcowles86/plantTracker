<?php $this->getLayout(); ?>

<?php $this->start('head'); ?>

    <!-- Plants: INDEX/SHOW Page Styles -->
    <link rel="stylesheet" type="text/css" href="/assets/css/plants/show.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/global/error.css"/>

<?php $this->end(); ?>

<?php $this->start('body') ?>

    <!-- Plants Index/Show Page Content -->
    <body>

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
                            <button class="plants-search-btn" type="submit" title="Search for a Plant" name="search-submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Error/Validation Message Container -->
                <div class="plants-message-cntnr">
                    <div class="plants-message-wrapper">

                        <!-- Validation: Is $_GET key 'error' set? -->
                        <?php if (isset($_GET['error'])): ?>

                            <!-- Search: Failed! -->
                            <?php if ($_GET['error'] == "noresults"): ?>
                                <p class="plants-message-error">Search returned no results!</p>
                            <?php endif; ?>

                            <!-- Search: No Terms Provided! -->
                            <?php if ($_GET['error'] == "noterms"): ?>
                                <p class="plants-message-error">No search terms provided!</p>
                            <?php endif; ?>

                            <!--  -->
                            <?php if ($_GET['error'] == "detailfailed"): ?>
                                <p class="plants-message-error">Detail failed to load! Try another record.</p>
                            <?php endif; ?>

                            <!-- Delete: Success! -->
                            <?php if ($_GET['error'] == "deletesuccess"): ?>
                                <p class="plants-message-success">Plant record successfully deleted!</p>
                            <?php endif; ?>

                            <!-- Delete: Failed! -->
                            <?php if ($_GET['error'] == "deletefailed"): ?>
                                <p class="plants-message-error">Failed to delete plant record!</p>
                            <?php endif; ?>

                            <!-- Insert: Success! -->
                            <?php if ($_GET['error'] == "insertsuccess"): ?>
                                <p class="plants-message-success">Successfully added new plant!</p>
                            <?php endif; ?>

                            <!-- Insert: Failed! -->
                            <?php if ($_GET['error'] == "recordexists"): ?>
                                <p class="plants-message-error">Not added. Record already exists!</p>
                            <?php endif; ?>

                            <!-- Update: Failed! -->
                            <?php if ($_GET['error'] == "updatefailed"): ?>
                                <p class="plants-message-error">Failed to update plant record!</p>
                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                </div>

                <!-- Insert/Add New Plant Button -->
                <div class="plants-insert-cntnr">
                    <div class="plants-insert-wrapper">
                        <a class="plants-insert-link" href="/plants/insertForm"><button class="plants-insert-btn" title="Insert a New Plant">Add New</button></a>
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
                        <th>Inventory</th>
                        <th>Details</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    <!-- Generate table contents from foreach() loop. -->
                    <?php $plants = $this->getData(); ?>

                    <?php foreach ($plants as $plant): ?>

                        <tr class="plants-table-row">
                            <td><?=$plant->order_?></td><td><?=$plant->family?></td><td><?=$plant->genus?></td><td><?=$plant->species?></td><td><?=$plant->subspecies?></td><td><?=$plant->variety?></td><td><?=$plant->cultivar?></td><td><?=$plant->common_name?></td>
                            
                            <?php if ($plant->calflora): ?>
                                <td><a href="<?=$plant->calflora?>" class="plants-link">Calflora</a></td>
                            <?php elseif (!$plant->calflora): ?>
                                <td></td>
                            <?php endif; ?>

                            <?php if ($plant->calscape): ?>
                                <td><a href="<?=$plant->calscape?>" class="plants-link">Calscape</a></td>
                            <?php elseif (!$plant->calscape): ?>
                                <td></td>
                            <?php endif; ?>
                            
                            <td class="text-cell"><?=$plant->inventory?></td><td class="text-cell"><a class="plants-button" href="/plants/detail/<?=$plant->plant_id?>"><i class="fas fa-info"></i></a></td><td class="text-cell"><a class="plants-button" href="/plants/update/<?=$plant->plant_id?>"><i class="fas fa-pencil-alt"></i></a></td><td class="text-cell"><a class="delete-link" href="/plants/delete/<?=$plant->plant_id?>"><i class="far fa-trash-alt" id="delete-icon"></i></span></td>
                        </tr>

                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </body>

<?php $this->end(); ?>
