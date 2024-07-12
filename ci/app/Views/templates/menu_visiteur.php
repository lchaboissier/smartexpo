<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container px-5">
        <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $cfg->cfg_intitule ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>index.php/bootstrap0/afficher">Test</a></li> -->
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>index.php/galerie/lister">Galerie</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>index.php/livre-dor/lister">Livre d'or</a></li>
                <li>|</li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>index.php/compte/creer">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>index.php/compte/connecter">Connexion</a></li>
            </ul>
        </div>
    </div>
</nav>