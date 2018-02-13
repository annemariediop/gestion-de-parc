<?php
  // fonction de connection dans la base données
  function bdd_connect($bdd)
  {
    try {
      $bdd_selected = new PDO('mysql:host=localhost;dbname='.$bdd, 'root','');
  }
  catch (Exception $erreur){
      die('Erreur : '. $erreur->getMessage());
  }
    return $bdd_selected;
  }
  //fonctions d'insertion des données des comptes dans la base données
  function ($nom, $prenom, $email, $login, $mdp, $table)
  {
    $req = $bdd->prepare('INSERT INTO'.$table.'(nom, prenom, email, login, password) VALUES(:nom, :prenom, :email, :login, :password)');
    $req->execute(array(
      'nom' =>$name ,
      'prenom' =>$prenom ,
      'email' =>$email ,
      'login' =>$login ,
      'password' =>$password

  );)
  }
 ?>
