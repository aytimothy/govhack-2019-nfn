<?php
  include_once('db_fns.php');
  include_once('header.php');

  $handle = db_connect();

  $pages_sql = 'SELECT temperature, humidity, sound, light FROM readings ORDER BY time DESC LIMIT 1';
  $pages_result = $handle->query($pages_sql);

  echo('{ temperature: "' . $pages_result[0] . '", humidity: "' . $pages_result[1] . '", sound: "' . $pages_result[2] . '", light: "' . $pages_result[3] . '"}');
?>