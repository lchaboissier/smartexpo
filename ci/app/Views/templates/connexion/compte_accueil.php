<div class="m-5">
    <h2 class="text-center">Espace d'administration</h2>

    <br />

    <?php
    $session = session();
    $admin = $session->get('administrateur');
    $organisateur = $session->get('organisateur');

    if ($admin) {
        echo "<h2 class=" . "text-center" . ">Session ouverte ! Bienvenue $admin !</h2>";
        echo "<p class=" . "text-center" . ">Vous êtes connecté en tant qu'administrateur.</p>";
    } elseif ($organisateur) {
        echo "<h2 class=" . "text-center" . ">Session ouverte ! Bienvenue $organisateur !</h2>";
        echo "<p class=" . "text-center" . ">Vous êtes connecté en tant qu'organisateur.</p>";
    } else {
        echo "<p class=" . "text-center" . ">Statut inconnu.</p>";
    }
    ?>

    <div class="text-center">
        <a href="<?php echo base_url() . 'index.php/admin/afficher' ?>">Accéder au tableau de bord.</a>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>