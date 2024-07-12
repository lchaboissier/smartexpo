<!-- Le ? ou # casse le code de l'exposant dans l'url !!! -->

<div class="container">
    <a href="<?php echo base_url() . 'index.php/galerie/lister/' ?>" class="btn btn-primary mt-4">
        <i class="fas fa-arrow-left me-2"></i> Revenir à la galerie des oeuvres
    </a>

    <h1 class="text-center mt-4"><?php echo $exposant->exp_prenom . ' ' . $exposant->exp_nom; ?></h1>

    <div class="container">
        <?php if (isset($exposant)) { ?>
            <div class="text-center">
                <img src="<?php echo base_url() . '/images/exposants/' . $exposant->exp_image; ?>" alt="Image" style="max-width: 30%;" />
                <h2 class="text-center mt-4">Texte biographique :</h2>
                <div>
                    <p class="text-center"><?php echo $exposant->exp_texteBio ?></p>
                </div>
            </div>
            <h2 class="text-center mt-4">Site web :</h2>
            <a href="<?php echo $exposant->exp_siteWeb ?>">
                <p class="text-center"><?php echo $exposant->exp_siteWeb ?></p>
            </a>
        <?php } ?>
    </div>
</div>