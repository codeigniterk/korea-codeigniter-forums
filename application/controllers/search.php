<?php

class Search extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('search_m');
		$this->load->model('main_m');
		$this->seg_exp = segment_explode($this->uri->uri_string());
	}

	//헤더, 푸터 자동삽입
	public function _remap($method)
	{
		$this->load->view('top_v');

		if( method_exists($this, $method) )
		{
			$this->{"{$method}"}();
		}

		$this->load->view('bottom_v');
	}


	//통합검색 기능추가 by emc (2009/08/19)
	//세그먼트 정리 및 리맵 추가 by 웅파 (2013/03/05)
	function index()
	{
		if( in_array('q', $this->seg_exp) )
		{
			$data['search_word'] = $search_word = urldecode($this->security->xss_clean(url_explode($this->seg_exp, 'q')));
			//주소에서 q 제거. 뷰에서 사용
			$this->seg_exp =  url_delete($this->seg_exp, 'q');
			$data['search_url'] = "q/".$search_word;
		}
		else
		{
			$data['search_word'] = $search_word = '';
			$data['search_url'] = '';
		}

		if( $search_word != '' )
		{
			$post = array('s_word'=>str_replace("'", "", $search_word));
		}
		else
		{
			$post = '';
		}

		$data['search_total'] = $total = $this->search_m->search_total($post);


		if($this->uri->segment(4) == 'page')
		{
			$data['page_account']=$page = 1;
		}
		else
		{
			//페이징
			if( in_array('page', $this->seg_exp) )
			{
				$data['page_account'] = $page = urldecode($this->security->xss_clean(url_explode($this->seg_exp, 'page')));
			}
			else
			{
				$data['page_account'] = $page = 1;
			}
		}

		$rp = 20; //리스트 갯수
		$limit = 9; //보여줄 페이지수

		$start = (($page-1) * $rp);

		//검색후 페이징처리위한..
		$this->url_seg = $this->seg_exp;
		$urls = implode('/', url_delete($this->url_seg, 'page'));

		$data['pagination_links'] = pagination($urls."/page", paging($page,$rp,$total,$limit));
		$data['search_list'] = $this->search_m->search_list($start, $rp, $post);

		$this->load->view('board/search_v', $data);
	}

	//당일 하루치 덧글 보기
	//by 웅파 (2009/12/23)
	function recent_comment()
	{
		$data['search_list'] = $this->main_m->comment_list_full();
		$data['page_account']= 1;

		$this->load->view('board/recent_comment', $data);
	}

	function my_list()
	{
		$data['search_total'] = $total = $this->search_m->my_total($this->session->userdata('userid'), 'REPLY1');

		//페이징
		if(in_array("page", $this->seg_exp)) {
			$arr_key = array_keys($this->seg_exp, "page");
			$arr_val = $arr_key[0] + 1;
			$data['page_account']=$page = $this->seg_exp[$arr_val];
		} else {
			$data['page_account']=$page = 1;
		}

		$rp = 20; //리스트 갯수
		$limit = 9; //보여줄 페이지수

		$start = (($page-1) * $rp);

		//검색후 페이징처리위한..
		$this->url_seg = $this->seg_exp;
		$arr_s = array_search('page', $this->url_seg);
		if($arr_s == ''){
			array_splice($this->url_seg, $arr_s, 0);
		} else {
			array_splice($this->url_seg, $arr_s, 2);
		}

		$urls = implode('/', $this->url_seg);

		$data['pagination_links'] = pagination($urls."/page", paging($page,$rp,$total,$limit));
		$data['my_list'] = $this->search_m->my_list($start, $rp, $this->session->userdata('userid'), 'REPLY1');

		$this->load->view('board/my_list', $data);
	}
}