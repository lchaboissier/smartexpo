<!-- Header-->
<?php
$dateDebut = date("d/m/Y", strtotime($cfg->cfg_dateDebut));
$dateFin = date("d/m/Y", strtotime($cfg->cfg_dateFin));
?>
<header class="masthead text-center text-white">
    <div class="masthead-content">
        <div class="container px-5">
            <h1 class="masthead-heading mb-0"><?php echo $cfg->cfg_intitule ?></h1>
            <h2 class="masthead-subheading mb-0">L'exposition des smartphones</h2>
            <h2 class="mt-2">Ouverture prévue entre le <?php echo $dateDebut . " et le " . $dateFin ?> de 9h00 à 17h00</h2>
            <a class="btn btn-primary btn-xl rounded-pill mt-5" href="#scroll">Plus de détails</a>
        </div>
    </div>
    <!-- <div class="bg-circle-1 bg-circle"></div>
    <div class="bg-circle-2 bg-circle"></div>
    <div class="bg-circle-3 bg-circle"></div>
    <div class="bg-circle-4 bg-circle"></div> -->
</header>
<!-- Content section 1-->
<section id="scroll">
    <div class="h4 alert alert-info text-center" role="alert">
        Le date du vernissage de l'exposition est dans <strong><?php echo $dateVernissage ?></strong> jours !
    </div>
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <!-- Section - Présentation de l'exposition  -->
            <?php if (!empty($news) && is_array($news)) { ?>
                <div class="container mt-5">
                    <h1 class="mb-4">Présentation</h1>
                    <div>
                        <h2><?php echo $cfg->cfg_intitule ?></h2>
                        <p class="mb-5"><?php echo $cfg->cfg_presentation ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="container m-5">
                    <h1 class="mb-5">Présentation</h1>
                    <h1 class="my-5 text-center">Aucune présentation pour le moment.</h1>
                </div>
            <?php } ?>


            <!-- Section : Liste des actualités -->
            <div class="container">
                <h1 class="mb-3">Actualités</h1>
            </div>

            <?php
            echo ("<table class='table table-hover'>");
            echo ("<thead>
                    <tr>
                    <th>Titre</th>
                    <th>Texte</th>
                    <th>Date</th>
                    <th>Pseudo</th>
                  </tr>
                </thead>
                <tbody>");
            foreach ($news as $actualite) {
                $dateFr = date("d/m/Y", strtotime($actualite['act_date']));
                if ($actualite['act_statut'] == 'A') {
                    echo ("<tr>");
                    echo ("<td>" . "<a href='" . base_url() . "index.php/actualite/afficher/" . $actualite['act_num'] . "'>" . $actualite['act_titre'] . "</a>" . "</td>");
                    echo ("<td>" . $actualite['act_texte'] . "</td>");
                    echo ("<td>" . $dateFr . "</td>");
                    echo ("<td>" . $actualite['cpt_email'] . "</td>");
                    echo ("</tr>");
                } else if ($actualite['act_statut'] == 'D') {
                    //
                }
            }

            echo ("</tbody></table>");

            ?>

            
            <!-- En développement...  -->
            <!-- <div class="col-lg-6 order-lg-1">
                <div class="p-5">
                    <h2 class="display-4">For those about to rock...</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                </div>
            </div> -->
        </div>
    </div>
</section>
<br /><br /><br /><br />
<!-- Content section 2-->
<!-- <section>
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <div class="p-5"><img class="img-fluid rounded-circle" src="<?php echo base_url(); ?>bootstrap/assets/img/02.jpg" alt="..." /></div>
            </div>
            <div class="col-lg-6">
                <div class="p-5">
                    <h2 class="display-4">We salute you!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Content section 3-->
<!-- <section>
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="p-5"><img class="img-fluid rounded-circle" src="<?php echo base_url(); ?>bootstrap/assets/img/03.jpg" alt="..." /></div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="p-5">
                    <h2 class="display-4">Let there be rock!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquid, mollitia odio veniam sit iste esse assumenda amet aperiam exercitationem, ea animi blanditiis recusandae! Ratione voluptatum molestiae adipisci, beatae obcaecati.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->