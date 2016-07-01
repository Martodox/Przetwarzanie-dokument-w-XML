<?php

  if (preg_match('/\.(?:png|jpg|jpeg|gif|css|html)$/', $_SERVER["REQUEST_URI"])) {
    return false;
  } else {
    include __DIR__ . '/simpleRest.php';
  }