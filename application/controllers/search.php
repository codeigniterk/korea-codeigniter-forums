<?php

class Search extends Controller {

	function Search()
	{
		parent::Controller();
		if($this->session->userdata('userid')=='blumine') $this->output->enable_profiler(TRUE);
		$this->load->model('search_model');
		$this->load->model('main_model');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}

	//통합검색 기능추가 by emc (2009/08/19)
	function index()
	{
		if(in_array("q", $this->seg_exp)) {
			$arr_key = array_keys($this->seg_exp, "q");
			$arr_val = $arr_key[0] + 1;

            if(@$this->seg_exp[$arr_val]){
			    $search_word = $this->db->escape($this->seg_exp[$arr_val]);
            } else {
                $search_word = '검색어 없음';
            }
			//echo ">>> ".$search_word." <<<<BR>";
			$post = array('s_word' => str_replace("'", "", $search_word));
		} else {
    		$post = '';
    	}

		$data['search_total'] = $total = $this->search_model->search_total($post);
		//$data['search_total'] = $this->search_model->search_total($post);

		//$data['page_account']=$page = 1

		if($this->uri->segment(4) == 'page')
		{
			$data['page_account']=$page = 1;
		}
		else
		{
			//페이징
			if(in_array("page", $this->seg_exp)) {
				$arr_key = array_keys($this->seg_exp, "page");
				$arr_val = $arr_key[0] + 1;
				if(in_array("page", $this->seg_exp)){
					$data['page_account']=$page = @$this->seg_exp[$arr_val];
				} else {
					$data['page_account']=$page = 1;
				}
			} else {
				$data['page_account']=$page = 1;
			}
		}
		//if($this->session->userdata('userid')=='blumine') echo $page."--";

		$rp = 20; //리스트 갯수
		$limit = 9; //보여줄 페이지수

		$start = (($page-1) * $rp);

		//검색후 페이징처리위한..
		$this->url_seg = $this->seg_exp;
		$arr_s = array_search('page', $this->url_seg);
		if($arr_s == ''){
			array_splice($this->url_seg, $arr_s, 0);
		} else {
			if($this->uri->segment(4) == 'page')
			{
				array_splice($this->url_seg, $arr_s, 1, 'pag');
			} else {
				array_splice($this->url_seg, $arr_s, 2);
			}

		}


		//if($this->session->userdata('userid')=='blumine') var_dump($this->url_seg);

		$urls = implode('/', $this->url_seg);

		$data['pagination_links'] = $this->common->pagination($urls."/page", paging($page,$rp,$total,$limit));
		$data['search_list'] = $this->search_model->search_list($start, $rp, $post);

		$this->load->view('top_v');
		$this->load->view('board/search', $data);
		$this->load->view('bottom_v');
	}

	//당일 하루치 덧글 보기
	//by 웅파 (2009/12/23)
	function recent_comment()
	{
		$data['search_list'] = $this->main_model->comment_list_full();
		$data['page_account']= 1;
		$this->load->view('top_v');
		$this->load->view('board/recent_comment', $data);
		$this->load->view('bottom_v');
	}

	function my_list()
	{
		$data['search_total'] = $total = $this->search_model->my_total($this->session->userdata('userid'), 'REPLY1');

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

		$data['pagination_links'] = $this->common->pagination($urls."/page", paging($page,$rp,$total,$limit));
		$data['my_list'] = $this->search_model->my_list($start, $rp, $this->session->userdata('userid'), 'REPLY1');

		$this->load->view('top_v');
		$this->load->view('board/my_list', $data);
		$this->load->view('bottom_v');
	}
}