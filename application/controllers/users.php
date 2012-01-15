<?php

class Users extends Controller {

	function Users()
	{
		parent::Controller();
		$this->output->enable_profiler(false);
		$this->load->model('users_model', 'users');
	}

	function index()
	{
		echo $this->config->system_url();
	}

	function mypage()
	{
		if(!$this->session->userdata('userid')) {
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$data['rpath_encode'] = base64_encode($rpath);
			$this->load->view('top_v');
			$this->load->view('login_view',$data);
			$this->load->view('bottom_v');
		} else {
			$data['list'] = $this->users->my_list();
			$this->load->view('top_v');
			$this->load->view('users/mypage_v',$data);
			$this->load->view('bottom_v');
		}

	}
}