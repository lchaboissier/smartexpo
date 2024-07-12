<?= session()->getFlashdata('error') ?>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><?php echo $titre ?></h1>
                            </div>
                            <?php
                            // Création d’un formulaire qui pointe vers l’URL de base + /compte/creer
                            echo form_open_multipart('/compte/creer', ['class' => 'user']); ?>
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="cpt_email">Adresse e-mail : </label>
                                    <input name="cpt_email" type="email" class="form-control form-control-user" placeholder="Adresse e-mail">
                                    <?= validation_show_error('cpt_email') ?>
                                </div>
                                <div class="form-group">
                                    <label for="cpt_motdepasse">Mot de passe : </label>
                                    <input name="cpt_motdepasse" type="password" class="form-control form-control-user" placeholder="Mot de passe">
                                    <?= validation_show_error('cpt_motdepasse') ?>
                                </div>
                                <div class="form-group">
                                    <label for="pro_image">Image pour le profil : </label>
                                    <input type="file" name="pro_image">
                                </div>
                                <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Créer un nouveau compte">
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url(); ?>index.php/compte/connecter">Déjà inscrit ? Cliquez ici !</a>
                                <br />
                                <a class="small" href="<?php echo base_url(); ?>">Revenir à l'accueil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>