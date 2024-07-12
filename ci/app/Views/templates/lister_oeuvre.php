<section class="page-section bg-light" id="portfolio">
    <h1 class="text-center mt-4"><?php echo $titre; ?></h1>

    <div class="container">
        <div class="mb-5"></div>
        <?php if (!empty($oeuvres)) { ?>
            <div class="row text-center">
                <?php foreach ($oeuvres as $oeuvre) { ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="portfolio-item">
                            <a class="portfolio-link" href="<?php echo base_url() . 'index.php/galerie/afficher/' . $oeuvre['oeu_code']; ?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content">
                                        <div class="h2"><strong><?php echo $oeuvre['oeu_intitule'] ?></strong></div>
                                    </div>
                                </div>
                                <img class="img-fluid" src="<?php echo base_url() . 'images/oeuvres/' . $oeuvre['oeu_image']; ?>" alt="<?php echo $oeuvre['oeu_image']; ?>" />
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="portfolio-caption-heading"><?php echo $oeuvre['oeu_intitule']; ?></h4>
                                <p class="portfolio-caption-subheading text-muted">Exposant(s) :</p>
                                <?php
                                $exposants = explode(',', $oeuvre['exposant']);
                                $exp_code = explode(',', $oeuvre['exp_code']);
                                if (!empty($exposants)) {
                                    foreach ($exposants as $key => $exposant) { ?>
                                        <div class="mb-1">
                                            <a href="<?php echo base_url() . 'index.php/exposant/afficher/' . $exp_code[$key]; ?>">
                                                <?php echo $exposant; ?>
                                            </a>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <p>Aucun exposant...</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="text-center">Aucune oeuvre pour l'instant !</p>
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <?php } ?>
    </div>
</section>