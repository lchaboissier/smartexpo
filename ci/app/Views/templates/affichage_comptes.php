<h2 class="text-center mt-4"><?php echo $titre; ?></h2>
<h3>Nombre total : <?php echo $nbTotalComptes ?></h3>
<div>
    <?php if (!empty($logins) && is_array($logins)) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logins as $compte) { ?>
                    <tr class="<?php echo ($compte["cpt_statut"] == "A") ? 'compte-actif' : 'compte-inactif'; ?>">
                        <td><?php echo $compte["cpt_email"]; ?></td>
                        <td><?php echo $compte["cpt_statut"]; ?></td>
                        <td>
                            <?php if ($compte["cpt_statut"] == "activé") { ?>
                                <i class="fa fa-toggle-on"></i>
                            <?php } else { ?>
                                <i class="fa fa-toggle-off"></i>
                            <?php } ?>
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash"></i>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Aucun compte pour le moment</p>
    <?php } ?>
</div>
