<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * xml2array Class
 *
 * This class converts XML data to array representation.
 *
 * $this->load->library('xml2array');
 * $xml_array = $this->xml2array->parse($xml);
 */
class Xml2array
{
    var $xml_parser;
    var $xml_input=null;

    var $elements = array();
    var $index_arr = array();
    var $ref;

    /**
    * @desc Constructor
    * @param string
    */
    function xml2array($xml=null){
        $this->xml_input = $xml;
    }
    /**
    * @desc Parsing function
    * @param string
    */
    function parse($xml=null){
        $this->xml_input = $xml;
        if($this->xml_input==null){
            return false;
        }
        $this->xml_parser = xml_parser_create();
        xml_set_object($this->xml_parser, $this);
        xml_set_element_handler($this->xml_parser,"startElement","endElement");
        xml_set_character_data_handler($this->xml_parser,"characterData");
        if(!xml_parse($this->xml_parser, $this->xml_input)){
            return false;
        }
        xml_parser_free($this->xml_parser);
        return $this->elements;
    }

    function startElement($parser,$tagName,$attrs){
        $this->ref=&$this->elements;
        foreach($this->index_arr as $index){
            $this->ref = &$this->ref[$index];
        }
        $this->ref[] = array('tag'=>$tagName,'attr'=>$attrs,'data'=>'','children'=>array());
        $i = end(array_keys($this->ref));
        array_push($this->index_arr,$i);
        array_push($this->index_arr,'children');
    }

    function characterData($parser, $data){
        $index_arr = $this->index_arr;
        array_pop($index_arr);
        $ref=&$this->elements;
        foreach($index_arr as $index){
            $ref = &$ref[$index];
        }
        $ref['data']=$data;
    }

    function endElement($parser,$tagName){
        array_pop($this->index_arr);
        array_pop($this->index_arr);
    }
}
?>