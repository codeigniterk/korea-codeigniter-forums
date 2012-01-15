<?php

class Lists extends Controller {

	function Lists()
	{
		parent::Controller();
		$this->output->enable_profiler(false);

	}

	function index()
	{
		$this->load->view('test');
	}

}