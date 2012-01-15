<?php

class Ckeditor extends Controller {

	public $data 	= 	array();

	public function __construct() {

		parent::Controller();

		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');

		//Ckeditor's configuration
		$this->data['ckeditor'] = array(

			//ID of the textarea that will be replaced
			'id' 	=> 	'content', 	// Must match the textarea's id
			'path'	=>	'include/ckeditor',	// Path to the ckeditor folder relative to index.php

			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"550px",	//Setting a custom width
				'height' 	=> 	'100px',	//Setting a custom height

			),

			//Replacing styles from the "Styles tool"
			'styles' => array(

				//Creating a new style named "style 1"
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Blue',
						'font-weight' 		=> 	'bold'
					)
				),

				//Creating a new style named "style 2"
				'style 2' => array (
					'name' 		=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)
			)
		);


	}

	public function index() {

		$this->load->view('ckeditor', $this->data);

	}
}