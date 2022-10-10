<?php
$apiKey = "abcdefgHijkLMNOP";

function apiKeyPass($recievedKey) {
  global $apiKey;
    
  if ($recievedKey == $apiKey) {
    return 1;
  }

  echo "-1";
  return 0;
}
?>
