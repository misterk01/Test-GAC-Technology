<?php

require_once('connec.php');

// Se connecter à la bdd dans le fichier 'connec.php'
// Dans le terminal, indiquer le fichier 'extract.php' (argv[0]), puis le chemin de 'file.csv' (argv[1])


if (count($argv) > 1) {
    $filename = $argv[1];
} else {
    echo "Error: Missing filename\n";
    exit();
}



$pdo = new PDO(DSN, USER, PASS);

$pdo->exec("DROP TABLE IF EXISTS tickets_appels_201202 ");
$pdo->exec("CREATE TABLE `tickets_appels_201202` (id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, compte_facture VARCHAR(255), num_facture VARCHAR(255), num_abonne VARCHAR(255), date_appel VARCHAR(255), heure VARCHAR(255), volume_reel VARCHAR(255), volume_facture VARCHAR(255), type_com VARCHAR(255));");

$row = 0;
if (($handle = fopen($filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        if ($row < 4)
            continue;

        $query = 'INSERT INTO tickets_appels_201202 (compte_facture, num_facture, num_abonne, date_appel, heure, volume_reel, volume_facture, type_com) VALUES (:compte_facture, :num_facture, :num_abonne, :date_appel, :heure, :volume_reel, :volume_facture, :type_com)';
        $statement = $pdo->prepare($query);


        $statement->bindValue(':compte_facture', $data[0]);
        $statement->bindValue(':num_facture', $data[1]);
        $statement->bindValue(':num_abonne', $data[2]);
        $statement->bindValue(':date_appel', $data[3]);
        $statement->bindValue(':heure', $data[4]);
        $statement->bindValue(':volume_reel', $data[5]);
        $statement->bindValue(':volume_facture', $data[6]);
        $statement->bindValue(':type_com', $data[7]);

        $statement->execute();
    }
    fclose($handle);
}
