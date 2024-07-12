<h1 class="text-center mt-4"><?php echo $titre; ?></h1>

<div class="container">
    <div class="mb-5"></div>
    <?php if (!empty($oeuvres)) { ?>
        <div class="row text-center">
            <?php foreach ($oeuvres as $oeuvre) { ?>
                <div class="col-md-6">
                    <div class="oeuvre">
                        <a href="<?php echo base_url() . 'index.php/galerie/afficher/' . $oeuvre['oeu_code']; ?>">
                            <h4><?php echo $oeuvre['oeu_intitule']; ?></h4>
                        </a>
                        <a href="<?php echo base_url() . 'index.php/galerie/afficher/' . $oeuvre['oeu_code']; ?>"><img src="<?php echo base_url() . '/images/oeuvres/' . $oeuvre['oeu_image']; ?>" alt="<?php echo $oeuvre['oeu_image']; ?>" style="max-width: 50%;" /></a>
                        <p>Exposants :</p>
                        <?php
                        $exposants = explode(',', $oeuvre['exposant']);
                        $exp_code = explode(',', $oeuvre['exp_code']);
                        if (!empty($exposants)) {
                            foreach ($exposants as $key => $exposant) { ?>
                                <div class="mb-2">
                                    <a href="<?php echo base_url() . 'index.php/exposant/afficher/' . $exp_code[$key]; ?>">
                                        <?php echo $exposant; ?>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <p>Aucun exposant...</p>
                        <?php } ?>
                        <br />
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-center">Aucune oeuvre pour l'instant !</p>
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <?php } ?>
</div>