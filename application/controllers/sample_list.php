<?php
/**
* 개발 웅파(blumine@paran.com)
* 2010-01-20
* 매뉴얼 연동된 실행예제 리스트
*/
class Sample_list extends Controller {

	function Sample_list()
	{
		parent::Controller();
	}

	function _remap($method) {
		$this->load->view('top_v');
		$this->$method();
		$this->load->view('bottom_v');
	}

	function index()
	{
		$this->load->helper('file');
		$direc = DOC_ROOT.'/application/controllers/manual_source/';
		//echo $direc;
		$data['arr'] = get_filenames($direc);
		$this->load->view('sample_list_v', $data);
	}
}