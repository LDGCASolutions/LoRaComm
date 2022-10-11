<?php
// Purpose: Recieves a challenge responce from a Node, verify the challenge responce
//          against the data recorded on the database, record the authenticated
//          status on DB and return it
// Require: API key, Node ID, CHAL_RESP

include "../inc/postgresql.inc.php";
include "../inc/apiKey.inc.php";

if (!apiKeyPass($_GET["apiKey"])) {
  return;
}

if (!preg_match("/[A-Z0-9]{4,10}/", $_GET["nodeID"])) {
  echo "-1";
  return;
}

// Delete the node from the list of authenticate nodes (AuthLog table)
$query = "DELETE FROM \"AuthLog\" WHERE \"NodeID\"='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);

if(strlen($_GET["resp"])<32) {
  echo "-1";
  return;
}

$query = "SELECT n.ID, n.password, cl.challenge
          FROM \"Node\" n
          LEFT JOIN \"ChallengeLog\" cl ON n.ID = cl.recipient
          WHERE ID='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);
if (pg_num_rows($query)==0){
  echo "0"; // No matching Node
  return;

} else {
  $data = pg_fetch_row($query);
  $hash = hash('sha256', $data[1].$data[2]);

  if (strtoupper($hash) === strtoupper($_GET["resp"])) {
    // Record the successfull authentication
    $query = "INSERT INTO \"AuthLog\" (\"NodeID\", \"timestamp\") VALUES ('".$_GET["nodeID"]."','".time()."')";
    $query = pg_query($db_connection, $query);
    if (!$query){
      echo "0";
      return;
    } else {
      echo "1";
      return;
    }

  } else {
    echo "0";
    return;
  }

}

?>
