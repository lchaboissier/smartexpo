<body class="bg-gradient-primary">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><?php echo $titre ?></h1>
                                    </div>
                                    <?php
                                        $session = session();
                                        $successMessage = $session->getFlashdata('success');
                                        $warningMessage = $session->getFlashdata('warning');
                                        $dangerMessage = $session->getFlashdata('danger');
                                        $infoMessage = $session->getFlashdata('info');
                                        $errorMessage = $session->getFlashdata('error');
                                        
                                        if ($successMessage) {
                                            echo '<div class="alert alert-success text-center">' . $successMessage . '</div>';
                                        } elseif ($warningMessage) {
                                            echo '<div class="alert alert-warning text-center">' . $warningMessage . '</div>';
                                        } elseif ($dangerMessage) {
                                            echo '<div class="alert alert-danger text-center">' . $errorMessage . '</div>';
                                        } elseif ($infoMessage) {
                                            echo '<div class="alert alert-info text-center">' . $infoMessage . '</div>';
                                        } elseif ($errorMessage) {
                                            echo '<div class="alert alert-danger text-center">' . $errorMessage . '</div>';
                                        }
                                    ?>
                                    <?php echo form_open('/compte/connecter', ['class' => 'user']); ?>
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <!-- <label for="pseudo">Pseudo : </label> -->
                                            <input name="pseudo" type="email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Adresse e-mail" value="<?= set_value('pseudo') ?>">
                                            <?= validation_show_error('pseudo') ?>
                                        </div>
                                        <div class="form-group">
                                            <!-- <label for="mdp">Mot de passe : </label> -->
                                            <input name="mdp" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mot de passe">
                                            <?= validation_show_error('mdp') ?>
                                        </div>                                        
                                        <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Connexion">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url(); ?>index.php/compte/creer">Pas de compte ? Inscrivez-vous !</a>
                                        <br />
                                        <a class="small" href="<?php echo base_url(); ?>">Revenir à l'accueil</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>