<?php
  require_once('../../config/db.php');

  if(isset($_GET['user'])){
    // Lookup user id from username
    $user = $_GET['user'];
    $sql = "SELECT user_id, user_email
        FROM users
        WHERE user_name = '$user'";
    $result = $mysqli->query ( $sql ) or die($mysqli->error.__LINE__);
    if ($result->num_rows > 0) {
      while ( $row = $result->fetch_assoc () ) {
        $user_id = $row ['user_id'];
      }
    }
  } else {
    $user_id = $_COOKIE ['user_id'];
  }
  $sql = "SELECT user_id, meta_key, meta_value
      FROM users_meta
      WHERE meta_key = 'user_follows' AND user_id != '$user_id'
      ORDER BY user_id DESC";

  $result = $mysqli->query ( $sql ) or die($mysqli->error.__LINE__);
  $arr = array();
  if ($result->num_rows > 0) {
    // Meta Key and Meta Value can be set as anything. We need to set an array to store all the values for the user.
    while($row = $result->fetch_assoc()) {
      $arr[] = $row;
    }
    echo $json_response = json_encode($arr);
  }
?>