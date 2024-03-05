<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/libs/Model.php';
class SessionModel extends Model
{
    function __construct()
  {
    parent::__construct();
    if (session_status() === PHP_SESSION_NONE) {
          session_start();
    }
  }
  function __destruct()
  {
    parent::__destruct();
  }
  public function setSession($user_login)
  {
    $key = md5($user_login);
    $sql = "SELECT szyfr FROM sesja WHERE klucz = '$key'";
        $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
        $_SESSION['loginValidation'] = $row['szyfr'];
    $_SESSION['loginValidationKey'] = $key;
  }
    public function getSessionKey()
  {
    $key = $_SESSION['loginValidationKey'];
    $sql = "SELECT szyfr FROM sesja WHERE klucz = '$key'";
        $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
        return $row['klucz'];
  }

  public function setUser()
  {
    $key = $_SESSION['loginValidationKey'];
    $sql = "SELECT sesja_id FROM sesja WHERE klucz = '$key'";
        $result = mysqli_query($this->conn,$sql);
    $row = mysqli_fetch_assoc($result);
        if($row['sesja_id']==1)
      $_SESSION['user'] = "admin";
    else
      $_SESSION["user"] = "user";
  }
 }
