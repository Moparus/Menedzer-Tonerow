<?php
function setAlertCookie($alert)
{
    $cookie_name = "alert";
    $cookie_value = $alert;
    setcookie($cookie_name, $cookie_value, time() + 120, "/");
}
function clearAlertCookie()
{
    $cookie_name = "alert";
    setcookie($cookie_name, "", time() - 120, "/");
}