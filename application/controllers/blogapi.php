<?php
class Blogapi extends Controller{
    function Blogapi(){
        parent::Controller();
        $this->load->model('blogapi_model');
    }

    function index(){
        $this->blogapi_model->send_req();
    }
}
?>