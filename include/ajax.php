<?
print_r($_POST);
if($_POST['mode'] == 'module_use') {
	if($_POST['module_id'] == 'N') {
		$arg = 'Y';
	} else {
	    $arg = 'N';
	}
	$as = array('module_use' => $arg);
	$this->db->where('no', $module_no);
	$this->db->update('modules', $as);
}
?>