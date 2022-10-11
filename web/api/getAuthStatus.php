<?php
// Purpose: Recieves the authenticated status for a nodeID
// Require: API key, Node ID

include "../inc/postgresql.inc.php";
include "../inc/apiKey.inc.php";

define('REAUTH_PERIOD', 5); // Node is forced to re-authenticate after this duration in munites

if (!apiKeyPass($_GET["apiKey"])) {
  return;
}

if (!preg_match("/[A-Z0-9]{4,10}/", $_GET["nodeID"])) {
  echo "-1";
  return;
}

$query = "SELECT * FROM \"AuthLog\" WHERE \"NodeID\"='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);
if (pg_num_rows($query)==0){
  echo "0";
  return;
} else {
  $row = pg_fetch_row($query);
  if (defined("REAUTH_PERIOD")) {
    $age = time()-$row[2];
    if ($age > REAUTH_PERIOD*60) {
      // Last auth is too old
      echo "0";
      return;
    } else {
      echo "1";
      return;
    }
  } else {
    echo "1";
    return;
  }
}


?>
