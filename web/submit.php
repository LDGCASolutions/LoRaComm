<?php
include "inc/postgresql.inc.php";

print_r($_POST);

if (!preg_match("/[A-Z0-9]{4,10}/", $_POST["nodeID"])) {
  header( 'location: index.php?error=1' );
	exit();
}

if (!preg_match("/[A-Z0-9]{4,10}/", $_POST["nodePass"])) {
  header( 'location: index.php?error=2' );
	exit();
}

if (!empty($_POST["action"]) && $_POST["action"]=="addNode") {
  $query = "SELECT * FROM \"Node\" WHERE id='".$_POST["nodeID"]."'";
  $query = pg_query($db_connection, $query);
  if (pg_num_rows($query)>0){
    echo "Node ID already exists";
    header( 'location: index.php?error=3' );
  	exit();
  } else {
    $query = "INSERT INTO \"Node\" (\"id\", \"password\", \"node_type\", \"description\") VALUES ('".$_POST["nodeID"]."','".$_POST["nodePass"]."','".$_POST["nodeType"]."','".$_POST["nodeDesc"]."')";
    $query = pg_query($db_connection, $query);
    if (!$query){
      header( 'location: index.php?error=4' );
    	exit();
    } else {
      header( 'location: index.php?success=1' );
    	exit();
    }
  }
}
?>
