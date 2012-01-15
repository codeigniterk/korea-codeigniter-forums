<?php
/**
* XML Reader Use XML Parser
*
* @copyright Copyright (c) 2009 ICMS Inc, Seugnhyun Yang
* Created on 2009. 4. 1.
* @author Seunghyun Yang <alvajini@gmail.com>
* @package admin
* @subpackage libraries
* @category xml
* @version 0.1
*/

class Xml_reader {
	var $tValue = "";
	var $fileName = "";
	var $charSet = array ();
	var $tArray = array ();
	var $xmlData = array ();
	var $xmlDocument = null;

	function Xml_reader() {
		$this->xmlDocument = new XMLReader();
	}

	/**
	 * XML 파일 로드
	 *
	 * XML 에서 파싱해서 나온 결과는 한글이 깨지므로 인코딩 해준다.
	 * @param $fileName XML 파일 문서 이름(경로포함)
	 * @param $encode 인코딩셋(기본 UTF-8)
	 * @param $decode 디코딩셋(기본 EUC-KR)
	 * @return $xmlDocument
	 */
	function load($fileName) {
/* EUC-KR처리가 필요할때 사용
	function load($fileName,$encode="UTF-8",$decode="EUC-KR") {
		$this->charSet["encode"] = $encode;
		$this->charSet["decode"] = $decode;
*/
		$this->fileName = $fileName;

		if ($this->isload()) {
			return $this->xmlDocument;
		} else {
			echo "xml파일을 읽을수 없습니다.";
		}
	}

	function isload() {
		return $this->xmlDocument->open($this->fileName);
	}

	/**
	 * XML paser
	 *
	 * 노드부분으로 처리를 해야하지만 기본 클래스이므로 추후에 추가하도록 한다.
	 * 속성이 있는 노드를 탐색 최상 노드부터 최하위 노드까지 탐색후
	 * 속성의 값과 이름으로 assoc 배열을 리턴
	 *
	 * @param $doc XML Document
	 * @param $pathName Start Node name
	 * @return assoc XML DATA Array
	 */
	function parse($doc, $pathName = "") {
		// 페이지내 여러번 사용을 위한 초기화
		$this->xmlData = "";

		/** 노드 수만큼 루프 */
		while ($doc->read()) {
			/** 노드 타입별 분류 */
			switch ($doc->nodeType) {
				/** 엘레멘트 */
				case XMLReader :: ELEMENT :
					/** 엘레멘트 이름 추출 */
					$this->tValue = $doc->name;
					/** 특정 pathName이 있다면 자신과 자식 노드를 배열로 */
					if ($this->tValue == $pathName) {
						/** 속성이 있는 노드라면 */
						if ($doc->hasAttributes) {
							/** 노드만큼 루프를 돌면서 다음 속성 노드로 이동 */
							while ($doc->moveToNextAttribute()) {
								/** assoc배열을 위해 1차 배열로 넣는다.*/
								/* EUC-KR일때 사용
								$this->tArray[$doc->name] = iconv($this->charSet["encode"], $this->charSet["decode"], $doc->value);
								*/
								$this->tArray[$doc->name] = $doc->value;
							}
							/** 엘레멘트 노드 이름으로 배열을 넣는다(2차) */
							$this->xmlData[$this->tValue] = $this->tArray;
						}

						// 자식 노드 추가..
						while ($doc->read()) {
							switch ($doc->nodeType) {
								case XMLReader :: ELEMENT :
									/** 엘레멘트 이름 추출 */
									$this->tValue = $doc->name;
									/** 속성이 있는 노드라면 */
									if ($doc->hasAttributes) {
										/** 노드만큼 루프를 돌면서 다음 속성 노드로 이동 */
										while ($doc->moveToNextAttribute()) {
											/** assoc배열을 위해 1차 배열로 넣는다.*/
											/* EUC-KR일때 사용
											$this->tArray[$doc->name] = iconv($this->charSet["encode"], $this->charSet["decode"], $doc->value);
											*/
											$this->tArray[$doc->name] = $doc->value;
										}
										/** 엘레멘트 노드 이름으로 배열을 넣는다(2차) */
										$this->xmlData[$this->tValue] = $this->tArray;
									}
									break;
								case XMlReader :: END_ELEMENT :
									if ($doc->name == $pathName)
										return $this->xmlData;
									break;
							}
						}
					}
					/** 특정 노드를 탐색이므로 아래 처리는 하지 않는다. */
					if ($pathName != "")
						break;

					/** 속성이 있는 노드라면 */
					if ($doc->hasAttributes) {
						/** 노드만큼 루프를 돌면서 다음 속성 노드로 이동 */
						while ($doc->moveToNextAttribute()) {
							/** assoc배열을 위해 1차 배열로 넣는다.*/
							/* EUC-KR일때 사용
							$this->tArray[$doc->name] = iconv($this->charSet["encode"], $this->charSet["decode"], $doc->value);
							*/
							$this->tArray[$doc->name] = $doc->value;
						}
						/** 엘레멘트 노드 이름으로 배열을 넣는다(2차) */
						$this->xmlData[$this->tValue] = $this->tArray;
					}
					break;
			}
		}
		$this->xmlDocument->close();
		return $this->xmlData;
	}

	/**
	 * PLUGIN configuration XML paser
	 *
	 * 플러그인 설정값을 배열로 반환
	 *
	 * @param $xml_file XML Document
	 * @return assoc XML DATA Array
	 */
	function formatXML($xml_file) {
    	$xml = simplexml_load_file($xml_file);

    	// Loop through all controllers in the XML file
    	$controllers = array();

    	foreach($xml->controllers as $controller):
    		$controller = $controller->controller;
    		$controller_array['name'] = (string) $controller->attributes()->name;

    		// Store methods from the controller
    		$controller_array['methods'] = array();
    		
    		if($controller->method):
    			// Loop through to save methods
    			foreach($controller->method as $method) $controller_array['methods'][] = (string) $method;
			endif;

			// Save it all to one variable
    		$controllers[$controller_array['name']] = $controller_array;
    	endforeach;
		$Element = array();

		$Element = array();

		foreach ($xml->children() as $noad ):
			$key = $noad->getName();
			$value = (string) $xml->$key;
			$Element[$key] = $value;
		endforeach;

		$Element['version'] = (float) $xml->attributes()->version;		
		$Element['controllers'] = $controllers;
		
    	return $Element;
    }

	function skinformatXML($xml_file) {
    	$xml = @simplexml_load_file($xml_file);

    	// Loop through all controllers in the XML file
    	$controllers = array();

    	foreach($xml->controllers as $controller):
    		$controller = $controller->controller;
    		$controller_array['name'] = (string) $controller->attributes()->name;

    		// Store methods from the controller
    		$controller_array['methods'] = array();
    		if($controller->method):
    			// Loop through to save methods
    			foreach($controller->method as $method) $controller_array['methods'][] = (string) $method;
			endif;

			// Save it all to one variable
    		$controllers[$controller_array['name']] = $controller_array;
    	endforeach;

    	return array(
    		'name'			=>	(string) $xml->name,
    		'version' 		=> 	(float) $xml->attributes()->version,
    		'description' 	=> 	(string) $xml->description,
			'author'		=>	(string) $xml->author,
			'date'			=>	(string) $xml->date,
    		'icon' 			=> 	(string) $xml->icon,
    		'width'			=>	(string) $xml->width,
    		'height'		=> (string) $xml->height,
			'dependent'		=> 	(string) $xml->dependent,
			'container_width' => (string) $xml->container_width,
			'location' 	=> (string) $xml->location,
    	);
    }
}
?>