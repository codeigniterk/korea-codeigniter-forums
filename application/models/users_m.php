<?PHP
/**
 * @author Jongwon Byun <blumine@paran.com>
 */

class Users_model extends Model {

    function Users_model()
    {
        // Call the Model constructor
        parent::Model();
    }

	function my_list($arg='board_qna')
	{
		$where = "";

		$this->db->order_by('reg_date', 'desc');
		$this->db->limit(15);
		//$this->db->limit($rp, $page);
		/*
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
		*/
  		$where .= "(is_delete='N' and original_no='0')";
  		$this->db->where($where);

		$query = $this->db->get($arg);

        return $query->result_array();
	}

	function my_reply()
	{
		if ($post) {
			$this->db->like($post["method"], $post["s_word"]);
  		}
  		$this->db->where(array('is_delete'=>'N', 'original_no'=>'0'));

		$query = $this->db->get($this->table);

        return $query->num_rows();
	}
}

?>
