<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class LoginModel extends Model
{
    function __construct()
  {
    parent::__construct();
  }
  function __destruct()
  {
    parent::__destruct();
  }
  public function checkUser($user_login, $user_password)
  {
    $user_login = mysqli_real_escape_string($this->conn, $user_login);
    $user_password = hash('sha256', mysqli_real_escape_string($this->conn, $user_password));
    $sql = "SELECT EXISTS(SELECT * FROM `uzytkownik` WHERE `login` = '".$user_login."' AND `haslo` = '".$user_password."') AS 'validation'";
        $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['validation'];
  }
  public function checkUserAttempts()
  {
    $ip = $_SERVER["REMOTE_ADDR"];
    $result = mysqli_query($this->conn, "SELECT COUNT(*) FROM `ip` WHERE `adres` LIKE '$ip' AND `czas` > (now() - interval 10 minute)");
    $count = mysqli_fetch_array($result, MYSQLI_NUM);
    return $count[0];
  }
  public function addToUserAttempts()
  {
    $ip = $_SERVER["REMOTE_ADDR"];
    mysqli_query($this->conn, "INSERT INTO `ip` (`adres` ,`czas`) VALUES ('$ip',CURRENT_TIMESTAMP)");
  }
  public function cleanUserAttempts()
  {
    $ip = $_SERVER["REMOTE_ADDR"];
    mysqli_query($this->conn, "DELETE FROM `ip` WHERE `adres` = '$ip'");
  }
  
}