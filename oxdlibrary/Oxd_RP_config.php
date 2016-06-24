<?php
/**
 * Gluu-oxd-library
 *
 * An open source application library for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015, Gluu inc, USA, Austin
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Gluu-oxd-library
 * @version 2.4.2
 * @author	Vlad Karapetyan
 * @author		vlad.karapetyan.1988@mail.ru
 * @copyright	Copyright (c) 2015, Gluu inc federation (https://gluu.org/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://gluu.org/
 * @since	Version 2.4.2
 * @filesource
 */

/**
 * Oxd RP config
 *
 * Class Oxd_RP_config, setting all configuration
 *
 * @package		Gluu-oxd-library
 * @subpackage	Libraries
 * @category	Base class for all protocols
 * @author		Vlad Karapetyan
 * @author		vlad.karapetyan.1988@mail.ru
 */

class Oxd_RP_config
{
    /**
     * @static
     * @var string $oxd_host_ip        Socket connection ip
     */
    public static $oxd_host_ip;
    /**
     * @static
     * @var int $oxd_host_port        Socket connection port
     */
    public static $oxd_host_port;
    /**
     * @static
     * @var string $authorization_redirect_uri        Site authorization redirect uri
     */
    public static $authorization_redirect_uri;
    /**
     * @static
     * @var string $logout_redirect_uri        Site logout redirect uri
     */
    public static $logout_redirect_uri;
    /**
     * @static
     * @var array $scope        For getting needed scopes from gluu-server
     */
    public static $scope;
    /**
     * @static
     * @var string $application_type        web or mobile
     */
    public static $application_type;
    /**
     * @static
     * @var array $redirect_uris        Site redirect uris after login or logout
     */
    public static $redirect_uris;
    /**
     * @static
     * @var array $response_types        OpenID Authentication response types
     */
    public static $response_types;
    /**
     * @static
     * @var array $grant_types        OpenID Token Request type
     */
    public static $grant_types;

    /**
     * @static
     * @var array $acr_values        Gluu login acr type, can be basic, duo, u2f, gplus and etc.
     */
    public static $acr_values;
}