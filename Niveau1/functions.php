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

?>