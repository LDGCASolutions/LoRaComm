<?php
// Purpose: Retrieves the challenge recorded on ChallengeLog table
// Require: API key, Node ID

include "../inc/postgresql.inc.php";
include "../inc/apiKey.inc.php";

if (!apiKeyPass($_GET["apiKey"])) {
  return;
}

if (!preg_match("/[A-Z0-9]{4,10}/", $_GET["nodeID"])) {
  echo "-1";
  return;
}

$query = "SELECT challenge FROM \"ChallengeLog\" WHERE recipient='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);
if (pg_num_rows($query)==0){
  echo "0";
  return;
} else {
  $row = pg_fetch_row($query);
  echo $row[0];
  return;
}

?>
