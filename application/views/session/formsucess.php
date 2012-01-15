<?=$this->load->view('top');?>

<h3>id <?=$this->input->post('user_id')?> Your form was successfully submitted!</h3>

<p><?php echo anchor('session/login', 'Try it again!'); ?></p>

<?=$this->load->view('bottom');?>