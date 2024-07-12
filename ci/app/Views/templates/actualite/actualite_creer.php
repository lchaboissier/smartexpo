<h2><?= $titre ?></h2>
<?= session()->getFlashdata('error') ?>

<?= form_open('/actualite/creer') ?>
    <?= csrf_field() ?>

    <label for="act_titre">Titre de l'actualité :</label>
    <input type="text" name="act_titre" id="act_titre">
    <?= validation_show_error('act_titre') ?>
    <br/>
    <label for="act_texte">Contenu de l'actualité :</label>
    <textarea name="act_texte" id="act_texte" rows="8" cols="50"></textarea>
    <?= validation_show_error('act_texte') ?>
    <br/>
    <label>
        <input type="checkbox" name="act_statut" value="A" checked>
        Afficher l'actualité
    </label>
    <br/>
    <input type="submit" name="submit" value="Ajouter une actualité">
</form>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>