<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Les message par mot-clé</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    // récupéreration de l'id utilisateur dans l'URL
    $tagId = intval($_GET['tag_id']);

    //Récupérer la fonction
    require_once 'functions.php';
    //Call BDD
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    // Fetching messages data from database
    $laQuestionEnSql = "
                SELECT posts.content,
                posts.created,
                users.alias as author_name,
                count(likes.id) as like_number,
                GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM posts_tags as filter
                JOIN posts ON posts.id=filter.post_id
                JOIN users ON users.id=posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                LEFT JOIN likes      ON likes.post_id  = posts.id
                WHERE filter.tag_id = '$tagId'
                GROUP BY posts.id
                ORDER BY posts.created DESC
                ";

    $lesInformations = $mysqli->query($laQuestionEnSql);

    /*
    echo "<pre>";
    print_r($lesInformations->fetch_all(MYSQLI_ASSOC));
    echo "</pre>";
    */

    // récupération du label du tag

    $laQuestionEnSqlLabel = " SELECT label FROM tags WHERE id = $tagId";

    $lesInformationsLabel = $mysqli->query($laQuestionEnSqlLabel);

    /*
    echo "<pre>";
    print_r($lesInformationsLabel->fetch_all(MYSQLI_ASSOC));
    echo "</pre>";
    */

    $labelTag = $lesInformationsLabel->fetch_assoc()['label'];

        //construction du Header
        require_once 'functions.php';
        drawHeader($user)
    ?>



    <div id="wrapper">

        <aside>
            <!--@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous -->
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant
                    le mot-clé "<?php echo $labelTag ?>"
                    (n° <?php echo $tagId ?>)
                </p>

            </section>
        </aside>

        <main>
            <?php
                require_once 'functions.php';
                createArticle2($post, $lesInformations);
            ?>
        </main>
    </div>
</body>

</html>