<?php
class Login_m extends CI_Model {

    var $query   = '';
	var $arr   = '';
	var $row   = array();

    function __construct()
    {
        parent::__construct();
    }

    function id_check($id) //회원가입시 기존 아이디 유무 체크
    {
        $query = $this->db->get_where('users', array('user_id' => $id));
        return $query->num_rows();
    }

	function member_check($id, $pass) // 로그인 체크
    {
		$arr = array('user_id' => $id, 'password'=> $pass);
		$this->db->where($arr);
		$query = $this->db->get('users');
		if($query->num_rows() == '0' or $query->num_rows() == '') {
			$query2 = $this->db->get_where('users', array('user_id' => $id));
			$arr1 = $query2->num_rows();
			if($arr1 == '1') {
				$mem_result = '비밀번호가 틀립니다.';
			} else {
				$mem_result = '아이디가 틀립니다.';
			}
		} else {
			$mem_result = 1;
		}
        return $mem_result;
    }

	function make_session($id, $pass, $refer) //로그인후 세션 생성
    {
		$this->db->select("users.no as user_no, users.admin_id, (select u.no from users as u where u.admin_id = users.admin_id and u.user_id = users.admin_id) as admin_no, users.auth_code, users.user_id, users.name, users.email_id, email_host, users.hp, users.nickname");
		$this->db->from('users');
		$arr = array('users.user_id' => $id, 'users.password'=> $pass);
		$this->db->where($arr);
		$query = $this->db->get();

		$rowss=$query->row();
		$row_arr = array("user_id"=>$rowss->user_id,
			"admin_id"=>$rowss->admin_id,
			"admin_no"=>$rowss->admin_no,
			"auth_code"=>$rowss->auth_code,
			"user_no"=>$rowss->user_no,
			"name"=>$rowss->name,
			"email_id"=>$rowss->email_id,
			"email_host"=>$rowss->email_host,
			"hp"=>$rowss->hp,
			"nickname"=>$rowss->nickname
			);
		$this->session->set_userdata($row_arr);

		//로그인 로그
		$refer_decode = base64_decode($refer);
		$dat_arr = array(
			'user_no'=> $this->session->userdata('user_no'),
			'admin_id'=> $this->session->userdata('admin_id'),
			'ip' => $this->input->ip_address(),
			'where_1' => $refer_decode,
			'login_date'=>date("Y-m-d H:i:s")
		);
		$login_table=$this->session->userdata('admin_id')."_users_logins";
		if($rowss->auth_code != 'SA|') {
			$this->db->insert($login_table, $dat_arr);
		}
    }


}
?>
