<?php
class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper('html');
		$this->load->helper('text');
		$this->load->helper('date');

		$this->load->model('admin_m');

		if ($this->session->userdata('userid'))
		{
			if ($this->session->userdata('auth_code') < '15')
			{
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
				echo "<script>";
				echo "	alert('운영자 페이지입니다.');";
				echo "	location=\"" . HOST_DIR . "\"";
				echo "</script>";
			}
		}
		else
		{
			/*
			* 로그인 후 페이지 리다이렉트 관련 수정
			* modified by kwangmyung, choi at 2009.06.30
			*/
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode = url_code($rpath, 'e');
			echo "<script>";
			echo "	location=\"" . HOST_DIR . "/auth/login/" . $rpath_encode . "\"";
			echo "</script>";

		}

	}

	function index()  //회원 관리
	{
		$this->load->library('pagination');
		$config['page_query_string']=FALSE;

		$config['uri_segment'] = 4;
		$data['perPage']=$config['per_page']='15'; //페이지당 리스트 노출갯수
		$config['base_url']=site_url('admin/main/index/'); //페이징처리 링크주소
		$page=$offset = $this->uri->segment(4, 0);

		if( $this->input->post('search_word', true) )
		{
			$data['mlist'] = $this->admin_m->member_list('all', $this->input->post('search_word'), $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('all', $this->input->post('search_word'), $offset, $config['per_page']);
		}
		else
		{
			$data['mlist'] = $this->admin_m->member_list('all', '', $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('all', 'all_keyword', '', '');
		}

		$this->pagination->initialize($config);
		$data['pagenav'] = $this->pagination->create_links();

		$this->load->view('top_v');
		$this->load->view('admin/topnav_v');
		$this->load->view('admin/member_v', $data);
		$this->load->view('bottom_v');
	}

	//게시판 리스트
	function board()
	{
		$this->load->library('pagination');
		$config['page_query_string']=FALSE;

		$config['uri_segment'] = 4;
		$data['perPage']=$config['per_page']='15'; //페이지당 리스트 노출갯수
		$config['base_url']=site_url('admin/main/board/'); //페이징처리 링크주소
		$page=$offset = $this->uri->segment(4, 0);

		if( $this->input->post('search_word', true) )
		{
			$data['mlist'] = $this->admin_m->board_list('all', $this->input->post('search_word'), $offset, $config['per_page']);
			$data['getTotalData']=$config['total_rows']=$this->admin_m->board_list_count('all', $this->input->post('search_word'), $offset, $config['per_page']);
		}
		else
		{
			$data['mlist'] = $this->admin_m->board_list('all', '', $offset, $config['per_page']);
			$data['getTotalData']=$config['total_rows']=$this->admin_m->board_list_count('all', 'all_keyword', '', '');
		}

		$this->pagination->initialize($config);
		$data['pagenav'] = $this->pagination->create_links();

		$this->load->view('top_v');
		$this->load->view('admin/topnav_v');
		$this->load->view('admin/board_list_v', $data);
		$this->load->view('bottom_v');
	}

	function master_add()  //운영자 추가
	{
		$this->load->library('form_validation');
		//폼검증 규칙 설정
		$config = array(
			array(
				'field'   => 'user_id',
				'label'   => '아이디',
				'rules'   => 'callback_userid_check'
				),
		    array(
				'field'   => 'user_nm',
				'label'   => '이름',
				'rules'   => 'required'
				),
		    array(
				'field'   => 'user_pw',
				'label'   => '패스워드',
				'rules'   => 'required|min_length[4]'
			    ),
		    array(
				'field'   => 'user_nickname',
				'label'   => '닉네임',
				'rules'   => 'callback_nick_check'
			    ),
			array(
				 'field'   => 'user_email',
				 'label'   => '이메일',
				 'rules'   => 'required'
				)
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/member/master_add_v');
		}
		else
		{
			if( $this->input->post('status_mode') == 'insert' )
			{
				$this->admin_m->master_add($this->input->post(NULL, true)); //운영자 추가 함수
?>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					//FrameDialog 닫기
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('입력되었습니다.')
					document.opener.reload();
				</script>
<?php
			}
			elseif( $this->input->post('status_mode') == 'delete' )
			{
				//삭제후 리퍼러 주소로..
			}
		}

	}

	function userid_check($id)  //아이디 체크 콜백함수
	{
		if (!$id)
		{
			$this->form_validation->set_message('userid_check', '아이디를 입력하세요.');
			return FALSE;
			exit;
		}
		//영어인지 체크
		if (strlen($id) < 4 or strlen($id) > 12)
		{
			$this->form_validation->set_message('userid_check', '아이디는 4자 이상, 12자 이하로 입력하세요.');
			return FALSE;
			exit;
		}

		$str = $this->admin_m->id_check($id);
		$noids = array('abroad','action','admin','administrator','africa','agency','agent','america','angel','ani','arkadio','art','asia','asiana','auction','auto','baby','backup','bank','baseball','bell','biz','blog','book','bookmark','brand','business','cafe','card','chat','city','collaboration','comic','community','consulting','contents','continent','codeigniter','cook','ceo','cto','cfo','corea','corp','creation','customer','cyber','cyworld','daewoo','daum','diary','directory','drama','dreamwiz','east','economy','emigrant','english','entertainment','europe','exchange','file','finance','flash','food','franchise','free','fuck','gallary','game','gay','global','gmarket','golf','google','group','gseshop','guest','hanatour','hangul','hanja','happy','health','help','hibori','home','homepage','homework','hotel','hyundai','imtel','inbound','index','info','intel','iriver','item','job','keyword','khan','kiamoters','king','koderi','koglian','koglo','korean','koreanair','kralliance','krgame','krnews','krtv','land','lesbian','life','living','local','login','logout','lorita','lotte','lotto','love','mail','main','mall','manager','maps','market','marketing','master','mbc','media','message','microsoft','middleeast','miz','model','modetour','movie','music','myhome','mypage','nate','nateon','nation','naver','netpia','network','news','newsnp','newspaper','north','nude','okmedia','oktour','on','oninfo','onket','open','opencafe','openmarket','outbound','paran','people','phone','photo','plan','planning','play','policy','poll','porno','pornosex','portal','prince','princess','privacy','process','qeen','radio','real','rent','resume','root','samsung','samsungcard','search','sex','sexporno','shinsegae','shop','shopping','south','southpacific','sports','star','stock','study','sysop','time','toolbar','toon','tour','trade','traffic','travel','vod','weather','webmaster','website','west','world','xxx','xxxx','xxxxxx');

		if ($str > 0)
		{
			$this->form_validation->set_message('userid_check', '중복된 아이디입니다.');
			return FALSE;
		}
		else if (in_array($id, $noids))
		{
			$this->form_validation->set_message('userid_check', '사용할 수 없는 아이디입니다.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function nick_check($ju) //닉네임 사용 체크 콜백
	{
		if (!$ju)
		{
			$this->form_validation->set_message('nick_check', '닉네임을 입력하세요.');
			return FALSE;
			exit;
		}

		if (strlen($ju) < 6 or strlen($ju) > 30)
		{
			$this->form_validation->set_message('nick_check', '닉네임은 2자이상 10자이하로 입력하세요.');
			return FALSE;
			exit;
		}

		$str = $this->admin_m->nick_check($ju);

		if ($str > 0)
		{
			$this->form_validation->set_message('nick_check', '중복된 닉네임입니다.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	//스패머 강제탈퇴
	function banned()
	{
		$bann_id = $this->uri->segment(4);

		if( $this->session->userdata('auth_code') >= 15 )
		{
			$arr = array(
				'password' => 'fsdfsdfs',
				'activated' => '0',
				'banned' => '1',
				'ban_reason' => 'speamer-작업자 : '.$this->session->userdata('nickname')
			);
			$this->db->where('id', $bann_id);
			$this->db->update('users', $arr);
			alert_close("강제탈퇴 완료");
		}
	}

}

/* End of file member.php */
/* Location:  /application/controllers/admin/member.php */
?>