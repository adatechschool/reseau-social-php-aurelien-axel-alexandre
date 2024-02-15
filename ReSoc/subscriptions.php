<?php require_once 'sessionAdministrator.php'; ?>

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
    // récupéreration de l'id utilisateur dans l'URL
    //$userId = intval($_GET['user_id']);


    //Récupérer la fonction
    require_once 'functions.php';
    //Connexion BDD
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

        <?php
        //Construction du Header
        require_once 'functions.php';
        drawHeader($user)
        ?>

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

         <!-- Construction Contact :  -->
         <?php
        require_once 'functions.php';
        drawContact($lesInformationsFollowers)
        ?>
    </div>
</body>

</html>