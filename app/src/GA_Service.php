<?php
namespace App\Http\Controllers;

class GA_Service{

    public function __construct( Google_Client $client ){
        $this->client = $client;
        $this->init();
    }

    private function init(){
        $this->client->setClientId(Config::get('analytics.client_id') );
        $this->client->setClientSecret(Config::get('analytics.client_secret'));
        $this->client->setDeveloperKey(Config::get('analytics.api_key'));
        $this->client->setRedirectUri('http://localhost:8000/login');
        $this->client->setScopes(array('https://www.googleapis.com/auth/analytics'));
    }

    public function isLoggedIn(){
        if (isset($_SESSION['token'])) {
            $this->client->setAccessToken($_SESSION['token']);
            return true;
        }

        return $this->client->getAccessToken();
    }//authenticate

    public function login( $code ){ 	$this->client->authenticate($code);
        $token = $this->client->getAccessToken();
        $_SESSION['token'] = $token;
        return token;
    }//login

    public function getLoginUrl(){
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }//getLoginUrl
}