<?php namespace App\Dengue\Authentication

/**
 * Example of retrieving an authentication token of the Facebook service
 *
 * PHP version 5.4
 *
 * @author     Benjamin Bender <bb@codepoet.de>
 * @author     David Desberg <david@daviddesberg.com>
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;


class Authentication
{

    private $_serviceName;

    /* 
     * @param $serviceName = facebook/google/etc...
     */
    function __construct()
    {
        $this->$_serviceName = 'facebook';

        // Session storage
        $storage = new Session();

        // Setup the credentials for the requests
        $credentials = new Credentials(
            $servicesCredentials[$this->$_serviceName]['key'],
            $servicesCredentials[$this->$_serviceName]['secret'],
            $currentUri->getAbsoluteUri()
        );
    }

    public function createService()
    {
        // Instantiate the Facebook service using the credentials, http client and storage mechanism for the token
        /** @var $facebookService Facebook */
        $facebookService = $serviceFactory->createService('facebook', $credentials, $storage, array());

        if (!empty($_GET['code'])) {
            // This is a callback request from facebook, get the token
            $token = $facebookService->requestAccessToken($_GET['code']);

            // Send a request with it
            $result = json_decode($facebookService->request('/me'), true);

            // Show some of the resultant data
            echo 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];

        } elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
            $url = $facebookService->getAuthorizationUri();
            header('Location: ' . $url);
        } else {
            $url = $currentUri->getRelativeUri() . '?go=go';
            echo "<a href='$url'>Login with Facebook!</a>";
        }
    }

}
