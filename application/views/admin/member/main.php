<?php

class Main extends Controller {

	function Main()
	{
		parent::Controller();
		//$this->load->library('pagination');
		$this->load->helper('html');
		$this->load->helper('text');
		$this->load->model('admin_m');
		$this->load->model('leftmenu_m');
		$this->load->helper('date');
		global $a_code, $Tmenulist;
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		if( in_array("AD", $a_code) ){
			$Tmenulist = '<ul id="gnb_sub">
				<li><a href="" target="_self" onfocus=this.blur();>사이트관리</a></li>
				<li><a href="" target="_self" onfocus=this.blur();>사이트설정</a></li>
			</ul>';
		} else {
			$Tmenulist = '<ul id="gnb_sub">
				<li><a href="/admin/member/" target="_self" onfocus=this.blur();>운영자 관리</a></li></ul>';
		}
	}

	function index()
	{
		global $a_code, $Tmenulist;

		$this->output->enable_profiler(TRUE);

		if($this->session->userdata('user_id')) {
			if( in_array("SA", $a_code) ) {

				/**
				 * 메뉴 xml파일 로드하여 데이터를 view에 넘김
				 */
				//$xmlfile = DATA_ROOT."/admin/menu.xml";
				//$this->load->library('xml_reader');
				//$doc = $this->xml_reader->load($xmlfile);
				$data['Tmenulist'] = $Tmenulist;
				$this->load->view('admin/header', $data);
				$this->load->view('admin/main_v');
				$this->load->view('admin/footer');
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?php
			}
		} else {
			//로그인후 리턴페이지
			//$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode=base64_encode($rpath);
			//echo $rpath;
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?php
		}
	}



	function category()
	{
		if($this->session->userdata('user_id')) {
			//show_error($this->input->post);
			switch($this->input->post('mode')) {
			case ('register'):
				$this->admin_m->register($this->input->post('parent_seq'), $this->input->post('category_name'), $this->input->post('order_by'), $this->input->post('order_by_before'), $this->input->post('table'));
			break;
			case ('modify'):
				$this->admin_m->modify($this->input->post('no'), $this->input->post('category_name'), $this->input->post('order_by'), $this->input->post('order_by_before'), $this->input->post('table'),$this->input->post('parent_seq'));
			break;
			case ('delete'):
				$this->admin_m->deletion($this->input->post('no'), $this->input->post('category_name'), $this->input->post('order_by'), $this->input->post('order_by_before'), $this->input->post('table'),$this->input->post('parent_seq'));
			break;
			}
			if( in_array("SA", $a_code) ) {
				$this->load->view('admin/category/index_v');
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}

		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

	function member() //회원관리
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		//echo $this->session->userdata('auth_code')."<br>";
		//print_r($a_code);
		if($this->session->userdata('user_id')) {
			$data['new']='헬로';
			if( in_array("su", $a_code) ) {
				$this->load->library('pagination');
				$config['page_query_string']=FALSE;
				$this->load->library('validation');

				$rules['search_word'] = "required";
				$this->validation->set_rules($rules);
				$fields['search_word']	= '검색어';
				$this->validation->set_fields($fields);

				$config['uri_segment'] = 3;
				$data['perPage'] = $config['per_page']='15'; //페이지당 리스트 노출갯수
				$config['base_url']=site_url('admin/member/'); //페이징처리 링크주소
				$page=$offset = $this->uri->segment(3, 0);
				if( $this->input->post('search_word') ){
					$data['mlist'] = $this->admin_m->member_list($this->input->post('search_word'), $offset, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->member_getTotalData($this->input->post('search_word'), $offset, $config['per_page']);
				} else {
					$data['mlist'] = $this->admin_m->member_list('', $offset, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->member_getTotalData('all_keyword', '', '');
				}

				$this->pagination->initialize($config);
				$data['pagenav'] = $this->pagination->create_links();

				$this->load->view('admin/member/index', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

	function member_view() //회원상세보기
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		//echo $this->session->userdata('auth_code')."<br>";
		//print_r($a_code);
		if($this->session->userdata('user_id')) {
			if( in_array("su", $a_code) ) {
				$data['member_info'] = $this->admin_m->member_view($this->uri->segment(3)); //운영자 리스트
				$this->load->view('admin/member/view', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?php
		}
	}

	function master()  //운영자 관리
	{
		global $a_code, $Tmenulst;
		if($this->session->userdata('user_id')) {
			$data['new']='헬로';
			if( in_array("SA", $a_code) ) {
				$this->load->library('pagination');
				$config['page_query_string']=FALSE;
				$this->load->library('validation');

				$rules['search_word'] = "required";
				$this->validation->set_rules($rules);
				$fields['search_word']	= '검색어';
				$this->validation->set_fields($fields);

				$config['uri_segment'] = 3;
				$data['perPage']=$config['per_page']='15'; //페이지당 리스트 노출갯수
				$config['base_url']=site_url('admin/master/'); //페이징처리 링크주소
				$page=$offset = $this->uri->segment(3, 0);
				if( $this->input->post('search_word') ){
					$data['mlist'] = $this->admin_m->master_list($this->input->post('search_word'), $offset, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData($this->input->post('search_word'), $offset, $config['per_page']);
				} else {
					$data['mlist'] = $this->admin_m->master_list('', $offset, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('all_keyword', '', '');
				}

				$this->pagination->initialize($config);
				$data['pagenav'] = $this->pagination->create_links();

				$this->load->view('admin/member/master', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

	function geoip() {
		$this->load->plugin('geoip');

        //geoip_update();
        geoip_lookup('222.110.144.40');

		$ip = gethostbyname("www.php.net");
$out = "아래의 URL과  같습니다:<br>\n";
$out .= "http://www.php.net/, http://".$ip."/, and http://".ip2long($ip)."/<br>\n";
echo $out;

	}

	function passwd_send() //비밀번호 인증번호 보내기, 비밀번호 보내기 팝업
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		//echo $this->session->userdata('auth_code')."<br>";
		//print_r($a_code);
		if( !$this->uri->segment(3) ) {
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<script>
			alert('운영자 페이지입니다.');
			self.close();
			</script>
			<?
			exit;
		}
		if($this->session->userdata('user_id')) {
			if( $this->uri->segment(4) == 'send' ) {
				$data['mode']='last';
			}else {
				$data['mode']='first';
			}
			if( in_array("su", $a_code) ) {
				$this->load->view('admin/member/hp_authcode', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<script>
			alert('운영자 페이지입니다.');
			self.close();
			</script>
			<?
		}
	}

	function log_view() //로그인 이력 보기
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환

		if($this->session->userdata('user_id')) {
			if( in_array("su", $a_code) ) {
				$this->load->library('pagination');
				$config['page_query_string']=FALSE;
				$config['uri_segment'] = 4;
				$data['perPage']=$config['per_page']='10'; //페이지당 리스트 노출갯수
				$config['base_url']=site_url('admin/log_view/'.$this->uri->segment(3).'/'); //페이징처리 링크주소
				$page=$offset = $this->uri->segment(4, 0);

				$data['llist'] = $this->admin_m->log_list($this->uri->segment(3), $offset, $config['per_page']);
				//var_dump($data['llist']);
				$data['getTotalData']=$config['total_rows']=$this->admin_m->log_TotalData($this->uri->segment(3));
				//echo $data['getTotalData']."<BR>";
				$this->pagination->initialize($config);
				$data['pagenav'] = $this->pagination->create_links();

				$this->load->view('admin/member/log_view', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<script>
			alert('운영자 페이지입니다.');
			self.close();
			</script>
			<?
		}
	}

	function faq()  //리스트
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		if($this->session->userdata('user_id')) {
			if( in_array("su", $a_code) ) {
				$this->load->library('pagination');
				$config['page_query_string']=FALSE;
				$this->load->library('validation');

				$rules['search_word'] = "required";
				$this->validation->set_rules($rules);
				$fields['search_word']	= '검색어';
				$this->validation->set_fields($fields);

				$config['uri_segment'] = 3;
				$data['perPage']=$config['per_page']='40'; //페이지당 리스트 노출갯수
				$config['base_url']=site_url('admin/faq/'); //페이징처리 링크주소
				$page=$offset = $this->uri->segment(3, 0);
				if( $this->input->post('search_word') ){
					$data['mlist'] = $this->admin_m->faq_list($this->input->post('search_word'), 0, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->faqTotalData($this->input->post('search_word'), 0, $config['per_page']);
				} else {
					$data['mlist'] = $this->admin_m->faq_list('', $offset, $config['per_page']); //운영자 리스트
					$data['getTotalData']=$config['total_rows']=$this->admin_m->faqTotalData('', '', '');
				}

				$this->pagination->initialize($config);
				$data['pagenav'] = $this->pagination->create_links();

				$this->load->view('admin/faq/index', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

	function faq_view() //faq상세보기
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		if($this->session->userdata('user_id')) {
			if( in_array("su", $a_code) ) {
				if( $this->input->post('gmode') == 'modify' ) {
					//echo $this->input->post('faq_subject');
					$dts=date("Y-m-d H:i:s");
					$sql = "UPDATE client_faq set class_seq='".$this->input->post('class_seq')."', faq_subject='".$this->input->post('faq_subject')."', faq_contents='".$this->input->post('faq_contents')."', edit_dt ='".$dts."' where faq_seq = '".$this->input->post('faq_seq')."' ";
					//echo $sql;
					$this->admin_m->log_write($sql);
					$q=$this->db->query($sql);
					echo"
					<script>
					//parent.document.location.reload();
					</script>
					";
				}
				if( $this->input->post('gmode') == 'delete' ) {
					$dts=date("Y-m-d H:i:s");
					$sql = "UPDATE client_faq set faq_enabled='N', edit_dt ='".$dts."' where faq_seq = '".$this->input->post('faq_seq')."' ";
					//echo $sql;
					$this->db->query($sql);
					$this->admin_m->log_write($sql);
					echo"
					<script>
					parent.document.location.reload();
					</script>
					";
				}
				$data['faq_view'] = $this->admin_m->faq_view($this->uri->segment(3));
				$this->load->view('admin/faq/faq_view', $data);
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

	function faq_write() //faq등록
	{
		$a_code = $this->admin_m->auth_check($this->session->userdata('auth_code')); //운영자 코드로 배열반환
		if($this->session->userdata('user_id')) {
			if( in_array("su", $a_code) ) {
				if( $this->input->post('gmode') == 'insert' ) {
					//echo $this->input->post('faq_subject');
					$dts=date("Y-m-d H:i:s");
					$sql = "insert into client_faq set user_id='".$this->session->userdata('user_id')."', class_seq='".$this->input->post('class_seq')."', faq_subject='".$this->input->post('faq_subject')."', faq_contents='".$this->input->post('faq_contents')."', reg_dt ='".$dts."', edit_dt ='".$dts."' ";
					//echo $sql;
					$this->admin_m->log_write($sql);
					$q=$this->db->query($sql);
					echo"
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					입력되었습니다.
					<script>
					setTimeout('parent.location.reload()', 1000);
					</script>
					";
				} else {
					$this->load->view('admin/faq/faq_write');
				}
			} else {
				?>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<script>
				alert('운영자 페이지입니다.');
				location="<?=SV1_DIR?>";
				</script>
				<?
			}
		} else {
			//로그인후 리턴페이지
			$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath_encode=base64_encode($rpath);
			?>
			<script>
			location="<?=SV1_DIR?>/session/login/gateway/<?=$rpath_encode?>";
			</script>
			<?
		}
	}

}

?>