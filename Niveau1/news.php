<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    //Récupérer la fonction
    require_once 'functions.php';
    //Connexion BDD
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');


    $laQuestionEnSql = "
                SELECT posts.content,
                posts.created,
                users.alias as author_name,
                count(likes.id) as like_number,
                GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM posts
                JOIN users ON  users.id=posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                LEFT JOIN likes      ON likes.post_id  = posts.id
                GROUP BY posts.id
                ORDER BY posts.created DESC
                LIMIT 5
                ";

    $lesInformations = $mysqli->query($laQuestionEnSql);
    // Vérification
    if (!$lesInformations) {
        echo "<article>";
        echo ("Échec de la requete : " . $mysqli->error);
        echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
        exit();
    }

    //Construction du Header
    require_once 'functions.php';
    drawHeader($user);
    ?>


    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages de
                    tous les utilisatrices du site.</p>
            </section>
        </aside>
        <main>

            <?php

            // Creation des articles
            require_once 'functions.php';
            createArticle2($post, $lesInformations);


            ?>
        </main>
    </div>
</body>

</html>