<?php

/**
 *
 * @copyright Copyright (c) 2009 ICMS Inc, Jongwon Byun
 * Created on 2009-04-01
 * @author Jongwon Byun <blumine@paran.com>
 * @version 1.0
 */
class Board_model extends Model {

    function Board_model()
    {
        // Call the Model constructor
        parent::Model();
		//$CI =& get_instance();
		$this->table=MENU_BOARD_NAME_EN;
		$this->file_table="files";
		$this->tag_table="tags";
    }

    function insert_board($post) //글 작성
	{
		if (@$post['fixed'] == 'on') {
			$fixed = "Y";
   		} else {
  			$fixed = "N";
       	}
       	if (@$post['secret'] == 'on') {
			$secret = "Y";
   		} else {
  			$secret = "N";
       	}
       	$general_setting = '';
       	$this_date = date("Y-m-d H:i:s");
       	//파일처리 루틴 필요
       	$file_count = '0';

		$data = array(
					'module_no' => MENU_ID,
					//'user_no' => $this->session->userdata('user_no'),
					'user_no' => '0',
					'user_id' => $this->session->userdata('userid'),
					'user_name' => $this->session->userdata('nickname'),
					'reg_date' => $this_date,
					'modify_date' => $this_date,
					'is_notice' => $fixed,
					'is_secret' => $secret,
					'subject' => $post['subject'],
					'general_setting' => $general_setting,
					'contents' => $post['contents'],
					'files_count' => $file_count,
					'download_count' => '0',
					'scrap_count' => '0',
					'hit' => '0',
					'trackback_count' => '0',
					'reply_count' => '0',
					'voted_count' => '0',
					'blamed_count' => '0',
					'ip' => $this->input->ip_address(),
					'password' => @$post['password']
				);
		//print_r($data);
		$this->db->insert($this->table, $data);
		$last_id = $this->db->insert_id();

		//운영자 게시판 내용 메일 발송
		if(MENU_ID == '10')
		{
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$config['priority'] = '1';
			$this->email->initialize($config);

			$this->email->from('info@cikorea.net', 'Codeigniter한국사용자포럼');
			$this->email->to('info@cikorea.net');

			$this->email->subject("[Codeigniter포럼 운영자게시판] ".$post['subject']);
			$e_content =
			"작성자 : ".$this->session->userdata('nickname')."<br>작성일 : ".$this_date." <br><BR>".$post['contents']."<BR><BR><a href='http://www.codeigniter-kr.org/su/view/".$last_id."' target='_blank'>게시글로 이동</a>";
			$this->email->message($e_content);

			$this->email->send();
		}

		//운영자 게시판이외의 내용 메일 발송
		if(MENU_ID != '10')
		{
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$config['priority'] = '1';
			$this->email->initialize($config);

			$this->email->from('info@cikorea.net', 'Codeigniter한국사용자포럼');
			$this->email->to('info@cikorea.net');

			$this->email->subject("[Codeigniter포럼 ".MENU_BOARD_NAME."] ".$post['subject']);

			$str_len = strlen(MENU_BOARD_NAME_EN);
			$table = substr(MENU_BOARD_NAME_EN, 6, $str_len);

			$e_content =
			"작성자 : ".$this->session->userdata('nickname')."<br>작성일 : ".$this_date." <br><BR>".$post['contents']."<BR><BR><a href='http://www.codeigniter-kr.org/".$table."/view/".$last_id."' target='_blank'>게시글로 이동</a>";
			$this->email->message($e_content);

			$this->email->send();
		}

		//태그처리
       	if ($post['tags']) {
       		$tag_arr = explode(",", $post['tags']);
       		$cnt = count($tag_arr);
       		for ($i=0; $i < $cnt; $i++) {
       			$tagss=array(
       						'module_name'=> $this->table,
       						'parent_no'=>$last_id,
       						'tag_name'=>trim($tag_arr[$i]),
       						'reg_date'=>$this_date
				   			);
         		$this->db->insert($this->tag_table, $tagss);
         }

        }
        //첨부파일 DB 입력
		$file_cnt = $this->common->strip_image_tags_fck($post['contents'], $last_id, '', $this->table, MENU_ID); //글내용, 게시글번호, 타입(있으면 리플, 테이블명, 테이블번호)

		//파일갯수 업데이트
		$data_file = array(
               'files_count ' => $file_cnt
            );
  		$this->db->where('no', $last_id);
		$this->db->update($this->table, $data_file);

        return $last_id;
	}

	function update_board($no, $post) //글 수정
	{
       	if (@$post['fixed'] == 'on') {
			$fixed = "Y";
   		} else {
  			$fixed = "N";
       	}
       	if (@$post['secret'] == 'on') {
			$secret = "Y";
   		} else {
  			$secret = "N";
       	}
       	$general_setting = '';
       	$this_date = date("Y-m-d H:i:s");

		if(@$post['subject']) {
			$data = array(
						'modify_date' => $this_date,
						'is_notice' => $fixed,
						'is_secret' => $secret,
						'subject' => $post['subject'],
						'general_setting' => $general_setting,
						'contents' => $post['contents'],
						'ip' => $this->input->ip_address(),
						'password' => @$post['password']
			);
		} else {
			$data = array(
						'modify_date' => $this_date,
						'is_notice' => $fixed,
						'is_secret' => $secret,
						'general_setting' => $general_setting,
						'contents' => $post['contents'],
						'ip' => $this->input->ip_address(),
						'password' => @$post['password']
			);
		}
		$this->db->where('no', $no);
		$this->db->update($this->table, $data);

		//태그처리
		if (@$post['tags']) {
       		$this->db->delete($this->tag_table, array('parent_no'=>$no, 'module_name'=>$this->table));
       		$tag_arr = explode(",", $post['tags']);
       		$cnt = count($tag_arr);
       		for ($i=0; $i < $cnt; $i++) {
       			$tagss=array(
       						'module_name'=> $this->table,
							'module_type'=> 'reply',
       						'parent_no'=> $no,
       						'tag_name'=> trim($tag_arr[$i]),
       						'reg_date'=> $this_date
				   			);
         		$this->db->insert($this->tag_table, $tagss);
         }

        }
        //첨부파일 DB 입력
		$file_cnt = $this->strip_image_tags_edit($post['contents'], $no, ''); //글내용, 게시글번호, 타입(있으면 리플)

		//기존 파일 갯수
		$qur = $this->db->get_where($this->table, array('no'=>$no));
		$rows = $qur->row();
		$file_cnt = $file_cnt+$rows->files_count;

		//파일갯수 업데이트
		$data_file = array(
               'files_count ' => $file_cnt
            );
  		$this->db->where('no', $no);
		$this->db->update($this->table, $data_file);

	}

	function strip_image_tags_edit($str, $no, $type)
	{
		//기존 db내용 삭제
      	$this->db->delete($this->file_table, array('module_no'=>$no, 'module_name'=>$this->table, 'file_type'=>'', 'original_name'=>''));
		preg_match_all("<img [^<>]*>", $str, $out, PREG_PATTERN_ORDER);
		$strs = $out[0];

		$cnt = count($strs);
		for ($i=0;$i<$cnt;$i++) {
  			$arr = preg_replace("#img\s+.*?src\s*=\s*[\"']\s*\/data/images/\s*(.+?)[\"'].*?\/#", "\\1", $strs[$i]);
			$data = array(
			  			'module_id'=> MENU_ID,
						'module_name'=> $this->table,
						'module_no'=>$no,
						'module_type'=>$type,
						'file_name'=>$arr,
  						'reg_date'=>date("Y-m-d H:i:s")
			  			);
			if ( count($arr) <= 25 ) {
				$this->db->insert($this->file_table, $data);
			}
  		}

  		return $cnt;
	}

	function file_list($no)
	{
		$this->db->not_like('file_name','gif');
		$this->db->not_like('file_name','jpg');
		$this->db->not_like('file_name','bmp');
		$this->db->not_like('file_name','png');
		$this->db->not_like('file_name','jpeg');
		$query=$this->db->get_where($this->file_table, array('module_name'=>$this->table, 'module_no'=>$no));

		return $query->result_array();
	}

	function load_list($page, $rp, $post, $table)
	{
		$where = "";
		$this->db->select($table.'.user_name, '.$table.'.subject, '.$table.'.no,'.$table.'.hit, '.$table.'.voted_count,  '.$table.'.contents, '.$table.'.reg_date, '.$table.'.reply_count, files.file_name');
		$this->db->order_by($table.'.red_date', 'desc');
		$this->db->group_by($table.'.no');
		$this->db->limit($rp, $page);
		if ($post) {
			if($post['method'] == 'all') {
//				$this->db->like('subject', $post['s_word']);
//				$this->db->or_like('contents', $post['s_word']);
				$where = "(subject like '%".$post['s_word']."%' or contents like '%".$post['s_word']."%') and ";
			} else {
				$this->db->like($post['method'], $post['s_word']);
				$where = "";
			}
  		}
  		$this->db->join('files', 'files.module_no='.$table.'.no', 'left');
		//$this->db->join('users', 'users.userid='.$table.'.user_id', 'left');
		$where .= "(".$table.".is_delete='N' and ".$table.".original_no='0')";
  		$this->db->where($where);

		$query = $this->db->get($table);

        return $query->result_array();
	}

	function load_list_total($post, $table)
	{
		$this->db->select('count(no) as cnt');
		$where = "";
		if ($post) {
			if($post['method'] == 'all') {
				//$this->db->like('subject', $post['s_word']);
				//$this->db->or_like('contents', $post['s_word']);
				$where = "(subject like '%".$post['s_word']."%' or contents like '%".$post['s_word']."%') and ";
			} else {
				$this->db->like($post['method'], $post['s_word']);
				$where = "";
			}
  		}
		//$this->db->join('users', 'users.userid='.$table.'.user_id', 'left');
		$where .= "(is_delete='N' and original_no='0')";
  		$this->db->where($where);

		$query = $this->db->get($this->table);

        //return $query->num_rows();
		//var_dump($query->row());
		return $query->row();
	}

	function load_config($no)
	{
		$this->db->select("detail_setting");
		$query = $this->db->get_where('board_list', array('no' => $no, 'admin_no' => ADMIN_NO));
		$result = $query->row_array();
		$d_set = unserialize($result["detail_setting"]);

		return $d_set;
	}

	function board_tag($no, $m_no) //태그 가져오기
	{
		$this->db->select('tag_name');
		$this->db->order_by('no', 'asc');
		$query = $this->db->get_where($this->tag_table, array('parent_no' => $no, 'module_name' => $m_no));
		$row = $query->result_array();
		$result = '';
		foreach ( $row as $val ) {
       		$result .= $val['tag_name'].", ";
		}
		$result = rtrim($result, ', ');
		return $result;
	}

	function board_view($no, $mode) //게시물 가져오기
	{
		if ($mode == 'view') {
			$sql = "update `".$this->table."` set hit=hit+1 where no = '".$no."' ";
			$this->db->query($sql);
  		}
		//$this->db->select($this->table.'.*, users.nickname, users.username');
		$this->db->select($this->table.'.*');
		//$this->db->join('users', 'users.userid='.$this->table.'.user_id', 'left');
		if ($mode != 'edit') {
			$this->db->where('original_no', '0');
		}
		$query = $this->db->get_where($this->table, array('no' => $no, 'is_delete' => 'N'));

        return $query->row_array();
	}

	function id_check($no) //게시물 아이디 반환
	{
		$this->db->select('user_id');
		$query = $this->db->get_where($this->table, array('no' => $no));

        return $query->row_array();
	}

	function delete_post($no) //게시물 삭제
	{
		$data = array('is_delete' => 'Y');
		$this->db->where('no', $no);
		$this->db->or_where('original_no', $no);
		$query = $this->db->update($this->table, $data);
	}

	function reply_view($no)
	{
		$this->db->select($this->table.'.*, users.nickname, users.username');
		$this->db->order_by('no', 'asc');
		$this->db->join('users', 'users.userid='.$this->table.'.user_id', 'left');
		$query = $this->db->get_where($this->table, array('original_no'=>$no, 'is_delete'=>'N'));

        return $query->result_array();
	}

	function bottom_low($no)
	{
 		$prev_no = $this->db->query("
		 (Select MIN(no) as pn from `".$this->table."`  where no > '".$no."'  and is_delete = 'N' and original_no ='0')
union	(Select MAX(no) as nn from `".$this->table."`  where no < '".$no."' and is_delete = 'N' and original_no ='0')");
 		$prev = $prev_no->result();
 		return $prev;
 	}


	function auto_link($str)
	{

		// 속도 향상 031011
		$str = preg_replace("/&lt;/", "\t_lt_\t", $str);
		$str = preg_replace("/&gt;/", "\t_gt_\t", $str);
		$str = preg_replace("/&amp;/", "&", $str);
		$str = preg_replace("/&quot;/", "\"", $str);
		$str = preg_replace("/&nbsp;/", "\t_nbsp_\t", $str);
		$str = preg_replace("/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='_blank'><font color=blue><u>\\2</u></font></A>", $str);
		$str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'><font color=blue><u>\\2</u></font></A>", $str);
		// 이메일 정규표현식 수정 061004
		//$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
		$str = preg_replace("/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str);
		$str = preg_replace("/\t_nbsp_\t/", "&nbsp;" , $str);
		$str = preg_replace("/\t_lt_\t/", "&lt;", $str);
		$str = preg_replace("/\t_gt_\t/", "&gt;", $str);

		return $str;
	}

	function board_move($scBoard, $tgBoard, $scNo)
	{
		// 본문 게시물 이동용 SQL
		$sql =	"INSERT INTO {$tgBoard} ( " .
			"`division`, `module_no`, `user_no`, `user_id`, `user_name`, " .
			"`reg_date`, `modify_date`, `is_notice`, `is_secret`, `subject`, " .
			"`general_setting`, `contents`, `files_count`, `download_count`, `scrap_count`, " .
			"`hit`, `trackback_count`, `reply_count`, `voted_count`, `blamed_count`, " .
			"`ip`, `is_delete`,`password`) " .
			"select  " .
			"`division`, `module_no`, `user_no`, `user_id`, `user_name`, " .
			"`reg_date`, `modify_date`, `is_notice`, `is_secret`, `subject`, " .
			"`general_setting`, `contents`, `files_count`, `download_count`, `scrap_count`, " .
			"`hit`, `trackback_count`, `reply_count`, `voted_count`, `blamed_count`, " .
			"`ip`, `is_delete`, `password`  " .
			"from {$scBoard}  " .
			"where `no` = '{$scNo}' ";
		$this->db->query($sql);
		$tgNo = $this->db->insert_id();

		// 본문 게시물 이동용 SQL
		$sql = "INSERT INTO {$tgBoard} ( `original_no`,  " .
			"`division`, `module_no`, `user_no`, `user_id`, `user_name`, " .
			"`reg_date`, `modify_date`, `is_notice`, `is_secret`, `subject`, " .
			"`general_setting`, `contents`, `files_count`, `download_count`, `scrap_count`, " .
			"`hit`, `trackback_count`, `reply_count`, `voted_count`, `blamed_count`, " .
			"`ip`, `is_delete`,`password`) " .
			"select '{$tgNo}',  " .
			"`division`, `module_no`, `user_no`, `user_id`, `user_name`, " .
			"`reg_date`, `modify_date`, `is_notice`, `is_secret`, `subject`, " .
			"`general_setting`, `contents`, `files_count`, `download_count`, `scrap_count`, " .
			"`hit`, `trackback_count`, `reply_count`, `voted_count`, `blamed_count`, " .
			"`ip`, `is_delete`, `password`  " .
			"from {$scBoard}  " .
			"where `original_no` = '{$scNo}' ";

		$this->db->query($sql);

		// 본문 게시물 삭제
		$this->delete_post($scNo);
	}
}
/* End of file Functions.php */
/* Location: ./plugins/board/model/board_model.php */