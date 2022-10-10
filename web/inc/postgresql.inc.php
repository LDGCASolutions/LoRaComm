<?php
  $db_connection = pg_connect("user=postgres password=YmQmYeg!vqj4czX host=db.yejksyrnlxnvjvvtioja.supabase.co port=5432 dbname=postgres");

  if ( !$db_connection ) {
    echo "Database Connection failed";
  }
?>
