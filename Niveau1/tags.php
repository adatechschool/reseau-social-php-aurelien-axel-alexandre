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
    /**
     * Cette page est similaire à wall.php ou feed.php
     * mais elle porte sur les mots-clés (tags)
     */
    /**
     * Etape 1: Le mur concerne un mot-clé en particulier
     */
    $tagId = intval($_GET['tag_id']);

    //Etape 2: se connecter à la base de donnée

    //Récupérer la fonction
    require_once 'functions.php';
    //Call de la fonction
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    //Etape 3: récupérer tous les messages avec un mot clé donné
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
    ?>

    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social" />
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=<?php echo $user['id'] ?>">Mur</a>
            <a href="feed.php?user_id=<?php echo $user['id'] ?>">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="#">Profil</a>
            <ul>
                <li><a href="settings.php?user_id=<?php echo $user['id'] ?>">Paramètres</a></li>
                <li><a href="followers.php?user_id=<?php echo $user['id'] ?>">Mes suiveurs</a></li>
                <li><a href="subscriptions.php?user_id=<?php echo $user['id'] ?>">Mes abonnements</a></li>
            </ul>

        </nav>
    </header>

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
            //Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
            while ($post = $lesInformations->fetch_assoc()) {
            ?>
                <article>
                    <h3>
                        <time><?php echo $post['created'] ?></time>
                    </h3>
                    <address><?php echo 'par ' . $post['author_name'] ?></address>
                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>
                    <footer>
                        <small><?php echo '♥' . $post['like_number'] ?></small>

                        <?php
                        $tags = explode(',', $post['taglist']);
                        foreach ($tags as $tag) {
                            echo '<a href="#">#' . trim($tag) . '</a> ';
                        }
                        ?>
                    </footer>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>