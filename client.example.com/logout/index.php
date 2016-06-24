<?php
/*
 * Created by Vlad Karapetyan
*/

    session_start();
    echo '<p>User login process via OpenID.</p>';
    require_once '../Logout.php';
    echo '<p>Logout.</p>';

    $logout = new Logout();
    $logout->setRequestOxdId($_SESSION['oxd_id']);
    $logout->setRequestPostLogoutRedirectUri(Oxd_RP_config::$logout_redirect_uri);
    $logout->setRequestIdToken($_SESSION['user_oxd_access_token']);
    $logout->setRequestSessionState($_SESSION['session_states']);
    $logout->setRequestState($_SESSION['states']);
    $logout->request();

    unset($_SESSION['user_oxd_id_token']);
    unset($_SESSION['user_oxd_access_token']);
    unset($_SESSION['session_states']);
    unset($_SESSION['states']);
    header("Location: https://client.example.com");
