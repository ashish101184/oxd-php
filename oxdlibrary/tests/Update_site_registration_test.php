<?php

session_start();
include_once '../Update_site_registration.php';

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

print_r($update_site_registration->getResponseObject());

