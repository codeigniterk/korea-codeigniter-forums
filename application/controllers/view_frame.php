 <?
class View_frame extends Controller {
	function View_frame() {
		parent::Controller();
	}

	function index($files) {
		$strs = array('<?php', '<?', '?>');
		if(file_exists(APPPATH."/controllers/manual_source/".$files."_lib.php")){
			$data['source'] = htmlspecialchars(str_replace($strs, "", file_get_contents(APPPATH."/controllers/manual_source/".$files."_lib.php")));
			$data['files'] = $files."_lib";
			$data['urls'] = BASEURL."user_guide/libraries/".$files.".html";
		} else if(file_exists(APPPATH."/controllers/manual_source/".$files."_hlp.php")){
			$data['source'] =  htmlspecialchars(str_replace($strs, "", file_get_contents(APPPATH."/controllers/manual_source/".$files."_hlp.php")));
			$data['files'] = $files."_hlp";
			$data['urls'] = BASEURL."user_guide/helpers/".$files."_helper.html";
		}  else if(file_exists(APPPATH."/controllers/manual_source/".$files."_gnl.php")){
			$data['source'] =  htmlspecialchars(str_replace($strs, "", file_get_contents(APPPATH."/controllers/manual_source/".$files."_gnl.php")));
			$data['files'] = $files."_gnl";
			$data['urls'] = BASEURL."user_guide/general/".$files.".html";
		}
		$dfiles = explode("_", $files);
		//$data['files'] = $dfiles[0];

		$this->load->view('view_frame_v', $data);
	}

	function test() {
		$dd = uri_string();
		echo $dd;
	}

}
?>