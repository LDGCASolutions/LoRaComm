<?php
// Purpose: Generates and returns a 10 character Challenge and also
//          saves it on the database in ChallengeLog table
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

$challenge = strtoupper(substr(md5(rand()),0,10));

$query = "SELECT * FROM \"ChallengeLog\" WHERE recipient='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);
if (pg_num_rows($query)==0){
  $query = "INSERT INTO \"ChallengeLog\" (recipient,challenge) VALUES ('".$_GET["nodeID"]."','".$challenge."')";
  $query = pg_query($db_connection, $query);
  if (!$query){
    echo "0"; // Node doesn't exist in Node table.
    return;
  } else {
    echo $challenge;
    return;
  }
} else {
  $query = "UPDATE \"ChallengeLog\" set challenge='".$challenge."' WHERE recipient='".$_GET["nodeID"]."'";;
  $query = pg_query($db_connection, $query);
  if (!$query){
    echo "0";
    return;
  } else {
    echo $challenge;
    return;
  }
}

?>
