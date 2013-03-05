<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('main_m');
	}

	function index()
	{
		$data['notice'] = $this->main_m->main_list('공지사항', 'notice');
		$data['free'] = $this->main_m->main_list('자유게시판', 'free');
		$data['qna'] = $this->main_m->main_list('CI 묻고답하기', 'qna');
		$data['lecture'] = $this->main_m->main_list('강좌게시판', 'lecture');
		$data['tip'] = $this->main_m->main_list('TIP게시판', 'tip');
		$data['source'] = $this->main_m->main_list('CI코드 자료실', 'source');
		$data['file'] = $this->main_m->main_list('일반 자료실', 'file');
		$data['ci_make'] = $this->main_m->main_list('CI 사이트 소개', 'ci_make');
		$data['news'] = $this->main_m->main_list('CI 뉴스 및 다운로드', 'news');
		$data['etc_qna'] = $this->main_m->main_list('CI외 질문게시판', 'etc_qna');
		//$data['ad'] = $this->main_m->main_list('광고, 홍보 게시판', 'ad');
		//메인 교체 광고->구인구직 by 웅파 2012.04.02
		$data['job'] = $this->main_m->main_list('구인, 구직 게시판', 'job');
		$data['comment'] = $this->main_m->comment_list();

		//코멘트, 포럼 개발자 최근리스트 표시 by emc
		if($this->session->userdata('auth_code') >= '7')
		{
			//auth->포럼개발자 이상
			$data['ci'] = $this->main_m->main_list('포럼개발자', 'ci');
			$data['su'] = $this->main_m->main_list('운영자게시판', 'su');
		}

		$this->load->view('top_v');
		$this->load->view('main_v', $data);
		$this->load->view('bottom_v');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/mian.php */