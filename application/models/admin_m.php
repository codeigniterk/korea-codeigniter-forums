<?PHP
class Admin_m extends Model {

    function Admin_m()
    {
        // Call the Model constructor
        parent::Model();
    }

	function log_write($sql_log) { //로그 저장
	$log_file = DOC_ROOT."/log/admin_log_".date("Ymd", mktime()).".log"; // log 파일설정
	$sql_log = $this->uri->uri_string()." : ".date("Y-m-d H:i:s", mktime())." : ".$this->session->userdata('user_id')." : ".$this->input->ip_address()." \n\r\t".$sql_log."\n\r\n\r";
	@error_log($sql_log, 3, $log_file); // log 저장
	}

	function auth_check($auth_code) { //운영자코드 배열로 반환
		$sql=explode("|", $auth_code);
		$cnt=count($sql);

		if( $cnt > 1 ) {
			if( in_array("AD", $sql) ){
				define("TMENULIST", '<ul id="agnb_sub"><li><a href="" target="_self" onfocus=this.blur();>사이트관리</a></li><li><a href="" target="_self" onfocus=this.blur();>사이트설정</a></li></ul>');
			} else {
				define("TMENULIST", '<ul id="agnb_sub"><li><a href="/admin/members/master" target="_self" onfocus=this.blur();>운영자 관리</a></li></ul>');
			}
			return $sql;
		} else {
			return array($auth_code);
		}
	}

	function id_check($id) //회원가입시 기존 아이디 유무 체크
    {
        $query = $this->db->get_where('users', array('user_id' => $id));
        return $query->num_rows();
    }


	function nick_check($ju) //회원가입시 기존 닉네임 유무 체크
    {
        $query = $this->db->get_where('users', array('nickname' => $ju));
		return $query->num_rows();
    }

	function register($parent_seq, $category_name, $order_by, $order_by_before, $table)
	{
		$order_by = $order_by;
		$this->order_by($order_by, $order_by_before, $table,$parent_seq);
		$query	=	"insert into ".$table."
								set parent_seq='".$parent_seq."',
								category_name='".$category_name."',
								order_by='$order_by' ";
		$this->log_write($query);
		$this->db->query($query);
	}

	function modify($class_seq, $category_name, $order_by, $order_by_before, $table,$parent_seq)
	{
		$order_by = $order_by;
		$this->order_by($order_by, $order_by_before, $table,$parent_seq);

		$query	=	"update ".$table."
								set category_name='".$category_name."',
									order_by='$order_by'
								where no='".$class_seq."' limit 1";
		$this->log_write($query);
		$rs = $this->db->query($query);
	}

	function deletion($class_seq, $category_name, $order_by, $order_by_before, $table,$parent_seq)
	{
		$query2	=	"select no from ".$table." where parent_seq='".$class_seq."'";
		$qsd=$this->db->query($query2);
		//show_error($qsd->num_rows());
		if($qsd->num_rows() == '0' or $qsd->num_rows() == '')
		{
			$query	=	"delete from ".$table." where no='".$class_seq."' limit 1";
			$this->log_write($query);
			$rs = $this->db->query($query);

			$this->order_by("", $order_by_before, $table,$parent_seq);
		}
		else {
			echo "<script>alert('하위분류가 존재합니다. 삭제하려면 하위분류를 먼저 삭제 후 삭제해주세요.');</script>";
		}
	}

	function order_by($order_by="", $order_by_before="", $table,$parent_seq)
	{
		if($order_by!=$order_by_before) {
			if($order_by_before!="") {
				$query	=	"update ".$table."
										set order_by=order_by-1
										where order_by > '".$order_by_before."' and parent_seq='".$parent_seq."'";
				$this->log_write($query);
				$rs = $this->db->query($query);
			}

			if($order_by!="") {
				$query	=	"update ".$table."
										set order_by=order_by+1
										where order_by >= '".$order_by."' and parent_seq='".$parent_seq."'";
				$this->log_write($query);
				$rs = $this->db->query($query);
			}
		}
	}

	function master_list($mode, $search_word, $offset, $per_page) {
		if( $search_word ) {
			$search_qry = "and (userid like '%".$search_word."%' or username like '%".$search_word."%'  or nickname like '%".$search_word."%' or email like '%".$search_word."%') ";
		} else {
			$search_qry = "";
		}
		if($mode =='master') {
			$sse = "(auth_code = 'ADMIN') and ";
		} elseif($mode =='member') {
			$sse = "(auth_code = 'USER') and ";
		} else {
			$sse = "";
		}
		$sql = "SELECT id as user_no, auth_code, userid, nickname, email, username, created, last_ip
		FROM users WHERE ".$sse." 1=1 ".$search_qry."
		ORDER BY id DESC limit ".$offset.", ".$per_page." ";

		$q=$this->db->query($sql);
		return $q->RESULT_ARRAY();
	}

	function getTotalData($mode, $search_word, $offset, $per_page) {
		if( $search_word =='all_keyword' ) {
			$search_qry = "";
		} else {
			$search_qry = "and (userid like '%".$search_word."%' or username like '%".$search_word."%'  or nickname like '%".$search_word."%' or email like '%".$search_word."%') ";
		}
		if($mode =='master') {
			$sse = "(auth_code = 'ADMIN') and ";
		} elseif($mode =='member') {
			$sse = "(auth_code = 'USER') and ";
		} else {
			$sse = "";
		}
		$sql = "SELECT id FROM users WHERE ".$sse." 1=1  ".$search_qry." ";

		$q=$this->db->query($sql);
		return $q->num_rows();
	}

	function insert_auth($id, $code) {
		$sql = "INSERT INTO auth
				SET user_id = '".$id."',
					code = '".$code."',
					enabled = 'Y',
					reg_date = now()";
		$this->log_write($sql);
		$q=$this->db->query($sql);
	}

	function member_list($search_word, $offset, $per_page) {
		if( $search_word ) {
			$search_qry = "and (us.user_id like '%".$search_word."%' or us.user_nm like '%".$search_word."%'  or us.user_email like '%".$search_word."%'  or us.user_hp like '%".$search_word."%') ";
		} else {
			$search_qry = "";
		}
		$sql = "SELECT us.*
		FROM user us JOIN user_dtl usd ON (usd.user_id = us.user_id) WHERE 1=1 ".$search_qry."
		ORDER BY us.user_seq desc limit ".$offset.", ".$per_page." ";
		//$this->log_write($sql);
		$q=$this->db->query($sql);
		return $q->RESULT_ARRAY();
	}

	function master_add($post) {
		//print_r($post);
		if (@!$post['tel']) $post['tel'] = '';
		if (@!$post['hp']) {
			$post['hp'] = '';
		} else	{
			$post['hp'] = str_replace("-", "", $post['hp']);
		}
		if (@!$post['user_email']) {
			$post['user_email'] = '@';
		}

		$emails = explode("@", $post['user_email']);

		$data = array(
                'admin_id' => $post['user_id'] ,
				'user_id' => $post['user_id'] ,
                'name' => $post['user_nm'] ,
				'password' => md5($post['user_pw']) ,
                'email_id' => $emails[0],
				'email_host' => $emails[1],
				'hp' => $post['hp'],
				'tel' => $post['tel'],
				'nickname' => $post['user_nickname'],
				'auth_code' => "AD|",
				'auth_code_date' =>  date("Y-m-d H:i:s"),
				'user_change_date' => date("Y-m-d H:i:s")
            );
		$aa=$this->db->insert('users', $data);
		$user_nos= $this->db->insert_id();

		$data1 = array(
                'user_no' => $user_nos ,
                'join_ip' => $_SERVER['REMOTE_ADDR'] ,
				'join_date' => date("Y-m-d H:i:s")
            );
		$bb=$this->db->insert('users_detail', $data1);
		//print_r($data);

		$data2 = array(
                'admin_no' => $user_nos ,
                'domain' => $post['site_domain']
            );
		$cc=$this->db->insert('site_admin', $data2);

        return $aa+$bb+$cc;

	}

	function detail_view($no) { //회원정보 상세보기
		$sql = "SELECT us.*
		FROM users us
		WHERE 1=1 and us.id='".$no."' ";
		//echo $sql;
		$q=$this->db->query($sql);
		$this->log_write($sql);

		return $q->row();
	}

	function member_getTotalData($search_word, $offset, $per_page) {
		if( $search_word =='all_keyword' ) {
			$search_qry = "";
		} else {
			$search_qry = "and (us.user_id like '%".$search_word."%' or us.user_nm like '%".$search_word."%'  or us.user_email like '%".$search_word."%'  or us.user_hp like '%".$search_word."%') ";
		}
		$sql = "SELECT us.user_id
		FROM user us JOIN user_dtl usd ON (usd.user_id = us.user_id) WHERE 1=1 ".$search_qry." ";
		//echo $sql;
		$q=$this->db->query($sql);
		return $q->num_rows();
	}

	function member_view($id) {
		$sql = "SELECT us.*, usd.user_homepage, usd.user_remote_addr ,usd.primary_entrance  ,usd.primary_graduate , usd.primary_name  ,usd.middle_entrance ,usd.middle_graduate ,usd.middle_name ,usd.high_entrance ,usd.high_graduate ,usd.high_name ,usd.university_entrance ,usd.university_graduate ,usd.university_name,usd.graduate_entrance ,usd.graduate_graduate ,usd.graduate_name,usd.job,usd.interest,usd.user_files_name,usd.user_files_name_org,usd.user_note, usp.concern, usp.latitude, usp.longitude, usf.user_name as member_photo, (select usl.login_dt from user_login usl where usl.user_id = us.user_id order by usl.login_dt desc limit 1) as login_dt
		FROM user us
		JOIN user_dtl usd ON (usd.user_id = us.user_id)
		JOIN user_profile usp ON (usp.user_id = us.user_id)
		LEFT JOIN user_files usf ON (usf.user_id = us.user_id)
		WHERE 1=1 and us.user_seq='".$id."' ";
		//echo $sql;
		$q=$this->db->query($sql);
		$this->log_write($sql);

		return $q->row();
	}

	function log_list($id, $offset, $per_page) {
		$sql = "SELECT login_dt, remote_ip
		FROM user_login WHERE user_id='".$id."'
		ORDER BY login_dt desc limit ".$offset.", ".$per_page." ";
		//echo $sql;
		$this->log_write($sql);
		$q=$this->db->query($sql);
		return $q->result_array();
	}

	function log_TotalData($id) {
		$sql = "SELECT login_dt, remote_ip
		FROM user_login WHERE user_id='".$id."'
		";
		$q=$this->db->query($sql);
		return $q->num_rows();
	}

	function ts(){
		return "dddd";
	}


}

?>
