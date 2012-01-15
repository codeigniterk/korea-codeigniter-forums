<?=validation_errors()?>

<?=form_open($this->uri->uri_string())?>

Name: <?=form_input('name',set_value('name'))?>

<?=form_submit("Save","Save")?>
<?=form_close()?>

<?
$CI =& get_instance();
//$CI->load->library("database");
$CI->load->model("admin_m");

$aa = $CI->admin_m->ts();
echo "<BR>".$aa."---";
?>
