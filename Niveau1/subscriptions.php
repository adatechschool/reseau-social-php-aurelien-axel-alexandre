<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    // Etape 1: récupérer l'id de l'utilisateur
    $userId = intval($_GET['user_id']);

    // Etape 2: se connecter à la base de donnée

    //Récupérer la fonction
    require_once 'functions.php';
    //Call de la fonction
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    // Etape 3: récupération infos des followers
    $laQuestionEnSqlFollowers = "
            SELECT users.*
            FROM followers
            LEFT JOIN users ON users.id=followers.followed_user_id
            WHERE followers.following_user_id='$userId'
            GROUP BY users.id
            ";

    $lesInformationsFollowers = $mysqli->query($laQuestionEnSqlFollowers);
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
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes dont
                    l'utilisatrice
                    n° <?php echo $userId ?><br>
                    suit les messages
                </p>
            </section>
        </aside>

        <main class='contacts'>
            <?php
            // Etape 4: à vous de jouer
            //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous
            if ($lesInformationsFollowers->num_rows >  0) {
                while ($row = $lesInformationsFollowers->fetch_assoc()) {
                    echo '<article>';
                    echo '<img src="user.jpg" alt="blason"/>';
                    echo '<h3>' . htmlspecialchars($row['alias']) . '</h3>';
                    echo '<p>id: ' . htmlspecialchars($row['id']) . '</p>';
                    echo '</article>';
                }
            }
            ?>
        </main>
    </div>
</body>

</html>