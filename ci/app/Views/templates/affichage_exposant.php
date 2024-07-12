<!-- Le ? ou # casse le code de l'exposant dans l'url !!! -->

<div class="container">
    <a href="<?php echo base_url() . 'index.php/galerie/lister/' ?>">
        <p class="mt-4">
            < Revenir à la galerie des oeuvres</p>
    </a>
    <h1 class="text-center mt-4"><?php echo $exposant->exp_prenom . ' ' . $exposant->exp_nom; ?></h1>

    <div class="container">
        <?php if (isset($exposant)) { ?>
            <div class="text-center">
                <img src="<?php echo base_url() . '/images/exposants/' . $exposant->exp_image; ?>" alt="Image" style="max-width: 30%;" />
                <p class="text-center mt-4"><strong>Texte biographique :</strong></p>
                <div>
                    <p class="text-center"><?php echo $exposant->exp_texteBio ?></p>
                </div>
            </div>
            <p class="mt-4"><strong>Site web :</strong></p>
            <a href="<?php echo $exposant->exp_siteWeb ?>">
                <p><?php echo $exposant->exp_siteWeb ?></p>
            </a>
        <?php } ?>
    </div>
</div>