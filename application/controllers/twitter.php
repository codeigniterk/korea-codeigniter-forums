<?php

class Twitter extends Controller {

	function Twitter()
	{
		parent::Controller();
	}

	public function index()
	{
		// This is how we do a basic auth:
		// $this->twitter_lib->auth('user', 'password');

		// Fill in your twitter oauth client keys here

		$consumer_key = 'fqvr4XPKBxjHQ0TYKOOKQg';
		$consumer_key_secret = 'gmWOfMG4JZpJxBRP1wOlm063DnIUPIpi4gKk2TNrE';

		// For this example, we're going to get and save our access_token and access_token_secret
		// in session data, but you might want to use a database instead :)

		//$this->load->library('session');

		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;

		// GET THE ACCESS TOKENS

		$oauth_tokens = $this->session->userdata('twitter_oauth_tokens');

		if ( $oauth_tokens !== FALSE ) $tokens = $oauth_tokens;

		$this->load->library('twitter_lib');

		$auth = $this->twitter_lib->oauth($consumer_key, $consumer_key_secret, $tokens['access_token'], $tokens['access_token_secret']);

		if ( isset($auth['access_token']) && isset($auth['access_token_secret']) )
		{
			// SAVE THE ACCESS TOKENS

			$this->session->set_userdata('twitter_oauth_tokens', $auth);

			if ( isset($_GET['oauth_token']) )
			{
				$uri = $_SERVER['REQUEST_URI'];

				$parts = explode('?', $uri);

				// Now we redirect the user since we've saved their stuff!

				header('Location: '.'http://codeigniter-kr.org');
				return;
			}
		}

		// This is where  you can call a method.

		//$this->twitter_lib->call('statuses/update', array('status' => 'CI 한국사용자포럼 트위터 api 테스트중....'.time()));

		// Here's the calls you can make now.
		// Sexy!

		/*
		$this->twitter_lib->call('statuses/friends_timeline');
		$this->twitter_lib->search('search', array('q' => 'elliot'));
		$this->twitter_lib->search('trends');
		$this->twitter_lib->search('trends/current');
		$this->twitter_lib->search('trends/daily');
		$this->twitter_lib->search('trends/weekly');
		$this->twitter_lib->call('statuses/public_timeline');
		$this->twitter_lib->call('statuses/friends_timeline');
		$this->twitter_lib->call('statuses/user_timeline');
		$this->twitter_lib->call('statuses/show', array('id' => 1234));
		$this->twitter_lib->call('direct_messages');
		$this->twitter_lib->call('statuses/update', array('status' => 'If this tweet appears, oAuth is working!'));
		$this->twitter_lib->call('statuses/destroy', array('id' => 1234));
		$this->twitter_lib->call('users/show', array('id' => 'elliothaughin'));
		$this->twitter_lib->call('statuses/friends', array('id' => 'elliothaughin'));
		$this->twitter_lib->call('statuses/followers', array('id' => 'elliothaughin'));
		$this->twitter_lib->call('direct_messages');
		$this->twitter_lib->call('direct_messages/sent');
		$this->twitter_lib->call('direct_messages/new', array('user' => 'jamierumbelow', 'text' => 'This is a library test. Ignore'));
		$this->twitter_lib->call('direct_messages/destroy', array('id' => 123));
		$this->twitter_lib->call('friendships/create', array('id' => 'elliothaughin'));
		$this->twitter_lib->call('friendships/destroy', array('id' => 123));
		$this->twitter_lib->call('friendships/exists', array('user_a' => 'elliothaughin', 'user_b' => 'jamierumbelow'));
		$this->twitter_lib->call('account/verify_credentials');
		$this->twitter_lib->call('account/rate_limit_status');
		$this->twitter_lib->call('account/rate_limit_status');
		$this->twitter_lib->call('account/update_delivery_device', array('device' => 'none'));
		$this->twitter_lib->call('account/update_profile_colors', array('profile_text_color' => '666666'));
		$this->twitter_lib->call('help/test');
		*/
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/home.php */