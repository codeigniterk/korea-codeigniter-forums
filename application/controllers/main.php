<?php

class Main extends Controller {

	function Main()
	{
		parent::Controller();
		if($this->session->userdata('userid')=='blumine') {
			$this->output->enable_profiler(true);
		} else {
			$this->output->enable_profiler(false);
		}
		$this->load->model('main_model');
	}

	function index()
	{
		$data['notice'] = $this->main_model->main_list('공지사항', 'notice');
		$data['free'] = $this->main_model->main_list('자유게시판', 'free');
		$data['qna'] = $this->main_model->main_list('CI 묻고답하기', 'qna');
		$data['lecture'] = $this->main_model->main_list('강좌게시판', 'lecture');
		$data['tip'] = $this->main_model->main_list('TIP게시판', 'tip');
		$data['source'] = $this->main_model->main_list('CI코드 자료실', 'source');
		$data['file'] = $this->main_model->main_list('일반 자료실', 'file');
		$data['ci_make'] = $this->main_model->main_list('CI 사이트 소개', 'ci_make');
		$data['news'] = $this->main_model->main_list('CI 뉴스 및 다운로드', 'news');
		$data['etc_qna'] = $this->main_model->main_list('CI외 질문게시판', 'etc_qna');
		$data['ad'] = $this->main_model->main_list('광고, 홍보 게시판', 'ad');
		$data['comment'] = $this->main_model->comment_list();
		//$data['comment'] = '';


		//코멘트, 포럼 개발자 최근리스트 표시 by emc
		if($this->session->userdata('auth_code') >= '7') {
			//auth->포럼개발자 이상
			$data['ci'] = $this->main_model->main_list('포럼개발자', 'ci');
			$data['su'] = $this->main_model->main_list('운영자게시판', 'su');
			// 버그최신정보 by ci세상
			//$data['bug_rss'] = $this->main_model->bug_rss_list();
		}

		/**
		 * 트위터 관련 토큰 생성
		 */
		// This is how we do a basic auth:
		// $this->twitter_lib->auth('user', 'password');

		// Fill in your twitter oauth client keys here
/*
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
		$data['twitter'] = $this->twitter_lib->call('statuses/home_timeline');
*/
/*
		$this->load->library('twitter_lib');
		$this->twitter_lib->auth('codeigniterK', 'code3432');
		$data['twitter'] = $this->twitter_lib->call('statuses/home_timeline');
*/
		$this->load->view('top_v');
		$this->load->view('main_v', $data);
		$this->load->view('bottom_v');
	}

	function test()
    {
		$this->load->library('twitter_lib');
		$this->twitter_lib->auth('codeigniterK', 'code3432');
		$tcontents="포럼에서 등록하는 글 테스트입니다. 지울겁니다. 글은 어디서 잘리는지 테스트합니다 고고";
		$contents1 = "웅파 ".$tcontents;

		$this->twitter_lib->call('statuses/update', array('status' => '테스트 테스트'));
		echo $contents1;
    }


    function first_validation($str)
    {
        echo "running first validation: $str <br>";
        return TRUE; // force successful validation
    }

    function second_validation($str)
    {
        echo "running second validation: $str <br>";

        return TRUE; // force successful validation
    }

}

/* End of file main.php */
/* Location: ./system/application/controllers/mian.php */