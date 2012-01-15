<?php

class Action extends Controller {

	function Action()
	{
		parent::Controller();
	}

	function index()
	{
		$post = $_POST;
		$general_setting = '';
		$this_date = date("Y-m-d H:i:s");
		$this->table = $post['table'];
		$this->module_no = $post['module_no'];

		if ($this->session->userdata('userid')) {

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

			//태그처리
			/*
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
			*/
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
		//print_r($post);
        ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/include/css/jquery-ui-1.7.2.custom.css" />
		<!--script type="text/javascript" src="/include/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="/include/js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="/include/js/jquery.framedialog.js"></script-->
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
		<?
		foreach ($qer->result_array() as $row) {
		?>
		<tr id="row_num_<?=$row['no']?>">
		<td>
			<table border=0 cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td height=5 colspan=2></td>
			</tr>
			<tr id="row_2_<?=$row['no']?>">
			<td valign=top style="padding-left:10px;">
				<div style="height:28px; line-height:20px;">
					<div style="float:left; margin:0px 0 0 2px;">
					<strong><?=($row['nickname'])?$row['nickname']:$row['user_name']?></strong>
					<span style="color:#888888; font-size:11px;"><?=$row['reg_date']?></span>
					</div>
					<div style="float:right;">
					&nbsp;<span style="color:#B2B2B2; font-size:11px;"><!--?=$row['ip']?--></span>&nbsp;
					<?if($row['user_no'] == $this->session->userdata('user_no')) { ?>
					<a href="javascript:reply_edit('<?=$row['no']?>','<?=$post['url1']?>','<?=$post['url2']?>');"><img src="/images/co_btn_modify.gif" align="absmiddle"></a> <a href="javascript:reply_delete('<?=$post['table']?>','<?=$row['no']?>','<?=$post['no']?>');" onclick="return confirm(&quot;삭제하시겠습니까?&quot;)"><img src="/images/co_btn_delete.gif" align="absmiddle"></a>
					<? } ?>
					</div>
				</div>
				<div style='line-height:14px; padding:7px; word-break:break-all; overflow:hidden; clear:both; text-align:left; '>
					<?=$row['contents']?>
				</div>
			</td>
			</tr>
			<tr>
				<td height=5 colspan=3></td>
			</tr>
			<tr>
				<td height=1 colspan=3 bgcolor="#dddddd"><td>
			</tr>
			<? } ?>
			</table>
		</td>
		</tr>
        <?
		$this->db->cache_delete('default', 'index');

	}

	function delete()
	{
		//print_r($_POST);
		//$post = $_POST;
		$u_no=$this->db->get_where($this->input->post("board_id"), array('no'=>$this->input->post("row_no")));
		$row=$u_no->row();

		if($row->user_id == $this->session->userdata('userid')) {

		$data = array('is_delete' => 'Y');
		$this->db->where('no', $this->input->post("row_no"));
		$this->db->update($this->input->post("board_id"), $data);

		//리플갯수 업데이트
		$sql = "update `".$this->input->post("board_id")."` set reply_count=reply_count-1 where no = '".$this->input->post("views_no")."' ";
			echo ($this->db->query($sql));
		} else {
			echo "본인이 작성할 글만 삭제할수 있습니다.";
		}
		/*
		//리플 내용 반환
		$this->db->order_by('no', 'desc');
        $qer=$this->db->get_where($post['table'], array('original_no'=>$this->uri->segment('5'), 'is_delete'=>'N'));
        ?>
        <table width="98%" align="center">
        <?
        foreach ($qer->result_array() as $row) { ?>
        <tr style="border-bottom:1px solid #e0e1db;">
			<td>작성자</td><td><?=$row['user_name']?></td><td>작성일</td><td><?=$row['reg_date']?></td>
			<td><?if($row['user_no'] == $this->session->userdata('user_no')) { ?>
			<a href="#">수정</a> <a href="javascript:reply_delete('<?=MENU_BOARD_NAME_EN?>','<?=$row['no']?>','<?=$views['no']?>');" onclick="return confirm(&quot;삭제하시겠습니까?&quot;)">삭제</a>
			<? } ?></td>
		</tr>
		<tr style="border-bottom:1px solid #e0e1db; text-align:left;">
			<td colspan="5"><?=$row['contents']?></td>
		</tr>
		<tr>
			<td colspan="5" height="5"></td>
		</tr>
        <? } ?>
        </table>

        <?
        */
		$this->db->cache_delete('default', 'index');
	}

	function strip_image_tags_fck($str, $no, $type)
	{
		$file_table="files";
		preg_match_all("<img [^<>]*>", $str, $out, PREG_PATTERN_ORDER);
		$strs = $out[0];
		//$arr=array();
		$cnt = count($strs);
		for ($i=0;$i<$cnt;$i++) {
  			$arr = preg_replace("#img\s+.*?src\s*=\s*[\"']\s*\/data/images/\s*(.+?)[\"'].*?\/#", "\\1", $strs[$i]);
  			$data = array(
			  			'module_id'=> $this->module_no,
						'module_name'=> $this->table,
						'module_no'=>$no,
						'module_type'=>$type,
						'file_name'=>$arr,
  						'reg_date'=>date("Y-m-d H:i:s")
			  			);
			if ( count($arr) <= 25 ) {
				$this->db->insert($file_table, $data);
			}
  		}
		return $cnt;
	}

	/**
	 * 추천
	 * @return recommend_cnt
	 */
	function recommend() {
		if ( $_POST['mode'] == 'recommend') {
			$sql1 = "update `".$_POST['table']."` set voted_count=voted_count+1 where no='".$_POST['no']."'";
			$this->db->query($sql1);
			$this->db->select('voted_count');
			$res = $this->db->get_where($_POST['table'], array('no'=>$_POST['no']));
			$cnt = $res->row();
			echo $cnt->voted_count;
		}
		elseif ( $_POST['mode'] == 'blamed' ) {
			$sql1 = "update `".$_POST['table']."` set blamed_count=blamed_count+1 where no='".$_POST['no']."'";
			$this->db->query($sql1);
			$this->db->select('blamed_count');
			$res = $this->db->get_where($_POST['table'], array('no'=>$_POST['no']));
			$cnt = $res->row();
			echo $cnt->blamed_count;
		}
	}

	function file_delete() {

		$u_no=$this->db->get_where($_POST['table'], array('no'=>$_POST['module_no']));
		$row=$u_no->row();

		if($row->user_id == $this->session->userdata('userid')) {
			$this->db->delete($_POST['file_table'], array('module_name' => $_POST['table'], 'module_no' => $_POST['module_no']));
			echo "1";
		} else {
			echo "2";
		}

	}

	function hybrid_test() {
/*
		$this->db->select('no, subject, reg_date');
		$this->db->limit('10');
		$this->db->order_by('no', 'desc');
		$this->db->where('user_id', $this->input->post('param'));
		//$this->db->where('user_id', 'blumine');
		$this->db->where('original_no', '0');
		$query = $this->db->get_where('board_free', array('is_delete'=>'N'));
		$qq = $query->result();
		//var_dump($qq);
		//echo json_encode($qq);

		?>
		<table>
		<?php foreach($qq as $row)
		{ ?>
			<tr><td><?php echo $row->no;?></td><td><?php echo $row->subject;?></td><td><?php echo substr($row->reg_date, 0, 10);?></td></tr>
		<?php } ?>
		</table>
		<?php
*/
		echo "aaaaa";
	}
}