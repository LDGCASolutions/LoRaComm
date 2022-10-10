<?php
// Purpose: Returns the node password
// Require: API key, Node ID

include "../inc/postgresql.inc.php";

$apiKey = "abcdefgHijkLMNOP";
$nodeID = $_GET["nodeID"];

if ($_GET["apiKey"] != $apiKey) {
  echo "-1";
  return;
}

if (!preg_match("/[A-Z0-9]{4,10}/", $nodeID)) {
  echo "0";
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
