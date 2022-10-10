<?php
// Purpose: Generates and returns a 10 character Challenge and also
//          saves it on the database in ChallengeLog table
// Require: API key, Node ID

include "../inc/postgresql.inc.php";

$apiKey = "abcdefgHijkLMNOP";

if ($_GET["apiKey"] != $apiKey) {
  echo "-1";
  return;
}

if (!preg_match("/[A-Z0-9]{4,10}/", $_GET["nodeID"])) {
  echo "0";
  return;
}

$challenge = strtoupper(substr(md5(rand()),0,10));

$query = "SELECT * FROM \"ChallengeLog\" WHERE recipient='".$_GET["nodeID"]."'";
$query = pg_query($db_connection, $query);
if (pg_num_rows($query)==0){
  $query = "INSERT INTO \"ChallengeLog\" (recipient,challenge) VALUES ('".$_GET["nodeID"]."','".$challenge."')";
  $query = pg_query($db_connection, $query);
  if (!$query){
    echo "INSERT: 0";
    return;
  } else {
    echo $challenge;
    return;
  }
} else {
  $query = "UPDATE \"ChallengeLog\" set challenge='".$challenge."' WHERE recipient='".$_GET["nodeID"]."'";;
  $query = pg_query($db_connection, $query);
  if (!$query){
    echo "UPDATE: 0";
    return;
  } else {
    echo $challenge;
    return;
  }
}

?>
