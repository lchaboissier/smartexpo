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
</header>
<!-- Content section 1-->
<section id="scroll">
    <?php if ($dateVernissage == 1) : ?>
        <div class="h4 alert alert-info text-center" role="alert">
            Le vernissage de l'exposition est dans <strong><?php echo $dateVernissage ?></strong> jour !
        </div>
    <?php elseif ($dateVernissage == 0) : ?>
        <div class="h4 alert alert-warning text-center" role="alert">
            Le vernissage de l'exposition est prévu aujourd'hui !
        </div>
    <?php elseif ($dateVernissage <= -1) : ?>
        <div class="h4 alert alert-info text-center" role="alert">
            Le vernissage de l'exposition a eu lieu le <?php echo $cfg->cfg_dateVernissage ?>.
        </div>
    <?php else : ?>
        <div class="h4 alert alert-info text-center" role="alert">
            Le vernissage de l'exposition est dans <strong><?php echo $dateVernissage ?></strong> jours !
        </div>
    <?php endif; ?>
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
                    // Aucune information
                }
            }

            echo ("</tbody></table>");

            ?>
        </div>
    </div>
</section>
<br /><br /><br /><br />