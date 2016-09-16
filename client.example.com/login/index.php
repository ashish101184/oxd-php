
<?php

session_start();
if(isset( $_REQUEST['error'] ) and strpos( $_REQUEST['error'], 'session_selection_required' ) !== false ){
    require_once '../Get_authorization_url.php';
    $get_authorization_url = new Get_authorization_url();
    $get_authorization_url->setRequestOxdId($_SESSION['oxd_id']);
    $get_authorization_url->setRequestScope(Oxd_RP_config::$scope);
    $get_authorization_url->setRequestAcrValues(Oxd_RP_config::$acr_values);
    $get_authorization_url->setRequestPrompt('login');
    $get_authorization_url->request();

    header("Location: ".$get_authorization_url->getResponseAuthorizationUrl());
    exit;
}
if (isset($_SESSION['oxd_id'])) {

    if (isset($_GET['code']) && isset($_GET['state']) && !empty($_GET['code']) && !empty($_GET['state'])) {

        echo '<p>User login process via OpenID.</p>';
        require_once '../Get_tokens_by_code.php';
        require_once '../Get_user_info.php';
        echo '<a href="https://client.example.com/logout/index.php">Logout</a>';
        echo '<p>Giving user information.</p>';

        echo '<br/>Get_tokens_by_code <br/>';

        $get_tokens_by_code = new Get_tokens_by_code();
        $get_tokens_by_code->setRequestOxdId($_SESSION['oxd_id']);
        $get_tokens_by_code->setRequestCode($_GET['code']);
        $get_tokens_by_code->request();
            $_SESSION['user_oxd_id_token'] = $get_tokens_by_code->getResponseIdToken();
            $_SESSION['user_oxd_access_token'] = $get_tokens_by_code->getResponseAccessToken();
            $_SESSION['state'] = $_REQUEST['state'];
            $_SESSION['session_state'] = $_REQUEST['session_state'];
        echo '<pre>';
        var_dump($get_tokens_by_code->getResponseObject());
        echo '</pre>';

        $get_user_info = new Get_user_info();
        $get_user_info->setRequestOxdId($_SESSION['oxd_id']);
        $get_user_info->setRequestAccessToken($_SESSION['user_oxd_access_token']);
        $get_user_info->request();

        echo '<pre>';
        var_dump($get_user_info->getResponseObject());
        echo '</pre>';

    }
    else {
        var_dump($_GET);
    }
} else {
    var_dump($_SESSION);
}
