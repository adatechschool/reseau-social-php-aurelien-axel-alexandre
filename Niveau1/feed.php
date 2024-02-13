<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Flux</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    // récupéreration de l'id utilisateur dans l'URL
    $userId = intval($_GET['user_id']);
    ?>
    <?php

    //Recup Fonction
    require_once 'functions.php';
    //Connexion BDD
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    // Fetching user data from database
    $laQuestionEnSqlUser = "SELECT * FROM users WHERE id= '$userId' ";
    $lesInformationsUser = $mysqli->query($laQuestionEnSqlUser);
    $user = $lesInformationsUser->fetch_assoc();

    //echo "<pre>" . print_r($user, 1) . "</pre>";

    // Fetching messages data from database
    $laQuestionEnSqlMessage = "
                SELECT posts.content,
                posts.created,
                users.alias as author_name,
                count(likes.id) as like_number,
                GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM followers
                JOIN users ON users.id=followers.followed_user_id
                JOIN posts ON posts.user_id=users.id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                LEFT JOIN likes      ON likes.post_id  = posts.id
                WHERE followers.following_user_id='$userId'
                GROUP BY posts.id
                ORDER BY posts.created DESC
                ";
    $lesInformationsMessage = $mysqli->query($laQuestionEnSqlMessage);

    /*
    echo "<pre>";
    print_r($lesInformationsMessage->fetch_all(MYSQLI_ASSOC));
    echo "</pre>";
    */


    // Storing messages in an array
    $messages = [];
    while ($post = $lesInformationsMessage->fetch_assoc()) {
        $messages[] = $post;
    }

    $followersAlias = [];



    foreach ($messages as $post) {
        $followersAlias[] = $post['author_name'];
    }

    $followersAlias = array_unique($followersAlias);

    $followersList = implode(', ', $followersAlias);

    //Construction Header :
    require_once 'functions.php';
    drawHeader($user)
    ?>


    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <!-- todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous -->
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message des utilisatrices : <?php echo $followersList ?><br><br>
                    Auxquel est abonnée l'utilisatrice <?php echo $user['alias'] ?>
                    (n° <?php echo $userId ?>)
                </p>

            </section>
        </aside>

        <main>
            <?php

            // Creation des articles
            require_once 'functions.php';
            createArticle($messages, $post);

            ?>
        </main>
    </div>
</body>

</html>