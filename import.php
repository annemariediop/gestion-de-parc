<?php
    $fic = fopen("fichier1.csv", "r");
    if ($fic == NULL) {
      error(_('selection le fichier à importer'));
    }
    else {
      while(($filesop = fgetcsv($fic, 1000, ",")) !== false)
        {
          $immat  = $filesop[0];
          $dateMS = $filesop[1];
          $dateVT = $filesop[2];
          $loginC = $filesop[3];
          $loginG = $filesop[4];
          $idCond = $filesop[5];
          $idMarque = $filesop[6];
          $nomDep = $filesop[7];
        }

        fclose($fic);
      }
