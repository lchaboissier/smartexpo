<!-- Le ? ou # casse le code de l'oeuvre dans l'url !!! -->
<div class="container">
    <a href="<?php echo base_url() . 'index.php/galerie/lister/' ?>">
        <p class="mt-4">
            < Revenir à la galerie des oeuvres</p>
    </a>
    <h1 class="text-center mt-4"><?php echo $oeuvre->oeu_intitule; ?></h1>

    <div class="container">
        <?php if (isset($oeuvre)) { ?>
            <div class="text-center">
                <?php $dateFr = date("d/m/Y", strtotime($oeuvre->oeu_dateCreation)); ?>
                <img src="<?php echo base_url() . '/images/oeuvres/' . $oeuvre->oeu_image; ?>" alt="<?php echo $oeuvre->oeu_image; ?>" style="max-width: 30%;" />
            </div>
            <p><strong>Texte biographique :</strong></p>
            <div>
                <p class="text-center"><?php echo $oeuvre->oeu_description ?></p>
            </div>
            <p><strong>Créé par :</strong></p>
            <?php $exposants = explode(',', $oeuvre->exposant); ?>
            <?php foreach ($exposants as $exposant) { ?>
                <a href="<?php echo base_url() . 'index.php/exposant/afficher/' . $oeuvre->exp_code; ?>">
                    <p><?php echo $exposant; ?></p>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br />