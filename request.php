<?php

require_once('connec.php');


// Tester les requêtes commentées ci-dessous avec la commande 'request.php'


$bdd = new PDO(DSN, USER, PASS);

$req = $bdd->query("SELECT num_abonne, SUM(volume_facture) AS conso_abonne FROM tickets_appels_201202 WHERE heure NOT BETWEEN '8:00:00' AND '18:00:00' AND type_com LIKE '%connexion%' GROUP BY num_abonne ORDER BY conso_abonne DESC LIMIT 10;");
var_dump($req->fetchAll(PDO::FETCH_ASSOC));


//2.1 : Retrouver la durée totale réelle des appels effectués après le 15/02/2012 (inclus):

//"SELECT concat(floor(SUM(TIME_TO_SEC( volume_reel ))/3600),\":\",floor(SUM( TIME_TO_SEC( volume_reel ))/60)%60,\":\",SUM( TIME_TO_SEC( volume_reel ))%60) as duree_appel_totale FROM tickets_appels_201202 WHERE type_com LIKE '%appel%'AND date_appel>='15/02/2012';"


//2.2 : Retrouver le TOP 10 des volumes data facturés en dehors de la tranche horaire 8h0018h00, par abonné.

//"SELECT num_abonne, SUM(volume_facture) AS conso_abonne FROM tickets_appels_201202 WHERE heure NOT BETWEEN '8:00:00' AND '18:00:00' AND type_com LIKE '%connexion%' GROUP BY num_abonne ORDER BY conso_abonne DESC LIMIT 10;"


//2.3 : Retrouver la quantité totale de SMS envoyés par l'ensemble des abonnés

//"SELECT COUNT(*) AS total_sms FROM tickets_appels_201202 WHERE type_com LIKE '%sms%';"