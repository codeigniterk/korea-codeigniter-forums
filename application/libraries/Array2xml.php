<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
    include_once("class.array2xml2array.php");

    $admins = array("admin1", "admin2", "admin3");
    $config = array("config" => array(
                            "filepath" => "/tmp",
                            "interval" => 5,
                            "admins"=>$admins));

    $array2XML = new CArray2xml2array();

    // no root
    $array2XML->setArray($admins);
    if ($array2XML->saveArray("admins.xml", "admins")){
        echo "admins array save<br>";
    }

    // one root
    $array2XML->setArray($config);
    if($array2XML->saveArray("config.xml")){
        echo "config array save<br>";
    }
*/
class array2xml {

/*
 * XML Array
 * @var array
 * @access private
 */
private $XMLArray;

/*
 * array is OK
 * @var bool
 * @access private
 */
private $arrayOK;

/*
 * XML file name
 * @var string
 * @access private
 */
private $XMLFile;

/*
 * file is present
 * @var bool
 * @access private
 */
private $fileOK;

/*
 * DOM document instance
 * @var DomDocument
 * @access private
 */
private $doc;

/**
 * Constructor
 * @access public
 */

public function __construct(){

}

/**
 * setteur setXMLFile
 * @access public
 * @param string $XMLFile
 * @return bool
 */

public function setXMLFile($XMLFile){
	if (file_exists($XMLFile)){
		$this->XMLFile = $XMLFile;
		$this->fileOK = true;
	}else{
		$this->fileOK = false;
	}
	return $this->fileOK;
}

/**
 * saveArray
 * @access public
 * @param string $XMLFile
 * @return bool
 */

public function saveArray($XMLFile, $rootName="", $encoding="utf-8", $filepath){
	global $debug;
	$this->doc = new DOMDocument("1.0", $encoding);
	$arr = array();
	if (count($this->XMLArray) > 1){
		if ($rootName != ""){
			$root = $this->doc->createElement($rootName);
		}else{
			$root = $this->doc->createElement("root");
			$rootName = "root";
		}
		$arr = $this->XMLArray;
	}else{

		$key = key($this->XMLArray);
		$val = $this->XMLArray[$key];

		if (!is_int($key)){
			$root = $this->doc->createElement($key);
			$rootName = $key;
		}else{
			if ($rootName != ""){
				$root = $this->doc->createElement($rootName);
			}else{
				$root = $this->doc->createElement("root");
				$rootName = "root";
			}
		}
		$arr = $this->XMLArray[$key];
	}

	$root = $this->doc->appendchild($root);

	$this->addArray($arr, $root, $rootName);

/*        foreach ($arr as $key => $val){
		$n = $this->doc->createElement($key);
		$nText = $this->doc->createTextNode($val);
		$n->appendChild($nodeText);
		$root->appendChild($n);
	}
*/
	$result = $this->doc->save($filepath.$XMLFile);
	if ($result == 0){
		return false;
	}else{
		return true;
	}
}

/**
 * addArray recursive function
 * @access public
 * @param array $arr
 * @param DomNode &$n
 * @param string $name
 */

function addArray($arr, &$n, $name=""){
	foreach ($arr as $key => $val){
		if (is_int($key)){
			if (strlen($name)>1){
				$newKey = substr($name, 0, strlen($name)-1);
			}else{
				$newKey="item";
			}
		}else{
			$newKey = $key;
		}

		$node = $this->doc->createElement($newKey);
		if (is_array($val)){
			$this->addArray($arr[$key], $node, $key);
		}else{
			$nodeText = $this->doc->createTextNode($val);
			$node->appendChild($nodeText);
		}
		$n->appendChild($node);
	}
}


/**
 * setteur setArray
 * @access public
 * @param array $XMLArray
 * @return bool
 */

public function setArray($XMLArray){
	if (is_array($XMLArray) && count($XMLArray) != 0){
		$this->XMLArray = $XMLArray;

		$this->arrayOK = true;
	}else{
		$this->arrayOK = false;
	}
	return $this->arrayOK;
}

}//End of the class
?>