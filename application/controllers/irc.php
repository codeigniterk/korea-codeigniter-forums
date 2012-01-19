<?php
/**
 * 커밋 테스트용
 */
class Irc extends Controller {
	function Irc() {
		parent::Controller();
	}

	function index() {
		$data['nickname'] = false;

		if ($this->session->userdata('userid')) {
			$this->db->select('nickname');
			$qry = $this->db->get_where('users', array('userid' => $this->session->userdata('userid')));
			$row = $qry->row_array();
			$nick=urlencode($row['nickname']);
			//echo $row['nickname'];
			$data['nickname'] = '&nick='.$nick;
			$this->load->view('top_v');
			$this->load->view('irc_v', $data);
			$this->load->view('bottom_v');
		} else {
			?>
			<script>
				alert('로그인후 이용하세요');
				location="/";
			</script>
			<?
		}

	}

	function prof() {
		echo $this->router->fetch_class()."/".$this->router->fetch_method();
	}

	function aaa()
	{
		$this->load->library('email');
		$client_email = 'blumine@naver.com';
		$client_name = '김개똥';
		$mail_to = 'blumine@naver.com';

		$this->email->from($client_email, $client_name);
		$this->email->to($mail_to);


		$this->email->subject('hello email');
		$this->email->message("<b>안녕</b><br />메렁~<br />");

		$this->email->send();
		echo $this->email->print_debugger();

	}

	function bb() {
		$query = $this->db->query("select * from users");

		echo $query->num_rows();
	}
}
?>