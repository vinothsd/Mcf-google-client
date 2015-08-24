<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Google_Client;
use Input;
use Google_Service_Analytics;

class AnalyticsController extends Controller
{

	/**
	 * @param Google_Client $client
     */
	public function __construct( Google_Client $client ){
		$this->client = $client;
		$this->init();
	}

	/**
	 *
     */
	private function init(){
		$this->client->setClientId('457741973838-2204ifr984oif1a528pv55223fen7um5.apps.googleusercontent.com');
		$this->client->setClientSecret('t5xRw-AXYpv6PrZIb90Lt334');
		//$this->client->setDeveloperKey('AI39si5fe78kneJhHty0euKVVaaykjruX_ovzpcq8MOLj5EbWEmtB2NakCIoVm6RqOJJnyfpoVd4G8VXbRhiut864UethyOqfA');
		$this->client->setRedirectUri('http://localhost/laravel/public/login');
		$this->client->setScopes(array('https://www.googleapis.com/auth/analytics'));
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
	public function index()
	{
		if( $this->isLoggedIn() ){
			return 'Show home page';
		}
		else{
			$url = $this->getLoginUrl();
			return redirect($url);
		}
	}

	/**
	 * @return bool|string
     */
	public function isLoggedIn(){
		if (isset($_SESSION['token'])) {
			$this->client->setAccessToken($_SESSION['token']);
			return true;
		}
		return $this->client->getAccessToken();
	}

	/**
	 * @return string
     */
	public function getLoginUrl(){
		$authUrl = $this->client->createAuthUrl();
		return $authUrl;
	}

	/**
	 * @return \Illuminate\View\View|string
     */
	public function login(){
		if( Input::has('code') ){
			$code = Input::get('code');
			$this->setToken($code);
			//return "Go to the home <a href='analytics'>page</a>";
			return $this->analytics_data();
		}
		else{
			return "Invalide request parameters";
		}
	}

	/**
	 * @param $code
	 * @return string
     */
	public function setToken($code){
		$this->client->authenticate($code);
		$token = $this->client->getAccessToken();
		Session::put('token',$code);
		return $token;
	}

	/**
	 * @return \Illuminate\View\View
     */
	public function analytics_data()
	{
		$analytics= new Google_Service_Analytics($this->client);
		$mcf = $analytics->data_mcf->get(
			'ga:85389321',
			date('Y-m-d', strtotime('last year')),
			date('Y-m-d'),
			'mcf:assistedConversions,mcf:assistedValue,mcf:firstInteractionConversions,mcf:firstInteractionValue,mcf:lastInteractionConversions,mcf:lastInteractionValue',
			array(
				'dimensions' => 'mcf:basicChannelGrouping',
				'access_token' => Session::get('token')
			)
		);
		return View('analytics',['data' => $mcf]);
	}
}
