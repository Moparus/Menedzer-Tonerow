<?php
include_once $_SERVER['DOCUMENT_ROOT'].("/model/sessionModel.php");

$newSession= new SessionModel();
if((!isset($_SESSION['loginValidation'])) && (hash('sha256', $newSession->getSessionKey())!=$_SESSION['loginValidation'])){
     header('location: ../index.php');
     session_destroy();
}

if(isset($_SESSION['loginValidation']) && (!isset($_SESSION['user'])))
{
     $newSession->setUser();
}

if(isset($_POST['logoutButton'])) {
     switch($_POST['logoutButton']) {
          case "logout":
          session_destroy();
          header('location: ../index.php');
          break;
     }
 }
  
    
function checkIfAdmin($user_session){
    if($user_session == "admin") {
            return true;
      }
    return false;
  }
