<p>OXD login page.</p>

<?php
/**
 * Created by  Vlad Karapetyan
 */
session_start();
if(isset($_POST['submit']) && isset($_POST['your_mail']) && !empty($_POST['your_mail'])){
    if(!$_SESSION['oxd_id']){
        require_once './Register_site.php';
        $register_site = new Register_site();
        $register_site->setRequestAcrValues(Oxd_RP_config::$acr_values);
        $register_site->setRequestAuthorizationRedirectUri(Oxd_RP_config::$authorization_redirect_uri);
        $register_site->setRequestRedirectUris(Oxd_RP_config::$redirect_uris);
        $register_site->setRequestLogoutRedirectUri(Oxd_RP_config::$logout_redirect_uri);
        $register_site->setRequestContacts(["test@test.test"]);
        $register_site->setRequestClientJwksUri("");
        $register_site->setRequestClientRequestUris([]);
        $register_site->setRequestClientTokenEndpointAuthMethod("");
        $register_site->setRequestGrantTypes(Oxd_RP_config::$grant_types);
        $register_site->setRequestResponseTypes(Oxd_RP_config::$response_types);
        $register_site->setRequestClientLogoutUri(Oxd_RP_config::$logout_redirect_uri);
        $register_site->setRequestScope(Oxd_RP_config::$scope);
        $register_site->request();

        if($register_site->getResponseOxdId()){
            //save in your database
            $_SESSION['oxd_id'] = $register_site->getResponseOxdId();
            require_once './Update_site_registration.php';
            $update_site_registration = new Update_site_registration();
            $update_site_registration->setRequestAcrValues(Oxd_RP_config::$acr_values);
            $update_site_registration->setRequestOxdId($_SESSION['oxd_id']);
            $update_site_registration->setRequestAuthorizationRedirectUri(Oxd_RP_config::$authorization_redirect_uri);
            $update_site_registration->setRequestRedirectUris(Oxd_RP_config::$redirect_uris);
            $update_site_registration->setRequestLogoutRedirectUri(Oxd_RP_config::$logout_redirect_uri);
            $update_site_registration->setRequestContacts(["test@test.test"]);
            $update_site_registration->setRequestClientJwksUri("");
            $update_site_registration->setRequestClientRequestUris([]);
            $update_site_registration->setRequestClientTokenEndpointAuthMethod("");
            $update_site_registration->setRequestGrantTypes(Oxd_RP_config::$grant_types);
            $update_site_registration->setRequestResponseTypes(Oxd_RP_config::$response_types);
            $update_site_registration->setRequestClientLogoutUri(Oxd_RP_config::$logout_redirect_uri);
            $update_site_registration->setRequestScope(Oxd_RP_config::$scope);
            $update_site_registration->request();
        }

    }
    require_once './Get_authorization_url.php';
    $get_authorization_url = new Get_authorization_url();
    $get_authorization_url->setRequestOxdId($_SESSION['oxd_id']);
    $get_authorization_url->setRequestAcrValues(Oxd_RP_config::$acr_values);
    $get_authorization_url->request();

    header("Location: ".$get_authorization_url->getResponseAuthorizationUrl());
}
else{
    ?>
    <form method="post" action="/">
        <label for="your_mail">Your email. </label>
        <input type="email" name="your_mail" placeholder="Enter your email." />
        <input type="submit" name="submit" value="Login" />
    </form>
    <?php
}

