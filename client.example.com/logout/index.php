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
    $logout->setRequestIdToken($_SESSION['user_oxd_id_token']);
    $logout->setRequestSessionState($_SESSION['session_state']);
    $logout->setRequestState($_SESSION['state']);
    $logout->request();

    unset($_SESSION['user_oxd_id_token']);
    unset($_SESSION['user_oxd_access_token']);
    unset($_SESSION['session_state']);
    unset($_SESSION['state']);
    header("Location: ".$logout->getResponseObject()->data->uri);
exit;