<?php

class Action extends CI_Controller {

	function __constructu()
	{
		parent::__constructu();
	}

	function index()
	{
		$post = $this->input->post(NULL, TRUE);
		$general_setting = '';
		$this_date = date("Y-m-d H:i:s");
		$this->table = $post['table'];
		$this->module_no = $post['module_no'];

		if ($this->session->userdata('userid'))
		{
			$data = array(
						'module_no' => $post['module_no'],
						'original_no' => $post['no'],
						'user_no' => $this->session->userdata('user_no'),
						'user_id' => $this->session->userdata('userid'),
						'user_name' => $this->session->userdata('username'),
						'reg_date' => $this_date,
						'modify_date' => $this_date,
						'is_notice' => 'N',
						'is_secret' => 'N',
						'contents' => $post['contents'],
						'files_count' => '0',
						'download_count' => '0',
						'scrap_count' => '0',
						'hit' => '0',
						'trackback_count' => '0',
						'reply_count' => '0',
						'voted_count' => '0',
						'blamed_count' => '0',
						'ip' => $this->input->ip_address(),
						'is_secret' => 'N'
					);
			$this->db->insert($post['table'], $data);
			$last_id = $this->db->insert_id();

			//리플갯수 업데이트
			$sql = "update `".$post['table']."` set reply_count=reply_count+1 where no = '".$post['no']."' ";
			$this->db->query($sql);


			//첨부파일 DB 입력
			$file_cnt = $this->strip_image_tags_fck($post['contents'], $last_id, 'reply'); //글내용, 게시글번호, 타입(있으면 리플)

			//파일갯수 업데이트
			$data_file = array(
				   'files_count ' => $file_cnt
				);
			$this->db->where('no', $last_id);
			$this->db->update($post['table'], $data_file);
		} //세션이 없을 경우 글 입력은 안하고 기존 리플내용만 반환

		//리플 내용 반환
		$this->db->select($post['table'].'.*, users.nickname');
		$this->db->order_by('reg_date', 'asc');
		$this->db->join('users', 'users.userid='.$this->table.'.user_id', 'left');
        $qer=$this->db->get_where($post['table'], array('original_no'=>$post['no'], 'is_delete'=>'N'));

?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/include/css/jquery-ui-1.7.2.custom.css" />
		<script>
		function reply_delete(board_id,row_no,views_no){
			$(function(){
				$.ajax({
					type: "POST",
					url: "/action/delete",
					data: {
						"board_id" : board_id,
						"row_no" : row_no,
						"views_no" : views_no
					},
					success : function(data,status){
						if(data == "1")
							document.location.reload();
							//$('#row_num_'+row_no).remove();
						else
							alert(data);
					}
				});
			});
		}
		function reply_edit(r_no, url1, url2){
			$(function(){
				jQuery.FrameDialog
				.create({
					url: url1+r_no+url2,
					title: '댓글 수정',
					width : 800,
					height : 450,
					draggable : false,
					resizable : false,
					buttons: { "닫기": function() { $(this).dialog("close"); } }
				})
			});
		}
		</script>
        <table border=0 cellpadding=0 cellspacing=0 width=100% style="margin-top:15px;">
		<tr>
			<td height=1 colspan=3 bgcolor="#dddddd"><td>
		</tr>
<?php
foreach ($qer->result_array() as $row)
{
?>
		<tr id="row_num_<?php echo $row['no']?>">
		<td>
			<table border=0 cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td height=5 colspan=2></td>
			</tr>
			<tr id="row_2_<?php echo $row['no']?>">
			<td valign=top style="padding-left:10px;">
				<div style="height:28px; line-height:20px;">
					<div style="float:left; margin:0px 0 0 2px;">
					<strong><?php echo ($row['nickname'])?$row['nickname']:$row['user_name']?></strong>
					<span style="color:#888888; font-size:11px;"><?php echo $row['reg_date']?></span>
					</div>
					<div style="float:right;">
					&nbsp;<span style="color:#B2B2B2; font-size:11px;"><!--?=$row['ip']?--></span>&nbsp;
<?php
	if($row['user_no'] == $this->session->userdata('user_no'))
	{
?>
					<a href="javascript:reply_edit('<?php echo $row['no']?>','<?php echo $post['url1']?>','<?php echo $post['url2']?>');"><img src="/images/co_btn_modify.gif" align="absmiddle"></a> <a href="javascript:reply_delete('<?php echo $post['table']?>','<?php echo $row['no']?>','<?php echo $post['no']?>');" onclick="return confirm(&quot;삭제하시겠습니까?&quot;)"><img src="/images/co_btn_delete.gif" align="absmiddle"></a>
<?php
	}
?>
					</div>
				</div>
				<div style='line-height:14px; padding:7px; word-break:break-all; overflow:hidden; clear:both; text-align:left; '>
					<?php echo $row['contents']?>
				</div>
			</td>
			</tr>
			<tr>
				<td height=5 colspan=3></td>
			</tr>
			<tr>
				<td height=1 colspan=3 bgcolor="#dddddd"><td>
			</tr>
<?php
}
?>
			</table>
		</td>
		</tr>
<?php
		$this->db->cache_delete('default', 'index');
	}

	function delete()
	{

		$u_no=$this->db->get_where($this->input->post("board_id", true), array('no'=>$this->input->post("row_no", true)));
		$row=$u_no->row();

		if($row->user_id == $this->session->userdata('userid'))
		{
			$data = array('is_delete' => 'Y');
			$this->db->where('no', $this->input->post("row_no"));
			$this->db->update($this->input->post("board_id"), $data);

			//리플갯수 업데이트
			$sql = "update `".$this->input->post("board_id")."` set reply_count=reply_count-1 where no = '".$this->input->post("views_no")."' ";
				echo ($this->db->query($sql));
		}
		else
		{
			echo "본인이 작성할 글만 삭제할수 있습니다.";
		}

		$this->db->cache_delete('default', 'index');
	}

	function strip_image_tags_fck($str, $no, $type)
	{
		$file_table="files";
		preg_match_all("<img [^<>]*>", $str, $out, PREG_PATTERN_ORDER);
		$strs = $out[0];

		$cnt = count($strs);
		for ($i=0;$i<$cnt;$i++)
		{
  			$arr = preg_replace("#img\s+.*?src\s*=\s*[\"']\s*\/data/images/\s*(.+?)[\"'].*?\/#", "\\1", $strs[$i]);
  			$data = array(
			  			'module_id'=> $this->module_no,
						'module_name'=> $this->table,
						'module_no'=>$no,
						'module_type'=>$type,
						'file_name'=>$arr,
  						'reg_date'=>date("Y-m-d H:i:s")
			  			);
			if ( count($arr) <= 25 )
			{
				$this->db->insert($file_table, $data);
			}
  		}
		return $cnt;
	}

	/**
	 * 추천
	 * @return recommend_cnt
	 */
	function recommend()
	{
		$no = $this->input->post('no', true);
		$table = $this->input->post('table', true);

		if ( $_POST['mode'] == 'recommend')
		{
			$sql1 = "update `".$_POST['table']."` set voted_count=voted_count+1 where no='".$no."'";
			$this->db->query($sql1);
			$this->db->select('voted_count');
			$res = $this->db->get_where($table, array('no'=>$no));
			$cnt = $res->row();
			echo $cnt->voted_count;
		}
		elseif ( $_POST['mode'] == 'blamed' )
		{
			$sql1 = "update `".$_POST['table']."` set blamed_count=blamed_count+1 where no='".$no."'";
			$this->db->query($sql1);
			$this->db->select('blamed_count');
			$res = $this->db->get_where($table, array('no'=>$no));
			$cnt = $res->row();
			echo $cnt->blamed_count;
		}
	}

	function file_delete()
	{
		$module_no = $this->input->post('module_no', true);
		$table = $this->input->post('table', true);
		$file_table = $this->input->post('file_table', true);

		$u_no=$this->db->get_where($table, array('no'=>$module_no));
		$row=$u_no->row();

		if($row->user_id == $this->session->userdata('userid'))
		{
			$this->db->delete($file_table, array('module_name' => $table, 'module_no' => $module_no));
			echo "1";
		}
		else
		{
			echo "2";
		}

	}
}