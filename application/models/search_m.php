<?PHP
/**
 * @author Jongwon Byun <blumine@paran.com>
 */

class Search_m extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->table = '';
    }

	//통합검색 기능추가 by emc (2009/08/19)
	function search_list($page, $rp, $post)
	{
		$field = " no, contents, subject, user_name, user_id, hit, voted_count, reply_count, reg_date ";
        $where = " WHERE (subject like \"%".$post['s_word']."%\" or contents like \"%".$post['s_word']."%\") and is_delete = 'N' and original_no = '0' ";

        $sql = "SELECT b.nickname, a.table, a.tbn, a.no, a.contents, a.subject, a.user_name, a.user_id, a.hit, a.voted_count, a.reply_count, a.reg_date from ( ";
        $sql.= "(SELECT 'CI 묻고 답하기' as 'table', 'qna' as 'tbn', ".$field." FROM board_qna ".$where.") UNION ";
        $sql.= "(SELECT 'TIP게시판'      as 'table', 'tip' as 'tbn', ".$field." FROM board_tip ".$where.") UNION ";
        $sql.= "(SELECT '강좌게시판' as 'table', 'lecture' as 'tbn', ".$field." FROM board_lecture ".$where.") UNION ";
        $sql.= "(SELECT 'CI 코드'     as 'table', 'source' as 'tbn', ".$field." FROM board_source ".$where.") UNION ";
        $sql.= "(SELECT 'CI 뉴스'       as 'table', 'news' as 'tbn', ".$field." FROM board_news ".$where.") UNION ";
        $sql.= "(SELECT '공지사항'    as 'table', 'notice' as 'tbn', ".$field." FROM board_notice ".$where.") UNION ";
        $sql.= "(SELECT '자유게시판'    as 'table', 'free' as 'tbn', ".$field." FROM board_free ".$where.") ";
        if($this->session->userdata('auth_code') >= '7'){
        	$sql.= " UNION (SELECT '개발자게시판'    as 'table', 'ci' as 'tbn', ".$field." FROM board_ci ".$where.") ";
    	}
        $sql.= " ) as a, users b where a.user_id=b.userid ";
        $sql.= "order by reg_date desc ";
		$sql.= 'limit '.$page.', '.$rp;
		//echo $sql; exit;
		$rs = $this->db->query($sql);
        return $rs->result_array();
	}

	//통합검색 기능추가 by emc (2009/08/19)
	function search_total($post)
	{

		//print_r($post);
		/*
		if ($post) {
			$this->db->like($post["method"], $post["s_word"]);
  		}
  		$this->db->where(array('is_delete'=>'N', 'original_no'=>'0'));

		$query = $this->db->get($this->table);
		*/

		$field = " no, contents, subject, user_name, user_id, hit, voted_count, reply_count, reg_date ";
        $where = " WHERE (subject like \"%".$post['s_word']."%\" or contents like \"%".$post['s_word']."%\") and is_delete = 'N' and original_no = '0' ";

        $sql = "SELECT b.nickname, a.table, a.tbn, a.no, a.contents, a.subject, a.user_name, a.user_id, a.hit, a.voted_count, a.reply_count, a.reg_date from ( ";
        $sql.= "(SELECT 'CI 묻고 답하기' as 'table', 'qna' as 'tbn', ".$field." FROM board_qna ".$where.") UNION ";
        $sql.= "(SELECT 'TIP게시판'      as 'table', 'tip' as 'tbn', ".$field." FROM board_tip ".$where.") UNION ";
        $sql.= "(SELECT '강좌게시판' as 'table', 'lecture' as 'tbn', ".$field." FROM board_lecture ".$where.") UNION ";
        $sql.= "(SELECT 'CI 코드'     as 'table', 'source' as 'tbn', ".$field." FROM board_source ".$where.") UNION ";
        $sql.= "(SELECT 'CI 뉴스'       as 'table', 'news' as 'tbn', ".$field." FROM board_news ".$where.") UNION ";
        $sql.= "(SELECT '공지사항'    as 'table', 'notice' as 'tbn', ".$field." FROM board_notice ".$where.") UNION ";
        $sql.= "(SELECT '자유게시판'    as 'table', 'free' as 'tbn', ".$field." FROM board_free ".$where.") ";
        if($this->session->userdata('auth_code') >= '7'){
        	$sql.= " UNION (SELECT '개발자게시판'    as 'table', 'ci' as 'tbn', ".$field." FROM board_ci ".$where.") ";
    	}
        $sql.= " ) as a, users b where a.user_id=b.userid ";
        $sql.= "order by reg_date desc ";

		$rs = $this->db->query($sql);
		//return $rs->result();

        return $rs->num_rows();
	}

	//자기글 기능추가 by 웅파 (2009/08/22)
	//emc님 작업 수정
	//페이지, 글갯수, 글쓴이 아이디, 원글-리플여부
	function my_list($page, $rp, $id, $reply)
	{
		if($reply == 'REPLY') {
			$res = " and original_no != '0' ";
		} else {
			$res = " and original_no = '0' ";
		}
		$field = " no, contents, subject, user_name, user_id, hit, voted_count, reply_count, reg_date, original_no ";
        $where = " WHERE user_id = '".$id."' and is_delete = 'N' ".$res;

        $sql = "SELECT a.original_no, b.nickname, a.table, a.tbn, a.no, a.contents, a.subject, a.user_name, a.user_id, a.hit, a.voted_count, a.reply_count, a.reg_date from ( ";
        $sql.= "(SELECT 'CI 묻고 답하기' as 'table', 'qna' as 'tbn', ".$field." FROM board_qna ".$where.") UNION ";
        $sql.= "(SELECT 'TIP게시판'      as 'table', 'tip' as 'tbn', ".$field." FROM board_tip ".$where.") UNION ";
        $sql.= "(SELECT '강좌게시판' as 'table', 'lecture' as 'tbn', ".$field." FROM board_lecture ".$where.") UNION ";
        $sql.= "(SELECT 'CI 코드'     as 'table', 'source' as 'tbn', ".$field." FROM board_source ".$where.") UNION ";
        $sql.= "(SELECT 'CI 뉴스'       as 'table', 'news' as 'tbn', ".$field." FROM board_news ".$where.") UNION ";
        $sql.= "(SELECT '공지사항'    as 'table', 'notice' as 'tbn', ".$field." FROM board_notice ".$where.") UNION ";
        $sql.= "(SELECT '자유게시판'    as 'table', 'free' as 'tbn', ".$field." FROM board_free ".$where.") ";
        if($this->session->userdata('auth_code') >= '7'){
        	$sql.= " UNION (SELECT '개발자게시판'    as 'table', 'ci' as 'tbn', ".$field." FROM board_ci ".$where.") ";
    	}
        $sql.= " ) as a, users b where a.user_id=b.userid ";
        $sql.= "order by reg_date desc ";
		$sql.= 'limit '.$page.', '.$rp;

		$rs = $this->db->query($sql);
        return $rs->result_array();
	}

	//자기글 기능추가 by 웅파 (2009/08/22)
	//emc님 작업 수정
	function my_total($id, $reply)
	{
		if($reply == 'REPLY') {
			$res = " and original_no != '0' ";
		} else {
			$res = " and original_no = '0' ";
		}
		$field = " no, contents, subject, user_name, user_id, hit, voted_count, reply_count, reg_date, original_no ";
         $where = " WHERE user_id = '".$id."' and is_delete = 'N' ".$res;

        $sql = "SELECT a.original_no, b.nickname, a.table, a.tbn, a.no, a.contents, a.subject, a.user_name, a.user_id, a.hit, a.voted_count, a.reply_count, a.reg_date from ( ";
        $sql.= "(SELECT 'CI 묻고 답하기' as 'table', 'qna' as 'tbn', ".$field." FROM board_qna ".$where.") UNION ";
        $sql.= "(SELECT 'TIP게시판'      as 'table', 'tip' as 'tbn', ".$field." FROM board_tip ".$where.") UNION ";
        $sql.= "(SELECT '강좌게시판' as 'table', 'lecture' as 'tbn', ".$field." FROM board_lecture ".$where.") UNION ";
        $sql.= "(SELECT 'CI 코드'     as 'table', 'source' as 'tbn', ".$field." FROM board_source ".$where.") UNION ";
        $sql.= "(SELECT 'CI 뉴스'       as 'table', 'news' as 'tbn', ".$field." FROM board_news ".$where.") UNION ";
        $sql.= "(SELECT '공지사항'    as 'table', 'notice' as 'tbn', ".$field." FROM board_notice ".$where.") UNION ";
        $sql.= "(SELECT '자유게시판'    as 'table', 'free' as 'tbn', ".$field." FROM board_free ".$where.") ";
        if($this->session->userdata('auth_code') >= '7'){
        	$sql.= " UNION (SELECT '개발자게시판'    as 'table', 'ci' as 'tbn', ".$field." FROM board_ci ".$where.") ";
    	}
        $sql.= " ) as a, users b where a.user_id=b.userid ";
        $sql.= "order by reg_date desc ";

		$rs = $this->db->query($sql);
		//return $rs->result();

        return $rs->num_rows();
	}
}

?>
