<?php
// Purpose: Returns the node password
// Require: API key, Node ID

include "../inc/postgresql.inc.php";
include "../inc/apiKey.inc.php";

if (!apiKeyPass($_GET["apiKey"])) {
  return;
}

$nodeID = $_GET["nodeID"];

if (!preg_match("/[A-Z0-9]{4,10}/", $nodeID)) {
  echo "-1";
  return;

} else {
  $query = "SELECT password FROM \"Node\" WHERE ID='".$nodeID."'";
  $query = pg_query($db_connection, $query);
  if (pg_num_rows($query)==0){
    echo "0";
    return;
  }
  $data = pg_fetch_row($query);
  print_r($data[0]);
  return;
}

?>
