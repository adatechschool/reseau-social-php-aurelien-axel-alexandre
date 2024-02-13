<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Paramètres</title>
    <meta name="author" content="TripleA">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    $userId = intval($_GET['user_id']);

    //Récupérer la fonction
    require_once 'functions.php';
    //Call de la fonction
    $mysqli = connectDB('localhost', 'root', 'root', 'socialnetwork');

    $laQuestionEnSql = "
                    SELECT users.*,
                    count(DISTINCT posts.id) as totalpost,
                    count(DISTINCT given.post_id) as totalgiven,
                    count(DISTINCT recieved.user_id) as totalrecieved
                    FROM users
                    LEFT JOIN posts ON posts.user_id=users.id
                    LEFT JOIN likes as given ON given.user_id=users.id
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id
                    WHERE users.id = '$userId'
                    GROUP BY users.id
                    ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    if (!$lesInformations) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
    $user = $lesInformations->fetch_assoc();

    //@todo: afficher le résultat de la ligne ci dessous, remplacer les valeurs ci-après puiseffacer la ligne ci-dessous
    //echo "<pre>" . print_r($user, 1) . "coucou" . "</pre>";


    // Constriction du Header :
    require_once 'functions.php';
    drawHeader($user)

    ?>

    <div id="wrapper" class='profile'>

        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les informations de l'utilisatrice
                    n° <?php echo $userId ?></p>

            </section>
        </aside>
        <main>
            <article class='parameters'>
                <h3>Mes paramètres</h3>
                <dl>
                    <dt>Pseudo</dt>
                    <dd><?php echo $user['alias'] ?></dd>
                    <dt>Email</dt>
                    <dd><?php echo $user['email'] ?></dd>
                    <dt>Nombre de message</dt>
                    <dd><?php echo $user['totalpost'] ?></dd>
                    <dt>Nombre de "J'aime" donnés </dt>
                    <dd><?php echo $user['totalgiven'] ?></dd>
                    <dt>Nombre de "J'aime" reçus</dt>
                    <dd><?php echo $user['totalrecieved'] ?></dd>
                </dl>

            </article>
        </main>
    </div>
</body>

</html>