<?php
include_once $_SERVER['DOCUMENT_ROOT'].("/model/loginModel.php");
include_once $_SERVER['DOCUMENT_ROOT'].("/libs/Session.php");
include_once $_SERVER['DOCUMENT_ROOT'].("/libs/Cookie.php");

class LoginValidation
{
    function checkUserLoginData($user_login, $user_password)
    {
        $LoginModel = new LoginModel();
        $ip = $_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip"));
        $continent = $details->geoplugin_continentCode;
        $country = $details->geoplugin_countryCode;
        if ($continent === "EU" && $country === "PL") {
            if ($LoginModel->checkUserAttempts() > 3) {
                setAlertCookie("Przekroczono liczbę prób,<br>spróbuj ponownie za 10 minut");
                header("Location: ../index.php");
            } else {
                if ((isset($_SESSION['loginValidation'])))
                    session_destroy();

                $count = $LoginModel->checkUser($user_login, $user_password);
                if ($count == 1) {
                    $LoginModel->cleanUserAttempts();
                    $newSession = new SessionModel();
                    $newSession->setSession($user_login);
                    header('Location: ../view/mainPage.php');
                } else {
                    $LoginModel->addToUserAttempts();
                    setAlertCookie("Złe dane logowania");
                    header("Location: ../index.php");
                }
            }
        } else {
            setAlertCookie("Logowanie zablokowane :(");
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $user_login = $_POST['userName'];
        $user_password = $_POST['userPassword'];
        $Validation = new LoginValidation();
        $Validation->checkUserLoginData($user_login, $user_password);
    }
}
