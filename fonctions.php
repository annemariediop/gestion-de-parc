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
    $req = $bdd->prepare('INSERT INTO '.$table.' (login, nom, prenom, email, password) VALUES(:login, :nom, :prenom, :email, :password)');
    $req->execute(array(
      'login' =>$login ,
      'nom' =>$name ,
      'prenom' =>$prenom ,
      'email' =>$email ,
      'password' =>$password

  );)
  }

  //fonction d'ajout des données dans la base de données par le gestionnaire
  function ajout_vehicule($immat, $marque, $modele, $conducteur, $dateMS, $dateVT)
  {
    $req = $bdd->prepare('INSERT INTO vehicules(immat, marque, modele, conducteur) values(:immat, :marque, :modele, :conducteur)');
    $req->execute(array(
      'immat' =>$immat ,
      'marque' =>$marque ,
      'modele' =>$modele ,
      'conducteur' =>$conducteur
    ));
  }

  //fonction pour modifier les infos dans la base de données par le chef de département
  function modifier_infos($immat, $conducteur, $dateVT)
  {
    $req = $bdd->exec('UPDATE vehicules SET conducteur='.$conducteur.' dateVT='.$dateVT.' WHERE immat='.$immat);
  }

  //alerte au chef de departement si la date de visite est dans un mois
  function alerter()
  {
    $verif = $bdd->query('SELECT immat, loginC, email, marque, modele from vehicules WHERE dateVT = '.mktime(0, 0, 0, date('d'), date('m')+1, date('Y')));
    while($files = $verif->fetch()) {
      $destination = $files['email']; //destinataire du mail
      $titre = "Avertissement"; //titre
      $source = "abdoulkande2@gmail.com"; // source du mail
      //contenu du mail
      $text = 'bonjour '.$files['loginC'].' nous vous prevenons que la prochaine visite technique de la voiture '.$files['immat'].' marque '.$files['marque'].' modele '.$files['modele'].' sera dans un mois\n';
      //entête du mail
      $from  = "From:".$source."\n";
      $from .= "MIME-version: 1.0\n";
      $from .= "Content-type: text/html;
                charset= UTF-8\n";
      mail($destination, $titre, $text, $from);
    }
  }

  //fonction de d'exportation de fichier en mode pdf
  function exportation(){
    require('FPDF-master/fpdf.php');
    //require('FPDF-master/font/');
    ini_set('memory_limit','1000M');
    ini_set('max_execution_time','120');
    //connection dans la base de données
    try {
      $bdd = new PDO('mysql:host=localhost;dbname=monparc', 'root','');
    }
    catch (Exception $erreur){
      die('Erreur : '. $erreur->getMessage());
    }

    $result=$bdd->query("select immat, marque, modele, conducteur, dateMS, dateVT from vehicule");
    $total = count($result);
    //Initialisation
    $column_immat = "";
    $column_marque = "";
    $column_modele = "";
    $column_conducteur = "";
    $column_dateMS = "";
    $column_dateVT = "";
    //$immat, $marque, $modele, $conducteur, $dateMS, $dateVT
    //For each row, add the field to the corresponding column
    while($row = $result->fetch())
    {
    	$immat = $row["immat"];
    	$marque = substr($row["marque"],0,20);
    	$modele = $row["modele"];
    	$conducteur = $row["conducteur"];
    	$dateMS = $row["dateMS"];
    	$dateVT = $row["dateVT"];
    	$column_immat = $column_immat.$immat."\n";
    	$column_marque = $column_marque.$marque."\n";
    	$column_modele = $column_modele.$modele."\n";column_
    	$column_conducteur = $column_conducteur.$conducteur."\n";
    	$column_dateMS = $column_dateMS.$dateMS."\n";
    	$column_dateVT = $column_dateVT.$dateVT."\n";
    }


    //instanciation d'un objet FPDF
    $pdf=new FPDF();
    $pdf->AddPage(); //ouvrir une page

    //position de l'entête
    $Y_entete = 20;
    //position du conteneur des données
    $Y_Tableau = 26;

    //l'entête du tableau
    $pdf->SetFillColor(232,232,232); //color de l'entête
    $pdf->SetFont('Arial','B',10); //la police utilisé B pour dire Bold et 10 qui represente la taille
    $pdf->SetY($Y_entete);
    $pdf->SetX(10);
    $pdf->Cell(25,6,'Immat',1,0,'C',1);
    $pdf->SetX(35);
    $pdf->Cell(30,6,'Marque',1,0,'C',1);
    $pdf->SetX(65);
    $pdf->Cell(30,6,'Modele',1,0,'C',1);
    $pdf->SetX(95);
    $pdf->Cell(40,6,'Conduteur',1,0,'C',1);
    $pdf->SetX(135);
    $pdf->Cell(25,6,'DateMS',1,0,'C',1);
    $pdf->SetX(160);
    $pdf->Cell(25,6,'DateVT',1,0,'C',1);
    $pdf->Ln();

    //le résultat de ce qu'on va récupérer de la base de données
    $pdf->SetFont('Arial','',10);
    $pdf->SetX(10);
    $pdf->Cell(25,6,$column_Immat,1);
    $pdf->SetX(35);
    $pdf->Cell(30,6,$column_Marque,1);
    $pdf->SetX(65);
    $pdf->Cell(30,6,$column_Modele,1);
    $pdf->SetX(95);
    $pdf->Cell(40,6,$column_Conduteur,1);
    $pdf->SetX(135);
    $pdf->Cell(25,6,$column_DateMS,1);
    $pdf->SetX(160);
    $pdf->Cell(25,6,$column_DateVT,1,'R');

    $i = 0;
    $pdf->SetY($Y_Tableau);
    while ($i < $total)
    {
    	$pdf->SetX(10);
    	$pdf->MultiCell(120,6,'',1);
    	$i = $i +1;
    }
    $pdf->Output();
  }
 ?>
