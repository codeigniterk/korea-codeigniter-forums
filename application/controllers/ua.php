<?php

class Ua extends Controller {

	function Ua()
	{
		parent::Controller();

	}

	function index()
	{
		$table = 'board_tip';
		$this->db->select('no, user_name');
		//$qus = $this->db->get($table);
		foreach ($qus->result() as $res){
			echo $res->no."-".$res->user_name."<br>";

			$this->db->select('nickname');
			$this->db->where('username', $res->user_name);
			$qus = $this->db->get('users');
			$ncik = $qus->row();
			echo @$ncik->nickname."--<BR>";

			//$this->db->where('user_name', $res->user_name);

			//$this->db->update($table, array('user_name'=>@$ncik->nickname));
		}
	}


}