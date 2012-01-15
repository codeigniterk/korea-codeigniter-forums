<?php
class Blogapi_model extends Model{
    function Blogapi_model(){
         parent::Model();
         $this->load->library('xmlrpc');
    }

    function send_req(){
        $this->xmlrpc->set_debug(TRUE);
        $this->xmlrpc->server("https://api.blog.naver.com/xmlrpc");
        $this->xmlrpc->method('metaWeblog.newPost');
		//$this->xmlrpc->xmlrpc_defencoding = "iso-8859-1";
        $struct = array(
            "title" => array('title', 'string'),
            "description"	=> array('subject', 'string')
        );
        $request = array (
            array("esiyon0108", "string"), //blog id
            array("esiyon0108", "string"), //user id
            array("134e0c01ea6a6849ece6e463ed75ad31", "string"), //api password
            array($struct, "struct"), //작성할 글내용
            array(TRUE, "boolean") //공개여부
        );
        $this->xmlrpc->request($request);
        if ($this->xmlrpc->send_request()) {
            echo "success";
        } else {
            echo $this->xmlrpc->display_error();
        }
    }
}
?>