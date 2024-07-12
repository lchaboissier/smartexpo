<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo $titre; ?></h1>
    <p class="mb-4">Affichage des actualités avec leurs informations associées.</p>
    <a href="<?php echo base_url() . "index.php/admin/actualite/creer" ?>" class="mb-4 btn btn-primary">Ajouter une actualité</a>

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
    <?php if (!empty($actus) && is_array($actus)) { ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des actualités</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Titre</th>
                                <th>Contenu</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($actus as $actu) { ?>
                                <?php
                                $date = date("d/m/Y", strtotime($actu['act_date']));
                                ?>
                                <tr>
                                    <td class="<?php echo ($actu["act_statut"] == "A") ? 'compte-actif' : 'compte-inactif'; ?>"></td>
                                    <td><?php echo $actu["act_titre"]; ?></td>
                                    <td><?php echo $actu["act_texte"]; ?></td>
                                    <td><?php echo ($actu["act_statut"] == 'A') ? 'Activé' : 'Désactivé'; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td>
                                        <div class="btn btn-primary btn-xs disabled"><i class="fa fa-eye-slash"></i></div>
                                        <div class="btn btn-warning btn-xs disabled"><i class="fa fa-pen"></i></div>
                                        <div class="btn btn-danger btn-xs disabled"><i class="fa fa-trash"></i></div>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <p>Aucune actualité pour le moment !</p>
    <?php } ?>
</div>