Oxd-rp php library
=========================

Need to download and install gluu server in Your web server. For more
information [click me](http://www.gluu.org/docs/).

Need to download and install OXD server in Your web server. For more
information [click me](http://ox.gluu.org/doku.php?id=oxd:rp).

For OXD server configuration [click me](http://ox.gluu.org/doku.php?id=oxd:home&s[]=mvn).

PHP Client Library for the [Gluu OXD-RP
Server](https://github.com/GluuFederation/oxd-php/tree/master/oxd-rp).

oxd-rp-php configuration 
------------------------

Configuration file is located in 'oxd-rp/oxd-rp-settings.json' file in
distribution package.

(Save this as a file called `oxd-rp-settings.json`)

``` {.code }
{
    "oxd_host_ip": "127.0.0.1",
    "oxd_host_port":8099,
    "authorization_redirect_uri" : "",
    "logout_redirect_uri" : "",
    "scope" : [ "openid", "profile" ],
    "application_type" : "web",
    "redirect_uris" : [ "" ],
    "response_types" : ["code"],
    "grant_types":"authorization_code",
    "acr_values" : [ "basic", "duo" ]
}
                        
```

-   oxd_host_port - port of oxd socket
-   oxd_host_ip - flag to restrict communication to localhost only (if false then it's not restricted to localhost only)

**Goal** :

-   It should be super simple to use library (
    [python](https://github.com/GluuFederation/oxd-python)  /  
    [php-oxd-rp](https://github.com/GluuFederation/oxd-php/tree/master/oxd-rp)) by
    web site
-   implementation of new library (on any language) should be simplified

[![](http://ox.gluu.org/lib/exe/fetch.php?media=oxd:oxd-rp.png)](http://ox.gluu.org/lib/exe/detail.php?id=oxd%3Arp&media=oxd:oxd-rp.png "oxd:oxd-rp.png")

Web site 
--------

Web site communicates with oxd via library (python/php-oxd-rp). Library
must provide all convenient methods to web site code which will in
background call oxd. Concrete library depends on programming language
used by site. Here for simplicity we will PHP as sample.

First of all web site must register itself on oxd with registration
command (via library (
[python](https://github.com/GluuFederation/oxd-python)  /  
[php](https://github.com/GluuFederation/oxd-php)). With registration it
gets oxd_id from oxd server. oxd\_id must be passed to all commands.

**php-oxd-rp** is a thin wrapper around the communication protocol of
oxD server. This can be used to access the OpenID connect & UMA
Authorization end points of the Gluu Server via the oxD RP. This library
provides the function calls required by a website to access user
information from a OpenID Connect Provider (OP) by using the OxD as the
Relying Party (RP).

PHP classes for communicating with oxd.

Connecting to oxd server is doing via class Client\_Socket\_OXD\_RP
[Client\_Socket\_OXD\_RP.php]

## Client\_Socket\_OXD\_RP.php 

Client\_Socket\_OXD\_RP class is base class for connecting to oxd
server. It is given all parameters from oxd-rp-settings.json for
connection and parameters saving to static values in class
Oxd\_RP\_config.


Constructor accept folder base\_url = string parameter

-   #### Parameter:

    -   #### Name: $socket;

        Type: static object;

        Default value = null;

        Description: oxd socket connection;

-   #### Functions:

    -   #### Name: static\_variables;

        Description: Setting configurations static parameters;

    -   #### Name: oxd\_socket\_request;

         Description: Sending request to oxd server;

    -   #### Name: error\_message;

        Description: Showing last error message;

    -   #### Name: log;

        Description: Saving process in log file every day(example
        logs/oxd-php-server-{date}.log);

## Oxd\_RP\_config.php 

``` {.code}
class Oxd_RP_config
{
    public static $oxd_host_ip;
    public static $oxd_host_port;
    public static $authorization_redirect_uri;
    public static $logout_redirect_uri;
    public static $scope;
    public static $application_type;
    public static $redirect_uris;
    public static $response_types;
    public static $grant_types;
    public static $acr_values;
}
                        
```

Base class for protocols is abstract Client\_OXD\_RP.php, for which
extends all protocols classes.
[Client\_OXD\_RP]

-   [Register\_site.php](#Register_site)
-   [Get\_authorization\_url.php](#Get_authorization_url)
-   [Get\_tokens\_by\_code.php](#Get_tokens_by_code)
-   [Get\_user\_info.php](#Get_user_info)
-   [Logout.php](#Logout)

## Clinet\_OXD\_RP.php 

Client\_OXD\_RP class is abstract class,which extends from
Client\_Socket\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Name: $command\_types;

        Type:array;

        Default value = array('register\_site',
        'update\_site\_registration', 'get\_logout\_uri'
        'get\_authorization\_url',
        'get\_tokens\_by\_code','get\_user\_info');

        Description: all protocol names. need for checking protocol
        type;

    -   #### Name: $command;

        Type:string;

        Default value = null;

        Description: request command to oxd;

    -   #### Name: $response\_json;

        Type:string(json);

        Default value = null;

        Description: response, which coming from oxd;

    -   #### Name: $response\_object;

        Type:array;

        Default value = null;

        Description: response object, which parsed from
        $response\_json;

    -   #### Name: $response\_status;

        Type:string;

        Default value = null;

        Description: response status, can be Ok or Error;

    -   #### Name: $data;

        Type:array;

        Default value = null;

        Description: response data;

-   #### Functions:

    -   #### Name: setCommand;

        Type:abstract;

        Param:string;

        Description: Setting protocol type;

    -   #### Name: getCommand;

        Return:string;

        Description: Getting protocol type;

    -   #### Name: setParams;

        Type:abstract;

        Param:array;

        Description: Setting params for protocol;

    -   #### Name: getParams;

        Return:array;

        Description: Getting params for protocol;

    -   #### Name: getData;

        Return:array;

        Description: Getting data for sanding to oxd;

    -   #### Name: is\_JSON;

        Param:string;

        Description: Chaking is string is json;

    -   #### Name: request;

        Description: Sanding request to oxd;

    -   #### Name: getResponseJSON;

        Return:string;

        Description: Getting response from oxD server, returning JSON
        object;

    -   #### Name: getResponseObject;

        Return:array;

        Description: Getting response from oxD server, returning array
        object;

## Register\_site.php 

Register\_site class extends from Clinet\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Description: Parameters necessary for to request Register\_site protocol;

        $request\_authorization\_redirect\_uri,$request\_response\_types,$request\_client\_logout\_uri,$request\_grant\_types,$request\_scope,
        $request\_logout\_redirect\_uri, $request\_application\_type,
        $request\_redirect\_uris, $request\_acr\_values,
        $request\_client\_jwks\_uri,
        $request\_client\_token\_endpoint\_auth\_method,
        $request\_client\_request\_uris, $request\_contacts;

        Type:string;

        Default value = null;

    -   #### Description: Response parameters from oxd;

        $response\_oxd\_id

        Type:string;

-   #### Functions:

    -   #### Extended functions from parent class,response parameter getters and request parameters setters and getters;

**Example**

``` {.code}
Register_site_test:

session_start();
include_once '../Register_site.php';

$register_site = new Register_site('../');

$register_site->setRequestAcrValues(Oxd_RP_config::$acr_values);
$register_site->setRequestAuthorizationRedirectUri(Oxd_RP_config::$authorization_redirect_uri);
$register_site->setRequestRedirectUris(Oxd_RP_config::$redirect_uris);
$register_site->setRequestLogoutRedirectUri(Oxd_RP_config::$logout_redirect_uri);
$register_site->setRequestContacts(["vlad@gluu.org"]);
$register_site->setRequestClientJwksUri("");
$register_site->setRequestClientRequestUris([]);
$register_site->setRequestClientTokenEndpointAuthMethod("");
$register_site->setRequestGrantTypes(Oxd_RP_config::$grant_types);
$register_site->setRequestResponseTypes(Oxd_RP_config::$response_types);
$register_site->setRequestClientLogoutUri(Oxd_RP_config::$logout_redirect_uri);
$register_site->setRequestScope(Oxd_RP_config::$scope);

$register_site->request();
$_SESSION['oxd_id'] = $register_site->getResponseOxdId();

print_r($register_site->getResponseObject());

                        
```

## Get\_authorization\_url.php 

Get\_authorization\_url class extends from Clinet\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Description: Parameters necessary for to request Get\_authorization\_url protocol;

        $request\_oxd\_id, $request\_acr\_values

        Type:string;

        Default value = null;

    -   #### Description: Response parameters from oxd;

        $response\_authorization\_url

        Type:string;

-   #### Functions:

    -   #### Extended functions from parent class,response parameter getters and request parameters setters and getters;

**Example**

``` {.code}
Get_authorization_url_test:
session_start();
require_once '../Get_authorization_url.php';

$get_authorization_url = new Get_authorization_url('../');
$get_authorization_url->setRequestOxdId($_SESSION['oxd_id']);

$get_authorization_url->request();

echo $get_authorization_url->getResponseAuthorizationUrl();

                        
```

## Get\_tokens\_by\_code.php

Get\_tokens\_by\_code class extends from Clinet\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Description: Parameters necessary for to request Get\_tokens\_by\_code protocol;

        $request\_oxd\_id, $request\_state, $request\_scopes,
        $request\_code Type:string;

        Default value = null;

    -   #### Description: Response parameters from oxd;

        $response\_access\_token, $response\_expires\_in,
        $response\_id\_token = Type:string;

        $response\_id\_token\_claims = Type:array;

-   #### Functions:

    -   #### Extended functions from parent class,response parameter getters and request parameters setters and getters;

**Example**

``` {.code}
Get_tokens_by_code_test:
session_start();
require_once '../Get_tokens_by_code.php';

$get_tokens_by_code = new Get_tokens_by_code();

$get_tokens_by_code->setRequestOxdId($_SESSION['oxd_id']);

//getting code from redirecting url, when user allowed.
$get_tokens_by_code->setRequestCode($_GET['code']);
$get_tokens_by_code->setRequestState($_GET['state']);
$get_tokens_by_code->setRequestScopes($_GET['scope']);

$get_tokens_by_code->request();
$_SESSION['user_oxd_id_token'] = $get_tokens_by_code->getResponseIdToken();
$_SESSION['user_oxd_access_token'] = $get_tokens_by_code->getResponseAccessToken();
$_SESSION['state'] = $_REQUEST['state'];
$_SESSION['session_state'] = $_REQUEST['session_state'];
print_r($get_tokens_by_code->getResponseObject());
```

## Get\_user\_info.php

Get\_user\_info class extends from Clinet\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Description: Parameters necessary for to request Get\_user\_info protocol;

        Type:string: $request\_oxd\_id, $request\_access\_token

    -   #### Description: Response parameters from oxd;

        $response\_claims

        Type:array;

-   #### Functions:

    -   #### Extended functions from parent class,response parameter getters and request parameters setters and getters;

**Example**

``` {.code}
Get_user_info_test:
session_start();
require_once '../Get_tokens_by_code.php';
require_once '../Get_user_info.php';
echo 'Giving user information.';

echo Get_tokens_by_code ';
$get_tokens_by_code = new Get_tokens_by_code('../');

$get_tokens_by_code->setRequestOxdId($_SESSION['oxd_id']);
$get_tokens_by_code->setRequestCode($_GET['code']);
$get_tokens_by_code->setRequestState($_GET['state']);
$get_tokens_by_code->setRequestScopes($_GET['scope']);

$get_tokens_by_code->request();
$_SESSION['user_oxd_id_token'] = $get_tokens_by_code->getResponseIdToken();
$_SESSION['user_oxd_access_token'] = $get_tokens_by_code->getResponseAccessToken();
$_SESSION['state'] = $_REQUEST['state'];
$_SESSION['session_state'] = $_REQUEST['session_state'];
echo Access Token: '.$get_tokens_by_code->getResponseAccessToken();
echo Expires In: '.$get_tokens_by_code->getResponseExpiresIn();
echo Id Token: '.$get_tokens_by_code->getResponseIdToken();
echo Get_user_info ';
$get_user_info = new Get_user_info('../');
$get_user_info->setRequestOxdId($_SESSION['oxd_id']);
$get_user_info->setRequestAccessToken($get_tokens_by_code->getResponseAccessToken());
$get_user_info->request();
echo 'Name: '.$get_user_info->getResponseName();
echo 'Given Name: '.$get_user_info->getResponseGivenName();
echo 'Family Name: '.$get_user_info->getResponseFamilyName();
echo 'Middle Name: '.$get_user_info->getResponseMiddleName();
echo 'Nickname: '.$get_user_info->getResponseNickname();
echo 'Username: '.$get_user_info->getResponsePreferredUsername();
echo 'Profile: '.$get_user_info->getResponseProfile();
echo 'Picture: '.$get_user_info->getResponsePicture();
echo 'Website: '.$get_user_info->getResponseWebsite();
echo 'Gender: '.$get_user_info->getResponseGender();
echo 'Birthdate: '.$get_user_info->getResponseBirthdate();
echo 'Zoneinfo: '.$get_user_info->getResponseZoneinfo();
echo 'Updated At: '.$get_user_info->getResponseUpdatedAt();
                        
```

## Logout.php

Logout class extends from Clinet\_OXD\_RP class.

Constructor accept parent constructor parameter ($base\_url = string)

-   #### Parameters:

    -   #### Description: Parameters necessary for to request Logout protocol;

        Type:string: $request\_oxd\_id, $request\_id\_token,
        $request\_post\_logout\_redirect\_uri,
        $request\_session\_state, $request\_state

    -   #### Description: Parameters necessary for to request Logout protocol;

        Type:boolean: $request\_http\_based\_logout

    -   #### Description: Response parameters from oxd;

        $response\_html

        Type:string;

-   #### Functions:

    -   #### Extended functions from parent class,response parameter getters and request parameters setters and getters;

**Example**

``` {.code}
Logout_test:
session_start();
require_once '../Logout.php';

$logout = new Logout('../');
$logout->setRequestOxdId($_SESSION['oxd_id']);
$logout->setRequestPostLogoutRedirectUri(Oxd_RP_config::$logout_redirect_uri);
$logout->setRequestIdToken($_SESSION['user_oxd_access_token']);
$logout->setRequestSessionState($_SESSION['session_states']);
$logout->setRequestState($_SESSION['states']);
$logout->request();

echo $logout->getResponseHtml();


                        
```
