<div class="m-5">
    <h2 class="mb-2 text-center">Espace d'administration</h2>
    <?php
    $session = session();

    // echo $session->get('organisateur');
    // if (isset($le_message)) {
    //     echo $le_message;
    // }

    if (isset($profil)) {
    ?>
        <h3 class="text-center">Informations du profil</h3>
        <img class="img-profile rounded-circle mx-auto d-block" src="<?php echo base_url() . '/images/' . $profil->pro_image; ?>" alt="Image" style="max-width: 30%;" />
        <div class="col-md-8 mx-auto">
            <div class="mb-3">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nom</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $profil->pro_nom ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Prénom</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $profil->pro_prenom ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Adresse email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $profil->cpt_email ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Numéro de téléphone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $profil->pro_numTel ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Statut du compte</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php
                            if ($profil->pro_statut === "A") {
                                echo "Administrateur";
                            } elseif ($profil->pro_statut === "G") {
                                echo "Organisateur";
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Validité du compte</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php
                            if ($profil->pro_validite === "A") {
                                echo "Activé";
                            } elseif ($profil->pro_statut === "D") {
                                echo "Désactivé";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div>
            <p>Aucune information de profil disponible.</p>
        </div>
    <?php
    }
    ?>
</div>
<br /><br /><br /><br /><br /><br />