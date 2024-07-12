<h1 class="text-center mt-4"><?php echo $titre.' — '.$news->act_titre; ?></h1>

<div class="container mt-4 text-center">
    <?php
    echo ("<table class='table table-hover'>");
    echo ("<thead>
        <tr>
            <th>Numéro</th>
            <th>Titre</th>
            <th>Texte</th>
        </tr>
    </thead>
    <tbody>");
    if (isset($news)) {
        echo ("<tr>");
        echo ("<td>" . $news->act_num . "</td>");
        echo ("<td>" . $news->act_titre . "</td>");
        echo ("<td>" . $news->act_texte . "</td>");
        echo ("<tr>");
    }

    echo ("</tbody></table>");

    ?>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />