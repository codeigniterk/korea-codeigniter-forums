<?
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Common
{

	var $CI;
	var $result_str;

	function trim_text($str,$len,$tail="..")
	{
		 if(strlen($str)<$len) {

			return $str; //자를길이보다 문자열이 작으면 그냥 리턴

		 } else{
			$result_str='';
			for($i=0;$i<$len;$i++){
			if((Ord($str[$i])<=127)&&(Ord($str[$i])>=0)){$result_str .=$str[$i];}
			else if((Ord($str[$i])<=223)&&(Ord($str[$i])>=194)){$result_str .=$str[$i].$str[$i+1];$i+1;}
			else if((Ord($str[$i])<=239)&&(Ord($str[$i])>=224)){$result_str .=$str[$i].$str[$i+1].$str[$i+2];$i+2;}
			else if((Ord($str[$i])<=244)&&(Ord($str[$i])>=240)){$result_str .=$str[$i].$str[$i+1].$str[$i+2].$str[$i+3];$i+3;}
			}

			return $result_str.$tail;

		}

	}
	/**
	* checkmb=true, len=10
	* 한글과 Eng (한글=2*3 + 공백=1*1 + 영문=1*1 => 10)
	* checkmb=false, len=10
	* 한글과 Englis (모두 합쳐 10자)
	*/
	function strcut_utf8($str, $len, $checkmb=false, $tail='..') {
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

		$m = $match[0];
		$slen = strlen($str); // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters

		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;

		$ret = array();
		$count = 0;

		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;

			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}

		return join('', $ret).$tail;
	}

	function get_site_info() //사이트정보
    {
	    $this->CI =& get_instance();

		$domain = $_SERVER['HTTP_HOST'];
		$query = $this->CI->db->get_where('site_admin', array('domain' => $domain));
		$rows = $query->row();
		return $rows->admin_no;
	}

	function segment_explode($seg) { //세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
		$len = strlen($seg);
		if(substr($seg, 0, 1) == '/') {
			$seg = substr($seg, 1, $len);
		}
		$len = strlen($seg);
		if(substr($seg, -1) == '/') {
			$seg = substr($seg, 0, $len-1);
		}
		$seg_exp = explode("/", $seg);
		return $seg_exp;
	}

	function admin_menu($menu)
	{
	    $this->CI =& get_instance();

		/**
		 * 메뉴 xml파일 로드하여 $this->data['menulist']데이터 생성
		 * 파일이 없다면 기본 메뉴를 가져온다.
		 */

		$xmlfile = DATA_ROOT . "/". ADMIN_ID . "/admin_menu.xml";

		if(!is_file($xmlfile)) {
			copy(DATA_ROOT.'/admin_menu.xml', $xmlfile);
		}

		$this->CI->load->library('xml_reader');
		$doc = $this->CI->xml_reader->load($xmlfile);

		return $this->CI->xml_reader->parse($doc, $menu);
	}

	function pagination($link, $paging_data) {
        $links = "";

        // The first page
        $links .= anchor($link . '/' . $paging_data['first'], 'First', array('title' => 'Go to the first page', 'class' => 'first_page'));
        $links .= "\n";
        // The previous page
        $links .= anchor($link . '/' . $paging_data['prev'], '<', array('title' => 'Go to the previous page', 'class' => 'prev_page'));
        $links .= "\n";

        // The other pages
        for ($i = $paging_data['start']; $i <= $paging_data['end']; $i++) {
            if ($i == $paging_data['page'])
                $current = '_current';
            else
                $current = "";

            $links .= anchor($link . '/' . $i, $i, array('title' => 'Go to page ' . $i, 'class' => 'page' . $current));
            $links .= "\n";
        }

        // The next page
        $links .= anchor($link . '/' . $paging_data['next'], '>', array('title' => 'Go to the next page', 'class' => 'next_page'));
        $links .= "\n";
        // The last page
        $links .= anchor($link . '/' . $paging_data['last'], 'Last', array('title' => 'Go to the last page', 'class' => 'last_page'));
        $links .= "\n";

        return $links;
    }

    /**
    * 내용중에서 이미지명 추출후 DB 입력, 파일갯수 리턴. fckeditor용
    */
    function strip_image_tags_fck($str, $no, $type, $table, $table_no)
	{
		$CI =& get_instance();
		$file_table="files";
		preg_match_all("<img [^<>]*>", $str, $out, PREG_PATTERN_ORDER);
		$strs = $out[0];
		//$arr=array();
		$cnt = count($strs);
		for ($i=0;$i<$cnt;$i++) {
  			$arr = preg_replace("#img\s+.*?src\s*=\s*[\"']\s*\/data/images/\s*(.+?)[\"'].*?\/#", "\\1", $strs[$i]);
  			$data = array(
			  			'module_id'=> $table_no,
						'module_name'=> $table,
						'module_no'=>$no,
						'module_type'=>$type,
						'file_name'=>$arr,
  						'reg_date'=>date("Y-m-d H:i:s")
			  			);
			if ( count($arr) <= 25 ) {
				$CI->db->insert($file_table, $data);
			}

  		}
		return $cnt;
	}
}
?>