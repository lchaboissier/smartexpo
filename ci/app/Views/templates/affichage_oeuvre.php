<!-- Le ? ou # casse le code de l'oeuvre dans l'url !!! -->
<div class="container">
    <a href="<?php echo base_url() . 'index.php/galerie/lister/' ?>" class="btn btn-primary mt-4">
        <i class="fas fa-arrow-left me-2"></i> Revenir à la galerie des oeuvres
    </a>

    <h1 class="text-center mt-4"><?php echo $oeuvre->oeu_intitule; ?></h1>

    <div class="container">
        <?php if (isset($oeuvre)) { ?>
            <div class="text-center">
                <?php $dateFr = date("d/m/Y", strtotime($oeuvre->oeu_dateCreation)); ?>
                <img src="<?php echo base_url() . '/images/oeuvres/' . $oeuvre->oeu_image; ?>" alt="<?php echo $oeuvre->oeu_image; ?>" style="max-width: 30%;" />
            </div>
            <h2 class="text-center mt-4">Texte biographique :</h2>
            <div>
                <p class="text-center"><?php echo $oeuvre->oeu_description ?></p>
            </div>
            <h2 class="text-center mt-4">Créé par :</h2>
            <?php $exposants = explode(',', $oeuvre->exposant); ?>
            <?php foreach ($exposants as $exposant) { ?>
                <a href="<?php echo base_url() . 'index.php/exposant/afficher/' . $oeuvre->exp_code; ?>">
                    <p class="text-center"><?php echo $exposant; ?></p>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
