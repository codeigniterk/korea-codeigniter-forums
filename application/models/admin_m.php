<?PHP
class Admin_m extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function id_check($id) //회원가입시 기존 아이디 유무 체크
    {
        $query = $this->db->get_where('users', array('userid' => $id));
        return $query->num_rows();
    }

	function nick_check($ju) //회원가입시 기존 닉네임 유무 체크
    {
        $query = $this->db->get_where('users', array('nickname' => $ju));
		return $query->num_rows();
    }

	function name_check($ju) //게시판 영문명 중복 체크
    {
        $query = $this->db->get_where('board_list', array('name_en' => 'board_'.$ju));
		return $query->num_rows();
    }

	function member_list($mode, $search_word, $offset, $per_page)
	{
		if( $search_word )
		{
			$search_qry = "and (userid like '%".$search_word."%' or username like '%".$search_word."%'  or nickname like '%".$search_word."%' or email like '%".$search_word."%' or auth_code like '%".$search_word."%') ";
		}
		else
		{
			$search_qry = "";
		}

		if($mode =='master')
		{
			$sse = "(auth_code = 'ADMIN') and ";
		}
		elseif($mode =='member')
		{
			$sse = "(auth_code = 'USER') and ";
		}
		else
		{
			$sse = "";
		}

		$sql = "SELECT id as user_no, auth_code, userid, nickname, email, username, created, last_ip, banned
		FROM users WHERE ".$sse." 1=1 ".$search_qry."
		ORDER BY id DESC limit ".$offset.", ".$per_page." ";

		$q=$this->db->query($sql);

		return $q->result_array();
	}

	function getTotalData($mode, $search_word, $offset, $per_page)
	{
		if( $search_word =='all_keyword' )
		{
			$search_qry = "";
		}
		else
		{
			$search_qry = "and (userid like '%".$search_word."%' or username like '%".$search_word."%'  or nickname like '%".$search_word."%' or email like '%".$search_word."%' or auth_code like '%".$search_word."%') ";
		}

		if($mode =='master')
		{
			$sse = "(auth_code = 'ADMIN') and ";
		}
		elseif($mode =='member')
		{
			$sse = "(auth_code = 'USER') and ";
		}
		else
		{
			$sse = "";
		}

		$sql = "SELECT id FROM users WHERE ".$sse." 1=1  ".$search_qry." ";
		$q=$this->db->query($sql);

		return $q->num_rows();
	}

	function master_add($post)
	{
		//tank_auth 비밀번호 생성
		require_once('application/libraries/phpass-0.1/PasswordHash.php');

		define('PHPASS_HASH_STRENGTH', 8);
		define('PHPASS_HASH_PORTABLE', FALSE);

		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$hashed_password = $hasher->HashPassword($post['user_pw']);

		$data = array(
				'userid' => $post['user_id'] ,
                'username' => $post['user_nm'] ,
				'password' => $hashed_password ,
                'email' => $post['user_email'],
				'nickname' => $post['user_nickname'],
				'auth_code' => $post['auth_type'],
				'created' =>  date("Y-m-d H:i:s")
            );
		$aa=$this->db->insert('users', $data);
		$user_nos= $this->db->insert_id();

		$data1 = array(
                'user_id' => $user_nos
            );
		$bb=$this->db->insert('user_profiles', $data1);

        return $aa;
	}

	//게시판 리스트
	function board_list($mode, $search_word, $offset, $per_page)
	{
		if( $search_word )
		{
			$search_qry = "and (name like '%".$search_word."%' or name_en like '%".$search_word."%') ";
		}
		else
		{
			$search_qry = "";
		}

		$sql = "SELECT * FROM board_list WHERE 1=1 ".$search_qry." ORDER BY no DESC limit ".$offset.", ".$per_page;

		$q=$this->db->query($sql);

		return $q->result_array();
	}

	function board_list_count($mode, $search_word, $offset, $per_page)
	{
		if( $search_word =='all_keyword' )
		{
			$search_qry = "";
		}
		else
		{
			$search_qry = "and (name like '%".$search_word."%' or name_en like '%".$search_word."%') ";
		}


		$sql = "SELECT no FROM board_list WHERE 1=1  ".$search_qry;

		$q=$this->db->query($sql);

		return $q->num_rows();
	}

	//게시판 추가
	function board_add($post)
	{
		$data = array(
				'name' => $post['name'] ,
                'name_en' => 'board_'.$post['name_en'] ,
				'enable' => $post['enable'] ,
                'permission' => $post['per1']."|".$post['per2']."|".$post['per3']."|".$post['per4'],
				'skin' => $post['skin'],
				'reg_date' =>  date("Y-m-d H:i:s")
            );
		$aa=$this->db->insert('board_list', $data);

        return $aa;
	}

}

?>
