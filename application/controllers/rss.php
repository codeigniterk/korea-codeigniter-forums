<?php
class Rss extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('xml');
    }

    function index()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'cikorea.net';
        $data['feed_url'] = 'http://www.cikorea.net';
        $data['page_description'] = 'CodeIgniter 한국사용자포럼 ';
        $data['page_language'] = 'ko-kr';
        $data['creator_email'] = 'Jongwon Byun is at codeigniterk at gmail dot com';

		//data
		$this->db->cache_on();

		$sql  = "SELECT a.subject, a.table, a.tbn, a.no, a.original_no, a.contents, a.user_name, a.user_id, a.reg_date from ( ";
		$sql .= "(SELECT subject, 'CI 묻고 답하기' as 'table', 'qna' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_qna  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, 'TIP게시판'      as 'table', 'tip' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_tip  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, '강좌게시판' as 'table', 'lecture' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_lecture  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, 'CI 코드'     as 'table', 'source' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_source  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, 'CI 뉴스'       as 'table', 'news' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_news  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, '공지사항'    as 'table', 'notice' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_notice  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) UNION ";
		$sql .= "(SELECT subject, '자유게시판'    as 'table', 'free' as 'tbn', no, original_no, contents, user_name, user_id, reg_date FROM board_free  WHERE  is_delete = 'N' and original_no = '0' order by no desc limit 7 ) ";

		$sql .= ") as a  order by reg_date desc limit 30";

		$rs = $this->db->query($sql);

		$this->db->cache_off();
        $data['posts'] = $rs->result();
        header("Content-Type: application/rss+xml");
        $this->load->view('rss_v', $data);
    }
}
?>