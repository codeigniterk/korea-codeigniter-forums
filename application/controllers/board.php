<?php
/**
* 개발 및 정리 웅파(advisor@cikorea.net)
* 2013-03-05
* 로그인, 회원가입(tank auth 이용),
* 회원관리, 게시판 작업
*/
class Board extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

		$rew = $this->db->get_where('board_list', array('name_en'=>'board_'.$this->uri->segment(1)));
		$item = $rew->row();
		define('MENU_ID', $item->no);
		define('MENU_SKIN', $item->skin);
		define('MENU_BOARD_NAME', $item->name);
		define('MENU_BOARD_NAME_EN', $item->name_en);
		define('MENU_BOARD_PERM', $item->permission);
		define('MENU_BOARD_DETAIL_SETTING', $item->detail_setting);

		//게시판 퍼미션 선언. 목록보기,게시물보기,댓글작성,게시물쓰기
		$perm = explode("|", MENU_BOARD_PERM);
		$this->list_perm = $perm[0];
		$this->view_perm = $perm[1];
		$this->reply_perm = $perm[2];
		$this->write_perm = $perm[3];

		//게시판용 모델 로딩
		$this->load->model('board_m');

		//common helper
		$this->seg_exp = segment_explode($this->uri->uri_string());
		$this->output->enable_profiler(true);
	}

	//헤더, 푸터 자동삽입
	public function _remap($method)
	{
		$data = array();
		if($this->uri->segment(2) == 'view') {
			$data['views'] = $this->board_m->board_view($this->uri->segment(3), '');
		}

		if($this->uri->segment(2) != 'reply_edit')
		{
			$this->load->view('top_v', $data);
		}

		if( method_exists($this, $method) )
		{
			$this->{"{$method}"}();
		}

		if($this->uri->segment(2) != 'reply_edit')
		{
			$this->load->view('bottom_v');
		}
	}

	function index()
	{
		switch($this->uri->segment(2))
		{
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

	//게시판 목록
	function lists()
	{
		//주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
		$uri_array = segment_explode($this->uri->uri_string());
		$search_word = '';
		$sfl = '';

		if( in_array('q', $uri_array) )
		{
			$data['search_word'] = $search_word = urldecode($this->security->xss_clean(url_explode($uri_array, 'q')));
			//주소에서 q 제거. 뷰에서 사용
			$uri_array =  url_delete($uri_array, 'q');
			$data['search_url'] = "q/".$search_word;
		}
		else
		{
			$data['search_word'] = '';
			$data['search_url'] = '';
		}

		if( in_array('sfl', $uri_array) )
		{
			$data['search_sfl'] = $sfl = urldecode($this->security->xss_clean(url_explode($uri_array, 'sfl')));
			//주소에서 sfl 제거
			$uri_array = url_delete($uri_array, 'sfl');
		}
		else
		{
			$data['search_sfl'] = '';
		}



		$data['url'] = implode('/', $uri_array);

		if( $search_word != '' AND $sfl != '' )
		{
			$post = array('method'=>$sfl, 's_word'=>$search_word);
		}
		else
		{
			$post = '';
		}

		//페이징변수
		if( in_array('page', $uri_array) )
		{
			$data['page_account'] = $page = urldecode($this->security->xss_clean(url_explode($uri_array, 'page')));
		}
		else
		{
			$data['page_account'] = $page = 1;
		}

		if(!is_numeric($page))
		{
			$data['page_account'] = $page = 1;
		}

		//퍼미션 체크
		if(($this->session->userdata('auth_code') == 'ADMIN' ) or ($this->session->userdata('auth_code') >= $this->list_perm) or ($this->list_perm == 1) )
		{
			//게시물 전체 갯수
			$tot_cnt = $this->board_m->load_list_total($post, MENU_BOARD_NAME_EN);
			$data['list_total'] = $total = $tot_cnt->cnt;

			$rp = 20; //리스트 갯수
			$limit = 9; //보여줄 페이지수

			$start = (($page-1) * $rp);

			//검색후 페이징처리를 위해 주소에서 page를 삭제
			$this->url_seg = $this->seg_exp;
			$urls = implode('/', url_delete($this->url_seg, 'page'));

			//common helper에 페이징 함수 존재
			$data['pagination_links'] = pagination($urls."/page", paging($page,$rp,$total,$limit));

			$data['list'] = $this->board_m->load_list($start, $rp, $post, MENU_BOARD_NAME_EN);

			$this->load->view('board/'.MENU_SKIN.'/lists_v', $data);

		}
		else
		{
			if(!$this->session->userdata('userid'))
			{
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$data['rpath_encode'] = base64_encode($rpath);

				$this->load->view('login_v',$data);
			}
			else
			{
				$data['perm'] = "게시물 리스트 보기";
				$this->load->view('perm_v',$data);
			}
		}
	}

	function edit()
	{
		//로그인 여부 체크
		$this->load->library('tank_auth');
		$this->tank_auth->is_login();

		//글번호에 대한 아이디와 세션 아이디 비교
		$write_id = $this->board_m->id_check($this->uri->segment(3));

		if(($this->session->userdata('userid') == $write_id['user_id']) )
		{
			$data['views'] = $views = $this->board_m->board_view($this->uri->segment(3), 'edit');
			$data['tags'] = $this->board_m->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			//첨부 파일 불러오기
			$data['files'] = $this->board_m->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$this->load->library('fckeditor',array('instanceName' => 'contents'));
			$this->fckeditor->Width = "700"  ;
			$this->fckeditor->ToolbarSet = 'MyToolbar';
			$this->fckeditor->Value = $views['contents'];
	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name'])
			{
				$config['upload_path'] = './data/files/';
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
				$this->load->view('board/'.MENU_SKIN.'/edit_v', $data);
			}
			else
			{
				$this->board_m->update_board($this->uri->segment(3), $this->input->post(NULL, TRUE));
				//file upload
				if($_FILES['userfile']['name'] != '')
				{
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
					alert('게시물이 수정되었습니다.')
					document.location= '/<?php echo $this->uri->segment(1)?>/view/<?php echo $this->uri->segment(3)?>/page/<?php echo $this->uri->segment(5)?>';
				</script>
<?php
				//db캐시 제거
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');
			}
		}
		else
		{
			alert('게시물 수정권한이 없습니다.', '/');
		}

	}

	function reply_edit()
	{
		//글번호에 대한 아이디와 세션 아이디 비교
		$write_id = $this->board_m->id_check($this->uri->segment(3));

		if(($this->session->userdata('userid') == $write_id['user_id']) )
		{
			$data['views'] = $views = $this->board_m->board_view($this->uri->segment(3), 'edit');
			$data['tags'] = $this->board_m->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			//첨부 파일 불러오기
			$data['files'] = $this->board_m->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$this->load->library('fckeditor',array('instanceName' => 'contents'));
			$this->fckeditor->Width = "700"  ;
			$this->fckeditor->ToolbarSet = 'MyToolbar';
			$this->fckeditor->Value = $views['contents'];
	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name'])
			{
				$config['upload_path'] = './data/files/';
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
				$this->load->view('board/'.MENU_SKIN.'/reply_edit_v', $data);
			}
			else
			{
				$this->board_m->update_board($this->uri->segment(3), $this->input->post(NULL, TRUE));

				//file upload
				if(@$_FILES['userfile']['name'])
				{
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
				<script type="text/javascript"  src="<?php echo JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?php echo JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					//FrameDialog 닫기
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('댓글이 수정되었습니다.')
					parent.document.location.reload();
				</script>
<?php
				//db캐시 제거
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');

			}
		}
		else
		{
			if(!$this->session->userdata('userid'))
			{
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);
?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?php echo $rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
<?php
			}
			else
			{
?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">댓글 수정 권한이 없습니다.</td>
				</tr>
				</table>
<?php
			}
		}

	}

	function write()
	{
		//로그인 여부 체크
		$this->load->library('tank_auth');
		$this->tank_auth->is_login();

		//페이징변수
		if( in_array('page', $this->seg_exp) )
		{
			$data['page_account'] = $page = urldecode($this->security->xss_clean(url_explode($this->seg_exp, 'page')));
		}
		else
		{
			$data['page_account'] = $page = 1;
		}

		if(!is_numeric($page))
		{
			$data['page_account'] = $page = 1;
		}

		if(($this->session->userdata('auth_code') == 'ADMIN' ) or ($this->session->userdata('auth_code') >= $this->write_perm) or ($this->write_perm == 1) )
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('contents', '글 내용', 'required');

			if(@$_FILES['userfile']['name'])
			{
				$config['upload_path'] = './data/files/';
				$file_types = array("7z" => "Archive","tgz" => "Archive","tar" => "Archive","gz" => "Archive", "zip" => "Archive", "rar" => "Archive", "pdf" => "Document", "ppt" => "Document", "xls" => "Document", "docx" => "Document", "xlsx" => "Document", "pptx" => "Document");
				//'doc|hwp|pdf|ppt|xls|pptx|docx|xlsx|zip|rar'
				$config['allowed_types'] = implode("|", array_keys($file_types));

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

				$this->load->view('board/'.MENU_SKIN.'/write_v', $data);
			}
			else
			{
				$post = $this->input->post(NULL, TRUE);
				$last_no = $this->board_m->insert_board($post);

				//file upload
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
				<script type="text/javascript"  src="<?php echo JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?php echo JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('게시물이 등록되었습니다.');
					parent.document.location= '/<?php echo $this->seg_exp[0]?>/view/<?php echo $last_no?>/page/<?php echo $page?>';
				</script>
<?php
			}
			//db캐시 제거
			$this->db->cache_delete('default', 'index');
			$this->db->cache_delete('rss', 'index');
		}
		else
		{
?>
			<table width="95%" height="95%">
			<tr>
				<td align="center">게시물 쓰기 권한이 없습니다.</td>
			</tr>
			</table>
<?php
		}
	}

	function view()
	{
		if(($this->session->userdata('auth_code') >= 15 ) or ($this->session->userdata('auth_code') >= $this->view_perm) or ($this->view_perm == 1) )
		{
			//페이징변수
			if( in_array('page', $this->seg_exp) )
			{
				$data['page_account'] = $page = urldecode($this->security->xss_clean(url_explode($this->seg_exp, 'page')));
			}
			else
			{
				$data['page_account'] = $page = 1;
			}

			if(!is_numeric($page))
			{
				$data['page_account'] = $page = 1;
			}

			$data['views'] = $this->board_m->board_view($this->uri->segment(3), 'view');

			if(!$data['views'] or $data['views'] == '')
			{
				alert('삭제되거나 없는 글입니다.', HOST_DIR);
			}
			$data['tags'] = $this->board_m->board_tag($this->uri->segment(3), MENU_BOARD_NAME_EN);

			$data['reply_perm'] = $this->reply_perm;
			$data['replys'] = $this->board_m->reply_view($this->uri->segment(3));

			$data['files'] = $this->board_m->file_list($this->uri->segment(3));
			$data['files_cnt'] = count($data['files']);

			$rp = 20; //리스트 갯수

			$start = (($page-1) * $rp);

			//주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
			$uri_array = segment_explode($this->uri->uri_string());
			$search_word = '';
			$sfl = '';

			if( in_array('q', $uri_array) )
			{
				$data['search_word'] = $search_word = urldecode($this->security->xss_clean(url_explode($uri_array, 'q')));
				//주소에서 q 제거. 뷰에서 사용
				$uri_array =  url_delete($uri_array, 'q');
			}
			else
			{
				$data['search_word'] = '';
			}

			if( in_array('sfl', $uri_array) )
			{
				$sfl = urldecode($this->security->xss_clean(url_explode($uri_array, 'sfl')));
				//주소에서 sfl 제거
				$uri_array = url_delete($uri_array, 'sfl');
			}

			$data['url'] = implode('/', $uri_array);

			if( $search_word != '' AND $sfl != '' )
			{
				$post = array('method'=>$sfl, 's_word'=>$search_word);
			}
			else
			{
				$post = '';
			}

			$data['bottom_all'] = $this->board_m->load_list($start, $rp, $post, MENU_BOARD_NAME_EN);
			$data['board_list'] = $this->board_m->get_board_list(); // 게시판 이동용 게시판 리스트

			$this->load->library('fckeditor',array('instanceName' => 'wcontent'));
			$this->fckeditor->Width = "620";
			$this->fckeditor->Height = "200";
			$this->fckeditor->ToolbarSet = 'Reply';

	        $data['fck_write'] = $this->fckeditor->CreateHtml();

	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('subject', '글 제목', 'required');
			$this->form_validation->set_rules('wcontent', '글 내용', 'required');

			$this->load->view('board/'.MENU_SKIN.'/view_v', $data);
		}
		else
		{
			if(!$this->session->userdata('userid'))
			{
				$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
				$rpath_encode = base64_encode($rpath);
?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?php echo $rpath_encode?>'>로그인</a></td>
				</tr>
				</table>
<?php
			}
			else
			{
?>
				<table width="95%" height="95%">
				<tr>
					<td align="center">게시물 보기 권한이 없습니다.</td>
				</tr>
				</table>
<?php
			}
		}
	}

	function download()
	{
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
			alert('파일을 찾을 수 없습니다.');
	}

	function delete()
	{
		if(!$this->session->userdata('userid'))
		{
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode = base64_encode($rpath);

?>
			<table width="95%" height="95%">
			<tr>
				<td align="center">로그인이 필요한 페이지입니다.<br><br><a href='/auth/login_gate/<?php echo $rpath_encode?>'>로그인</a></td>
			</tr>
			</table>
<?php

		}
		else
		{
			$delete_id = $this->board_m->id_check($this->uri->segment(3));

			if($this->session->userdata('userid') == $delete_id['user_id'] || $this->session->userdata('auth_code') >= '15')
			{
				$this->board_m->delete_post($this->uri->segment(3));
?>
				<script>
					alert('게시물이 삭제되었습니다.');
					location= '/<?php echo $this->seg_exp[0]?>/lists/page/1';
				</script>
<?php
				$this->db->cache_delete('default', 'index');
				$this->db->cache_delete('rss', 'index');

			}
			else
			{

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
		if($this->session->userdata('auth_code') >= 15)
		{
			$this->board_m->board_move('board_' . $this->uri->segment(1), 'board_' . $this->uri->segment(4), $this->uri->segment(3));
			echo "<script>location.replace('/" . $this->uri->segment(4) . "/list')</script>";
		}
		else
		{
			echo "<script>history.go(-1)</script>";
		}
	}
}

/* End of file Board.php */
/* Location: ./application/controllers/board.php */
