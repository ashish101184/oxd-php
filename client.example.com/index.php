<p>OXD login page.</p>

<?php
/**
 * Created by  Vlad Karapetyan
 */
session_start();
if(isset($_POST['submit']) && isset($_POST['your_mail']) && !empty($_POST['your_mail'])){
    if(!$_SESSION['oxd_id']){
        require_once './Register_site.php';
        $register_site = new Register_site('./');
        $register_site->setRequestAcrValues([]);
        $register_site->setRequestAuthorizationRedirectUri('https://client.example.com/login/index.php');
        $register_site->setRequestRedirectUris([ 'https://client.example.com/login/index.php' ]);
        $register_site->setRequestLogoutRedirectUri('https://client.example.com/logout/index.php');
        $register_site->setRequestContacts([$_POST['your_mail']]);
        $register_site->setRequestGrantTypes(["authorization_code"]);
        $register_site->setRequestResponseTypes(['code']);
        $register_site->setRequestClientLogoutUri('https://client.example.com/logout/index.php');
        $register_site->setRequestScope([ "openid", "profile","email"]);
        $register_site->request();

        if($register_site->getResponseOxdId()){
            $_SESSION['oxd_id'] = $register_site->getResponseOxdId();
        }

    }
    require_once './Get_authorization_url.php';
    $get_authorization_url = new Get_authorization_url('./');
    $get_authorization_url->setRequestOxdId($_SESSION['oxd_id']);
    $get_authorization_url->setRequestAcrValues(["basic"]);
    $get_authorization_url->request();

    header("Location: ".$get_authorization_url->getResponseAuthorizationUrl());
}
else{
    ?>
    <form method="post" action="/">
        <label for="your_mail">Your OpenID email. </label>
        <input type="email" name="your_mail" placeholder="Enter your OpenID email." />
        <input type="submit" name="submit" value="Login" />
    </form>
    <?php
}

