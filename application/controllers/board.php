<?php
/**
* 개발 웅파(blumine@paran.com)
* 2009-07-19
* 로그인, 회원가입(tank auth 이용),
* 회원관리, 게시판 작업
*/
class Board extends Controller {

	function Board()
	{
		parent::Controller();

		// 게시판 리스트 가져오기 by 불의회상 110104
		// SELECT `name`, name_en FROM board_list ORDER BY `name`
		$this->db->select('`name`, name_en');
		$this->db->from('board_list');
		$this->db->order_by('name');
		$rs =$this->db->get();
		$this->board_list = array();
		foreach($rs->result() as $row) {
			$this->board_list[str_replace('board_', '', $row->name_en)] = $row->name;
		}
		// 게시판 리스트 가져오기 끝

		$rew = $this->db->get_where('board_list', array('name_en'=>'board_'.$this->uri->segment(1)));
		$item = $rew->row();
		define('MENU_ID', $item->no);
		define('MENU_SKIN', $item->skin);
		define('MENU_BOARD_NAME', $item->name);
		define('MENU_BOARD_NAME_EN', $item->name_en);
		define('MENU_BOARD_PERM', $item->permission);
		define('MENU_BOARD_DETAIL_SETTING', $item->detail_setting);

		$this->load->helper('alert');
		$this->load->model('board_model');

		$perm = explode("|", MENU_BOARD_PERM); //목록보기,게시물보기,댓글작성,게시물쓰기
		$this->list_perm = $perm[0];
		$this->view_perm = $perm[1];
		$this->reply_perm = $perm[2];
		$this->write_perm = $perm[3];
		if($this->session->userdata('userid')=='blumine') {
			$this->output->enable_profiler(true);
		} else {
			$this->output->enable_profiler(false);
		}

		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}

	function index() {
		//echo $this->uri->segment(2);
		switch($this->uri->segment(2)) {
		case 'lists':
			$this->lists();
		break;
		case 'view':
			$this->view();
		break;
		case 'write':
			$this->write();
		break;
		case 'delete':
			$this->delete();
		break;
		case 'edit':
			$this->edit();
		break;
		case 'reply_edit':
			$this->reply_edit();
		break;
		case 'download':
			$this->download();
		break;
		case 'move':
			$this->move();
		break;

		default:
			$this->lists();
		break;
		}
	}

	function lists() //$plugin, $function, $skin
	{
		//$this->output->enable_profiler(true);
		if(in_array("q", $this->seg_exp)) {
			$arr_key = array_keys($this->seg_exp, "q");
			$arr_val = $arr_key[0] + 1;

            if(@$this->seg_exp[$arr_val]){
			    $search_word = $this->seg_exp[$arr_val];
            } else {
                $search_word = '검색어없음';
            }
			$arr_key1 = array_keys($this->seg_exp, "sfl");
            if(@$arr_key1[0]){
                $arr_val1 = $arr_key1[0] + 1;
            } else {
                $arr_val1 = 10;
            }
            if(@$this->seg_exp[$arr_val1]){
			    $sfl = $this->seg_exp[$arr_val1];
            } else {
                $sfl = 'subject';
            }
			$post = array('method'=>$sfl, 's_word'=>$search_word);
		} else {
    		$post = '';
    	}
		if(($this->session->userdata('auth_code') == 'ADMIN' ) or ($this->session->userdata('auth_code') >= $this->list_perm) or ($this->list_perm == 1) ) {
			$tot_cnt = $this->board_model->load_list_total($post, MENU_BOARD_NAME_EN);
			$data['list_total'] = $total = $tot_cnt->cnt;
			//페이징
			if(in_array("page", $this->seg_exp)) {
				$arr_key = array_keys($this->seg_exp, "page");
				$arr_val = $arr_key[0] + 1;
                if(@$this->seg_exp[$arr_val]){
				    $data['page_account']=$page = $this->seg_exp[$arr_val];
                } else {
                    $data['page_account']=$page = 1;
                }
			} else {
				$data['page_account']=$page = 1;
			}

			$rp = 20; //리스트 갯수
			$limit = 9; //보여줄 페이지수

			if(!is_numeric($page)) {
				$page = 1;
			}

			$start = (($page-1) * $rp);

			//검색후 페이징처리위한..
			//print_r($this->seg_exp);
			$this->url_seg = $this->seg_exp;
			$arr_s = array_search('page', $this->url_seg);
			array_splice($this->url_seg, $arr_s, 2);

			$urls = implode('/', $this->url_seg);
            if ($this->session->userdata('userid') == 'blumine') {
                //print_r($this->url_seg);
                //echo $_SERVER['HTTP_USER_AGENT'];
				//echo "---".$page."---";
            }

			$data['pagination_links'] = $this->common->pagination($urls."/page", paging($page,$rp,$total,$limit));

			$data['list'] = $this->board_model->load_list($start, $rp, $post, MENU_BOARD_NAME_EN);

			$this->load->view('top_v');
			$this->load->view('board/'.MENU_SKIN.'/lists', $data);
			$this->load->view('bottom_v');
		} else {
			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$data['rpath_encode'] = base64_encode($rpath);
				$this->load->view('top_v');
				$this->load->view('login_view',$data);
				$this->load->view('bottom_v');
			} else {
				$data['perm'] = "게시물 리스트 보기";
				$this->load->view('top_v');
				$this->load->view('perm_view',$data);
				$this->load->view('bottom_v');
			}
		}

	}

	function edit()
	{
		//글번호에 대한 아이디와 세션 아이디 비교
		$write_id = $this->board_model->id_check($this->uri->segment(3));

		if(($this->session->userdata('userid') == $write_id['user_id']) ) {
			$data['views'] = $views = $this->board_model->board_view($this->uri->segment(3), 'edit');
			$data['tags'] = $this->board_model->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			//첨부 파일 불러오기
			$data['files'] = $this->board_model->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$this->load->library('fckeditor',array('instanceName' => 'contents'));
			$this->fckeditor->Width = "700"  ;
			$this->fckeditor->ToolbarSet = 'MyToolbar';
			$this->fckeditor->Value = $views['contents'];
	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name']) {

					$config['upload_path'] = DATA_ROOT.'/files/';
					$config['allowed_types'] = 'zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx';
					$config['max_size']	= '2000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload', $config);
					$file_chk = $this->upload->do_upload();
					$data['file_error'] = $file_error = $this->upload->display_errors();

			}

			if ($this->form_validation->run() == FALSE || @$file_error)
			{
				$this->load->view('top_v');
				$this->load->view('board/'.MENU_SKIN.'/edit', $data);
				$this->load->view('bottom_v');
			}
			else
			{
				$this->board_model->update_board($this->uri->segment(3), $_POST);
				//file upload
				if($_FILES['userfile']['name'] != '') {

					$daf =$this->upload->data();
					$dat_arr3 = array(
						'module_id'=> MENU_ID,
						'module_name'=> MENU_BOARD_NAME_EN,
						'module_no'=>$this->uri->segment(3),
						'original_name'=>$daf['orig_name'],
						'file_name'=>$daf['file_name'],
						'file_type'=>$daf['file_type'],
						'reg_date'=>date("Y-m-d H:i:s")
					);

					$this->db->insert('files', $dat_arr3);

					//파일카운터 업데이트
					$sql_file = "update `".MENU_BOARD_NAME_EN."` set files_count=files_count+1 where no = '".$this->uri->segment(3)."' ";
					$this->db->query($sql_file);
				}
				?>

				<script>
					//FrameDialog 닫기
					//$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('게시물이 수정되었습니다.')
					document.location= '/<?=$this->uri->segment(1)?>/view/<?=$this->uri->segment(3)?>/page/<?=$this->uri->segment(5)?>';
					//parent.document.location.reload();
				</script>
				<?
				//db캐시 제거
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');
			}
		} else {
			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
			<?
			} else { ?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">게시물 수정 권한이 없습니다.</td>
				</tr>
				</table>
			<?
			}
		}

	}

	function reply_edit()
	{

		//글번호에 대한 아이디와 세션 아이디 비교
		$write_id = $this->board_model->id_check($this->uri->segment(3));

		if(($this->session->userdata('userid') == $write_id['user_id']) ) {
			$data['views'] = $views = $this->board_model->board_view($this->uri->segment(3), 'edit');
			$data['tags'] = $this->board_model->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			//첨부 파일 불러오기
			$data['files'] = $this->board_model->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$this->load->library('fckeditor',array('instanceName' => 'contents'));
			$this->fckeditor->Width = "700"  ;
			$this->fckeditor->ToolbarSet = 'MyToolbar';
			$this->fckeditor->Value = $views['contents'];
	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name']) {

					$config['upload_path'] = DATA_ROOT.'/files/';
					$config['allowed_types'] = 'zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx';
					$config['max_size']	= '2000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload', $config);
					$file_chk = $this->upload->do_upload();
					$data['file_error'] = $file_error = $this->upload->display_errors();

			}

			if ($this->form_validation->run() == FALSE || @$file_error)
			{
				$this->load->view('board/'.MENU_SKIN.'/reply_edit', $data);
			}
			else
			{
				$this->board_model->update_board($this->uri->segment(3), $_POST);

				//file upload
				if(@$_FILES['userfile']['name']) {

					$daf =$this->upload->data();
					$dat_arr3 = array(
						'module_id'=> MENU_ID,
						'module_name'=> MENU_BOARD_NAME_EN,
						'module_no'=>$this->uri->segment(3),
						'original_name'=>$daf['orig_name'],
						'file_name'=>$daf['file_name'],
						'file_type'=>$daf['file_type'],
						'reg_date'=>date("Y-m-d H:i:s")
					);

					$this->db->insert('files', $dat_arr3);

					//파일카운터 업데이트
					$sql_file = "update `".MENU_BOARD_NAME_EN."` set files_count=files_count+1 where no = '".$this->uri->segment(3)."' ";
					$this->db->query($sql_file);
				}
				?>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					//FrameDialog 닫기
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('댓글이 수정되었습니다.')
					parent.document.location.reload();
				</script>
				<?
				//db캐시 제거
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');

			}
		} else {
			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
			<?
			} else { ?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">댓글 수정 권한이 없습니다.</td>
				</tr>
				</table>
			<?
			}
		}

	}

	function write()
	{
		if(in_array("page", $this->seg_exp)) {
			$arr_key = array_keys($this->seg_exp, "page");
			$arr_val = $arr_key[0] + 1;
			$page = $this->seg_exp[$arr_val];
		} else {
			$page = 1;
		}
		if(($this->session->userdata('auth_code') == 'ADMIN' ) or ($this->session->userdata('auth_code') >= $this->write_perm) or ($this->write_perm == 1) ) {

			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
			<?
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name']) {
					//echo $_FILES['userfile']['name'];
					$config['upload_path'] = DATA_ROOT.'/files/';
					$file_types = array("7z" => "Archive","tgz" => "Archive","tar" => "Archive","gz" => "Archive", "zip" => "Archive", "rar" => "Archive", "pdf" => "Document", "ppt" => "Document", "xls" => "Document", "docx" => "Document", "xlsx" => "Document", "pptx" => "Document");
					$config['allowed_types'] = implode("|", array_keys($file_types));//'doc|hwp|pdf|ppt|xls|pptx|docx|xlsx|zip|rar';
					//echo $config['allowed_types'];
					$config['max_size']	= '5000';
					$config['max_width']  = '1024';
					$config['max_height']  = '768';
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload', $config);
					$file_chk = $this->upload->do_upload();
					$data['file_error'] = $file_error = $this->upload->display_errors();

			}

			if ($this->form_validation->run() == FALSE || @$file_error)
			{
				$this->load->library('fckeditor',array('instanceName' => 'contents'));
				$this->fckeditor->Width = "700"  ;
				$this->fckeditor->ToolbarSet = 'MyToolbar';
				if(@set_value('contents')) $this->fckeditor->Value = htmlspecialchars_decode(set_value('contents'));

				$data['fck_write'] = $this->fckeditor->CreateHtml();

					$this->load->view('top_v');
					$this->load->view('board/'.MENU_SKIN.'/write_new', $data);
					$this->load->view('bottom_v');

			}
			else
			{
				$last_no = $this->board_model->insert_board($_POST);
				//트위터 입력

				if($this->uri->segment(1) == 'free'){
					$this->load->library('twitter_lib');
					$this->twitter_lib->auth('codeigniterK', 'code3432');
					$contents1 = "[포럼]#".$this->session->userdata('username')." ".substr(strip_tags($this->input->post('contents')), 0, 30);

					$this->twitter_lib->call('statuses/update', array('status' => $contents1));
				}

				//file upload
				//print_r($_FILES);
				if($_FILES['userfile']['name']) {

					$daf =$this->upload->data();
					$dat_arr3 = array(
						'module_id'=> MENU_ID,
						'module_name'=> MENU_BOARD_NAME_EN,
						'module_no'=>$last_no,
						'original_name'=>$daf['orig_name'],
						'file_name'=>$daf['file_name'],
						'file_type'=>$daf['file_type'],
						'reg_date'=>date("Y-m-d H:i:s")
					);

					$this->db->insert('files', $dat_arr3);

					//파일카운터 업데이트
					$sql_file = "update `".MENU_BOARD_NAME_EN."` set files_count=files_count+1 where no = '".$last_no."' ";
					$this->db->query($sql_file);
				}
				// 작성한 글 보여주기
				?>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					//FrameDialog 닫기
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('게시물이 등록되었습니다.')
					parent.document.location= '/<?=$this->seg_exp[0]?>/view/<?=$last_no?>/page/<?=$page?>';
				</script>
				<?
			}
			//db캐시 제거
			$this->db->cache_delete('default', 'index');
			$this->db->cache_delete('rss', 'index');

		} else {
			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
			<?
			} else { ?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">게시물 쓰기 권한이 없습니다.</td>
				</tr>
				</table>
			<?
			}
		}


	}

	function view()
	{
		if(($this->session->userdata('auth_code') >= 15 ) or ($this->session->userdata('auth_code') >= $this->view_perm) or ($this->view_perm == 1) ) {
			if(in_array("page", $this->seg_exp)) {
				$arr_key = array_keys($this->seg_exp, "page");
				$arr_val = $arr_key[0] + 1;
				$data['page_account']=$page = $this->seg_exp[$arr_val];
			} else {
				$data['page_account']=$page = 1;
			}
			$data['views'] = $this->board_model->board_view($this->uri->segment(3), 'view');
			if(!$data['views'] or $data['views'] == ''){
				alert('삭제되거나 없는 글입니다.', SV1_DIR);
			}
			$data['tags'] = $this->board_model->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			$data['reply_perm'] = $this->reply_perm;
			$data['replys'] = $this->board_model->reply_view($this->uri->segment(3));

			$data['files'] = $this->board_model->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$rp = 20; //리스트 갯수

			if(!is_numeric($page)) {
				$page = 1;
			}



			$start = (($page-1) * $rp);

			if (in_array('q', $this->seg_exp) and in_array('sfl', $this->seg_exp)) {
				$arr_key = array_keys($this->seg_exp, "q");
				$arr_val = $arr_key[0] + 1;
				$search_word = $this->seg_exp[$arr_val];
				$arr_key1 = array_keys($this->seg_exp, "sfl");
				$arr_val1 = $arr_key1[0] + 1;
				$sfl = $this->seg_exp[$arr_val1];

				$post = array('method'=>$sfl, 's_word'=>$search_word);
			} else {
				$post ='';
			}

			$data['bottom_all'] = $this->board_model->load_list($start, $rp, $post, MENU_BOARD_NAME_EN);
			$data['board_list'] = $this->board_list; // view에 데이타 넘김

			$this->load->library('fckeditor',array('instanceName' => 'wcontent'));
			$this->fckeditor->Width = "620";
			$this->fckeditor->Height = "200";
			$this->fckeditor->ToolbarSet = 'Reply';

	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('wcontent', '글 내용', 'required');

			$this->load->view('top_v', $data);
			$this->load->view('board/'.MENU_SKIN.'/view', $data);
			$this->load->view('bottom_v');

		} else {
			if(!$this->session->userdata('userid')) {
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
			<?
			} else { ?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">게시물 보기 권한이 없습니다.</td>
				</tr>
				</table>
			<?
			}
		}
	}

	function download() {

			$this->load->helper('alert');

			$this->db->select('original_name, file_name');
			$qry = $this->db->get_where('files', array(
				'module_name' => MENU_BOARD_NAME_EN,
				'module_no'=> $this->uri->segment(3),
				'no' => $this->uri->segment(4)
			));
			$file = $qry->row_array();

			if (!isset($file['file_name']))
				alert("파일 정보가 존재하지 않습니다.");

			$this->load->helper('download');
			$data = file_get_contents($this->input->server('DOCUMENT_ROOT')."/data/files/".$file['file_name']);
			if (!force_download(urlencode($file['original_name']), $data))
			//if (!force_download($file['original_name'], $data))
				alert('파일을 찾을 수 없습니다.');
	}

	function delete()
	{
		if(!$this->session->userdata('userid')) {
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode = base64_encode($rpath);

?>
			<table width="95%" height="95%">
			<tr>
				<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?=$rpath_encode?>'>로그인</a></td>
			</tr>
			</table>
<?php

		} else {
			$delete_id = $this->board_model->id_check($this->uri->segment(3));

			if($this->session->userdata('userid') == $delete_id['user_id'] || $this->session->userdata('auth_code') >= '15') {

				$this->board_model->delete_post($this->uri->segment(3));
?>
				<script>
					//FrameDialog 닫기
					alert('게시물이 삭제되었습니다.')
					location= '/<?=$this->seg_exp[0]?>/lists/page/1';
				</script>
<?php
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');

			} else {

?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">게시물 삭제 권한이 없습니다.
					<br>
					<a href="/">메인으로 이동</a>
					</td>
				</tr>
				</table>
<?php

			}
		}
	}

	// 게시물 이동 기능 구현  by 불의회상 111004
	function move()
	{
		if($this->session->userdata('auth_code') >= 15) {
			$this->board_model->board_move('board_' . $this->uri->segment(1), 'board_' . $this->uri->segment(4), $this->uri->segment(3));
			echo "<script>location.replace('/" . $this->uri->segment(4) . "/list')</script>";
		} else {
			echo "<script>history.go(-1)</script>";
		}
	}
}

/* End of file Board.php */
/* Location: ./system/application/controllers/board.php */
