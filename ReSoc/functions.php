<?php

function connectDB($host, $user, $password, $dbname) {
  $mysqli = new mysqli($host, $user, $password, $dbname);

  if ($mysqli->connect_errno) {
      echo "<article>";
      echo ("Échec de la connexion : " . $mysqli->connect_error);
      echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
      echo "</article>";
      exit();
  }

  return $mysqli;
}


function createArticle ($messages, $post) {
    foreach ($messages as $post) {
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

}


function createArticle2($post, $lesInformations){
    while ($post = $lesInformations->fetch_assoc()) {

        // echo "<pre>" . print_r($post, 1) . "</pre>";
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
}


function drawHeader($user){
    ?>
    <header>
        <!-- <img src="resoc.jpg" alt="Logo de notre réseau social" /> -->
        <nav id="menu">
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=<?php echo $user['id']; ?>">Mur</a>
            <a href="feed.php?user_id=<?php echo $user['id']; ?>">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        </nav>
        <nav id="user">
            <a href="#">Profil</a>
            <ul>
                <li><a href="settings.php?user_id=<?php echo $user['id']; ?>">Paramètres</a></li>
                <li><a href="followers.php?user_id=<?php echo $user['id']; ?>">Mes suiveurs</a></li>
                <li><a href="subscriptions.php?user_id=<?php echo $user['id']; ?>">Mes abonnements</a></li>
            </ul>

        </nav>
    </header>
    <?php
}

function drawContact($lesInformationsFollowers ){
    ?>
    <main class='contacts'>
            <?php


            if ($lesInformationsFollowers->num_rows >  0) {
                while ($row = $lesInformationsFollowers->fetch_assoc()) {
                    echo '<article>';
                    echo '<img src="user.jpg" alt="blason"/>';
                    echo '<h3>' . htmlspecialchars($row['alias']) . '</h3>';
                    echo '<p>id:' . htmlspecialchars($row['id']) . '</p>';
                    echo '</article>';
                }
            }
            ?>
        </main>
        <?php

}




?>