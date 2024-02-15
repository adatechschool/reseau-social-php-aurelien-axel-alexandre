<?php require_once 'sessionAdministrator.php'; ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    // récupéreration de l'id utilisateur dans l'URL
    //$userId = intval($_GET['user_id']);

    //Récupérer la fonction
    require_once 'functions.php';
    //Connexion BDD
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    //Etape 3: récupérer le nom de l'utilisateur
    $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    $user = $lesInformations->fetch_assoc();

    // echo "<pre>" . print_r($user, 1) . "</pre>";

    /*
    * Etape 3: récupérer tous les messages de l'utilisatrice
    */
    $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    WHERE posts.user_id='$userId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC
                    ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    require_once 'functions.php';
    drawHeader($user);
    ?>



    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <!--//todo: afficher le résultat de la ligne ci dessous,
                remplacer XXX par l'alias et effacer la ligne ci-dessous -->
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                    (n° <?php echo $userId ?>)
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