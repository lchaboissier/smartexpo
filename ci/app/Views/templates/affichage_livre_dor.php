<h1 class="text-center mt-4"><?php echo $titre; ?></h1>

<div class="container">
    <h2 class="mb-5">Liste des commentaires</h2>
    <?php if (!empty($commentaires)) { ?>
        <div class="row">
            <?php foreach ($commentaires as $commentaire) { ?>
                <?php $dateFr = date("d/m/Y", strtotime($commentaire['com_datePublication'])); ?>
                <?php if ($commentaire['com_statut'] == 'A') { ?>
                    <div class="row align-items-center my-5">
                        <div class="col-md-2">
                            <img src="https://studycrafter.com/wp-content/uploads/2017/12/IAFOR-Blank-Avatar-Image-1-768x768.jpg" alt="Image de profil" class="img-fluid rounded-circle" style="max-width: 100px;">
                        </div>
                        <div class="col-md-10">
                            <div class="commentaire">
                                <p><?php echo $commentaire['com_texte']; ?></p>
                                <p>— <?php echo $commentaire['vst_prenom'] . " " . $commentaire['vst_nom'] . " (" . $commentaire['vst_email'] . ")" . ", le " . $dateFr . " à " . $commentaire['com_heurePublication']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-center">Aucun commentaire pour le moment.</p>
    <?php } ?>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>