<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?php echo $titre; ?> — <?php echo $nbTotalProfils ?> au total</h1>
    <p class="mb-4">Affichage des profils utilisateur avec leurs informations associées.</p>

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
    <?php if (!empty($logins) && is_array($logins)) { ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des profils</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Adresse e-mail</th>
                                <th>Numéro de téléphone</th>
                                <th>Statut</th>
                                <th>Validité</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($logins as $profil) { ?>
                                <tr>
                                    <td class="<?php echo ($profil["pro_validite"] == "A") ? 'compte-actif' : 'compte-inactif'; ?>"></td>
                                    <td><?php echo $profil["pro_prenom"]; ?></td>
                                    <td><?php echo $profil["pro_nom"]; ?></td>
                                    <td><?php echo $profil["cpt_email"]; ?></td>
                                    <td><?php echo $profil["pro_numTel"]; ?></td>
                                    <td><?php echo ($profil["pro_statut"] == 'A') ? 'Administrateur' : 'Organisateur'; ?></td>
                                    <td><?php echo ($profil["pro_validite"] == 'A') ? 'Activé' : 'Désactivé'; ?></td>
                                    <td>
                                        <div class="btn btn-primary btn-xs disabled"><i class="fa fa-eye-slash"></i></div>
                                        <form action="<?php echo current_url(); ?>" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir <?php echo ($profil["pro_validite"] == 'A') ? 'désactiver' : 'activer'; ?> ce compte ?')">
                                            <input type="hidden" name="pro_code" value="<?php echo $profil['pro_code']; ?>">
                                            <button type="submit" class="btn btn-warning btn-xs"> <i class="fas fa-pen"></i></button>
                                        </form>
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
        <p>Aucun compte pour le moment</p>
    <?php } ?>
</div>