<?php
session_start();
require_once '../Get_tokens_by_code.php';
require_once '../Get_user_info.php';

echo '<br/>Get_tokens_by_code <br/>';
$get_tokens_by_code = new Get_tokens_by_code('../');

$get_tokens_by_code->setRequestOxdId($_SESSION['oxd_id']);
//getting code from redirecting url, when user allowed.
$get_tokens_by_code->setRequestCode($_GET['code']);
$get_tokens_by_code->setRequestState($_GET['state']);
$get_tokens_by_code->setRequestScopes($_GET['scope']);

$get_tokens_by_code->request();

echo '<br/>Get_user_info <br/>';
$get_user_info = new Get_user_info('../');
$get_user_info->setRequestOxdId($_SESSION['oxd_id']);
$get_user_info->setRequestAccessToken($get_tokens_by_code->getResponseAccessToken());
$get_user_info->request();
echo '<p><span>Name: </span>'.$get_user_info->getResponseName().'</p>';
echo '<p><span>Given Name: </span>'.$get_user_info->getResponseGivenName().'</p>';
echo '<p><span>Family Name: </span>'.$get_user_info->getResponseFamilyName().'</p>';
echo '<p><span>Middle Name: </span>'.$get_user_info->getResponseMiddleName().'</p>';
echo '<p><span>Nickname: </span>'.$get_user_info->getResponseNickname().'</p>';
echo '<p><span>Username: </span>'.$get_user_info->getResponsePreferredUsername().'</p>';
echo '<p><span>Profile: </span>'.$get_user_info->getResponseProfile().'</p>';
echo '<p><span>Picture: </span>'.$get_user_info->getResponsePicture().'</p>';
echo '<p><span>Website: </span>'.$get_user_info->getResponseWebsite().'</p>';
echo '<p><span>Gender: </span>'.$get_user_info->getResponseGender().'</p>';
echo '<p><span>Birthdate: </span>'.$get_user_info->getResponseBirthdate().'</p>';
echo '<p><span>Zoneinfo: </span>'.$get_user_info->getResponseZoneinfo().'</p>';
echo '<p><span>Updated At: </span>'.$get_user_info->getResponseUpdatedAt().'</p>';

