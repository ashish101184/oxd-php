
<?php

session_start();
if (isset($_SESSION['oxd_id']) and empty($_SESSION['state'])) {

    if (isset($_REQUEST['code']) && isset($_REQUEST['state']) && !empty($_REQUEST['code']) && !empty($_REQUEST['state'])) {

        echo '<p>User login process via OpenID.</p>';
        require_once '../Get_tokens_by_code.php';
        require_once '../Get_user_info.php';
        echo '<a href="https://client.example.com/logout/index.php">Logout</a>';
        echo '<p>Giving user information.</p>';

        echo '<br/>Get_user_info <br/>';

        $get_tokens_by_code = new Get_tokens_by_code();
        $get_tokens_by_code->setRequestOxdId($_SESSION['oxd_id']);
        $get_tokens_by_code->setRequestCode($_REQUEST['code']);
        $get_tokens_by_code->setRequestState($_REQUEST['state']);
        $get_tokens_by_code->request();
        $_SESSION['user_oxd_id_token'] = $get_tokens_by_code->getResponseIdToken();
        $_SESSION['state'] = $_REQUEST['state'];
        $_SESSION['session_state'] = $_REQUEST['session_state'];

        $get_user_info = new Get_user_info();
        $get_user_info->setRequestOxdId($_SESSION['oxd_id']);
        $get_user_info->setRequestAccessToken($get_tokens_by_code->getResponseAccessToken());
        $get_user_info->request();

        echo '<pre>';
        var_dump($get_user_info->getResponseObject());
        echo '</pre>';
        exit;

    }
    else {
        var_dump($_REQUEST);
    }
} else {
    var_dump($_SESSION);
}
exit;