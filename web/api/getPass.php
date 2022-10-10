<?php
include "../inc/postgresql.inc.php";

$nodeID = $_GET["nodeID"];

if (!preg_match("/[A-Z0-9]{4,10}/", $nodeID)) {
  echo "0";
} else {
  $query = "SELECT password FROM \"Node\" WHERE ID='".$nodeID."'";
  $query = pg_query($db_connection, $query);
  if (pg_num_rows($query)==0){
    echo "0";
  }
  $data = pg_fetch_row($query);
  print_r($data[0]);
}


?>
