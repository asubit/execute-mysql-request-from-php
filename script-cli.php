<?php
/*
 * This following script update database
 * from shell prompt command
 */

// Translations
$lang = [
    'en' => [
        'title' => 'DATABASE UPDATE',
        'db_connect' => 'Connecting to the MySQL server ...',
        'db_select' => 'Selection of the database ...',
        'db_query_exec' => 'Execution of the query',
        'db_query_error' => 'Error in the query',
        'db_query_success' => 'Request successfully executed',
    ],
    'fr' => [
        'title' => 'MISE A JOUR DE LA BDD',
        'db_connect' => 'Connexion au serveur MySQL...',
        'db_select' => 'Selection de la base de donnees...',
        'db_query_exec' => 'Execution de la requete',
        'db_query_error' => 'Erreur dans la requete',
        'db_query_success' => 'Requete executee avec succes',
    ],
];

// Define lang translation
$t = $lang['en'];

// Define database cnnexion parameters
$host = '127.0.0.1';
$user = 'root';
$pswd = '';
$base = 'mydatabasename';

// Define request to execute
$today = date('Y-m-d H:i:s');
$requests = [
    "UPDATE WWWCOM_ALL SET HORAIRE = '".date('Y-m-d')." 23:59:59' LIMIT 50;",
    "UPDATE WWWCOM_ALL SET HORAIREDT = '".date('d/m/y')."' LIMIT 50;",
    "UPDATE WWWCOM_ALL SET HORAIRE = '".date('Y-m-d', strtotime($today . ' +1 day'))." 23:59:59' LIMIT 40;",
    "UPDATE WWWCOM_ALL SET HORAIREDT = '".date('d/m/y', strtotime($today . ' +1 day'))."' LIMIT 40;",
    "UPDATE WWWCOM_ALL SET HORAIRE = '".date('Y-m-d', strtotime($today . ' +2 day'))." 23:59:59' LIMIT 30;",
    "UPDATE WWWCOM_ALL SET HORAIREDT = '".date('d/m/y', strtotime($today . ' +2 day'))."' LIMIT 30;",
    "UPDATE WWWCOM_ALL SET HORAIRE = '".date('Y-m-d', strtotime($today . ' +3 day'))." 23:59:59' LIMIT 20;",
    "UPDATE WWWCOM_ALL SET HORAIREDT = '".date('d/m/y', strtotime($today . ' +3 day'))."' LIMIT 20;",
    "UPDATE WWWCOM_ALL SET HORAIRE = '".date('Y-m-d', strtotime($today . ' +4 day'))." 23:59:59' LIMIT 10;",
    "UPDATE WWWCOM_ALL SET HORAIREDT = '".date('d/m/y', strtotime($today . ' +4 day'))."' LIMIT 10;",
];

// Display title
echo "\033[33m┌";
for($i=-1 ; $i<=strlen($t['title']) ; $i++){echo "─";}
echo "┐\n│ " . $t['title'] . " │\n└";
for($i=-1 ; $i<=strlen($t['title']) ; $i++){echo "─";}
echo "┘\033[0m\n";

// Connect to database server
echo "\n\033[36m" . $t['db_connect'] . "\033[0m\n";
echo 'mysql_connect('.$host.', '.$user.', '.$pswd.")...\n";
echo "\033[31m";
$con = mysql_connect($host, $user, $pswd) or die(mysql_error());
echo "\033[0m";
echo "\033[32mOK\033[0m"."\n";

// Use database
echo "\n\033[36m" . $t['db_select'] . "\033[0m"."\n";
echo "mysql_select_db(".$base.")...\n";
echo "\033[31m";
$db = mysql_select_db($base, $con) or die(mysql_error());
echo "\033[0m";
echo "\033[32mOK\033[0m"."\n";

// Exec requests
foreach ($requests as $k => $q) {
    echo "\n\033[36m".$t['db_query_exec']." ".$k."\033[0m\n";
    echo $q . "\n";
    $rq = mysql_query($q, $con);
    if (!$rq) {
        echo "\033[31m".$t['db_query_error']."\033[0m"."\n";
        echo "\033[31m".mysql_errno($con) . ": " . mysql_error($con) . "\033[0m" . "\n";
    } else {
        echo "\033[32m".$t['db_query_success']."\033[0m"."\n";
    }
    echo "\n";
}
