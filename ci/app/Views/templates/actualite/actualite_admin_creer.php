<h2 class="text-center"><?= $titre ?></h2>
<?= session()->getFlashdata('error') ?>
<div class="text-center">
    <?= form_open('/admin/actualite/creer') ?>
    <?= csrf_field() ?>

    <label for="act_titre">Titre de l'actualité :</label>
    <br />
    <input type="text" name="act_titre" id="act_titre">
    <br />
    <?= validation_show_error('act_titre') ?>
    <br />
    <label for="act_texte">Contenu de l'actualité :</label>
    <br />
    <textarea name="act_texte" id="act_texte" rows="8" cols="50"></textarea>
    <?= validation_show_error('act_texte') ?>
    <br />
    <label>
        <input type="checkbox" name="act_statut" value="A" checked>
        Afficher l'actualité
    </label>
    <br />
    <input type="submit" name="submit" value="Ajouter une actualité">
    </form>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />