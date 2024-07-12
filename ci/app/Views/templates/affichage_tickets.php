<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo $titre; ?></h1>
    <p class="mb-4">Affichage de tous les tickets visiteurs et du commentaire associé.</p>

    <!-- Affichage du flash message -->
    <?php if (session()->has('message')) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo session('message'); ?>
        </div>
    <?php } elseif (session()->has('error')) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session('error'); ?>
        </div>
    <?php } ?>

    <!-- DataTales Example -->
    <?php if (!empty($tickets) && is_array($tickets)) { ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des tickets visiteurs</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Date de la visite</th>
                                <th>Heure de la visite</th>
                                <th>Adresse e-mail</th>
                                <th>Lieu de résidence</th>
                                <th>Commentaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($tickets as $visiteur) { ?>
                                <tr>
                                    <td><?php echo $visiteur["vst_prenom"]; ?></td>
                                    <td><?php echo $visiteur["vst_nom"]; ?></td>
                                    <td><?php echo $visiteur["vst_dateVisite"]; ?></td>
                                    <td><?php echo $visiteur["vst_heureVisite"]; ?></td>
                                    <td><?php echo $visiteur["vst_email"]; ?></td>
                                    <td><?php echo $visiteur["vst_lieuResidence"]; ?></td>
                                    <td class="text-center"><?php echo !empty($visiteur["com_texte"]) ? $visiteur["com_texte"] : "Aucun commentaire associé."; ?></td>
                                    <td>
                                        <div class="btn btn-primary btn-xs disabled"><i class="fa fa-eye-slash"></i></div>
                                        <div class="btn btn-warning btn-xs disabled"><i class="fa fa-pen"></i></div>
                                        <form action="<?php echo current_url(); ?>" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les données de ce ticket visiteur ?')">
                                            <input type="hidden" name="vst_num" value="<?php echo $visiteur['vst_num']; ?>">
                                            <button type="submit" class="btn btn-danger btn-xs"> <i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p>Aucun compte pour le moment</p>
    <?php } ?>
</div>