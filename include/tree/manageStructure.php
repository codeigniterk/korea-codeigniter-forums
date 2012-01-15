<?php
/********************************************
*
*	Filename:	manageStructure.php
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Sunday, July 6, 2008  20:21
*
*********************************************/

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) 
{
	$action = $_REQUEST['action'];	
}
else 
{
	die(FAILED);
}
define("IN_PHP", true);

require_once("common.php");

$out = NULL;

switch($action)
{
	case "insertElement":
	{	
		/**
		 * insert new element
		 */	
		if ( ( isset($_POST['name']) === true && $_POST['name'] != NULL )  &&
		     ( isset($_POST['ownerEl']) === true && $_POST['ownerEl'] != NULL )  &&
	         ( isset($_POST['slave']) === true && $_POST['slave'] != NULL )		   
		   )
		{				
			$ownerEl = (int) checkVariable($_POST['ownerEl']);
			$slave = (int) checkVariable($_POST['slave']);
			$name = checkVariable($_POST['name']);			
	
			$sql = sprintf('INSERT INTO ' 
								. TREE_TABLE_PREFIX . '_elements(name, position, ownerEl, slave)
							SELECT 
								\'%s\', ifnull(max(el.position)+1, 0), %d, %d 
							FROM '
								. TREE_TABLE_PREFIX . '_elements el 
							WHERE 
								el.ownerEl = %d ',
							$name , $ownerEl, $slave, $ownerEl);
			
	        if (defined("DEMO_MODE")) 
			{
				$insertId = rand(0, 10000);				
				$out =  '({ "elementId":"'.$insertId.'", "elementName":"'.$name.'", "slave":"'.$slave.'"})';
			}      
			else if ($db->query($sql) == true) {
				$out = '({ "elementId":"'.$db->lastInsertId().'", "elementName":"'.$name.'", "slave":"'.$slave.'"})';
			}
			else {
				$out = FAILED;
			}
		}
		else {
			$out = FAILED; 
		}
	}
	break;	
	case  "getElementList":  
	{
		/**
		 * getting element list
		 */
        if( isset($_REQUEST['ownerEl']) == true && $_REQUEST['ownerEl'] != NULL ) {  	
			$ownerEl = (int) checkVariable($_REQUEST['ownerEl']); 
		}
		else {
			$ownerEl = 0;
		}
		
        $sql = sprintf("SELECT 
        					Id, name, slave 
        				FROM " 
        					. TREE_TABLE_PREFIX . "_elements
		      			WHERE
		      				ownerEl = %d  
		      			ORDER BY
		      				position ",
        				$ownerEl);
	  
		if (defined("DEMO_MODE")) 
		{
			$out = "<li class='text' id='14'><span>file-1</span></li><li class='text' id='15'>".
					"<span>file-2</span></li><li class='text' id='16'><span>file-3</span></li>";
		}
		else {			
        	$out = getElementList($db, $sql, $_SERVER['PHP_SELF']);
		}
		
		if ($out === false) 
        {	   			
        	$out = FAILED; 	
	    }            
    }
	break;		
    case "updateElementName":
    {
    	/**
    	 * Changing element name
    	 */
		if (isset($_POST['name']) && !empty($_POST['name']) &&
		    isset($_POST['elementId']) && !empty($_POST['elementId']))
		{			
			$name = checkVariable($_POST['name']);
			$elementId = (int) checkVariable($_POST['elementId']); 			
			
        	$sql = sprintf('UPDATE ' 
        						. TREE_TABLE_PREFIX.'_elements 
							SET 
								name = \'%s\'
					    	WHERE 
					    		Id = %d ',
        					$name, $elementId);
        					
		    if (defined("DEMO_MODE")) 
		    {
		    	$out = '({"elementName":"'.$name.'", "elementId":"'.$elementId.'"})';
		    }
			else if ($db->query($sql) == true) {
				$out = '({"elementName":"'.$name.'", "elementId":"'.$elementId.'"})';
			}
			else {
				$out = FAILED;
			}					
		}                         
		else {
			$out = FAILED;	
		}
    }    
    break;

	case "deleteElement":
	{
		/**
		 * deleting an element and elements under it if exists
		 */
		if (isset($_POST['elementId']) && !empty($_POST['elementId']))
		{
        	$elementId = (int) checkVariable($_POST['elementId']);	 
        	              
			if (defined("DEMO_MODE")) 
			{
			 	$out = SUCCESS;	
			}        	
			else if (deleteData($db, $elementId) === true) {				
				$out = SUCCESS; 
			}
			else {
				$out = FAILED;
			}                
        }
        else {
			$out = FAILED;	
		}
	}
	break;
	case "changeOrder":
	{		
		/**
		 * Change the order of an element
		 */
		if ((isset($_POST['elementId']) && $_POST['elementId'] != NULL) &&
			(isset($_POST['destOwnerEl']) && $_POST['destOwnerEl'] != NULL) &&
			(isset($_POST['position']) && $_POST['position'] != NULL) 
			)			
		{
			
			$elementId = (int) checkVariable($_POST['elementId']);
			$destOwnerEl = (int) checkVariable($_POST['destOwnerEl']);
			$position = (int) checkVariable($_POST['position']);
			
			$sql = sprintf('SELECT
						 		ownerEl, position 
							FROM '
								. TREE_TABLE_PREFIX . '_elements 
							WHERE 
								Id = %d
							LIMIT 1',
							$elementId);
			if (defined("DEMO_MODE")) 
			{
			 	$out = SUCCESS;	
			}  			
			else if ($result = $db->query($sql))
			{			
				if ($element = $db->fetchObject($result))
				{						
					$sql1 = sprintf('UPDATE '
										 . TREE_TABLE_PREFIX . '_elements 
									 SET 
									 	position = position - 1
									 WHERE  
									 	position > %d
									    AND
									    ownerEl = %d ',
									 $element->position, $element->ownerEl);
							   
					$sql2 = sprintf('UPDATE '
										. TREE_TABLE_PREFIX . '_elements 
									 SET 
									 	position = position + 1
									 WHERE
							 			 position >= %d 
									   	 AND
									   	 ownerEl = %d ',
									 $position, $destOwnerEl);
							   
					$sql3 = sprintf('UPDATE '
										. TREE_TABLE_PREFIX . '_elements 
									 SET 
									 	position = %d , ownerEl = %d
									 WHERE 
									 	Id = %d ',
										$position, $destOwnerEl, $elementId);
	
					
					if ($db->query($sql1) && $db->query($sql2) && $db->query($sql3)) {					
						$out = SUCCESS;
					}
					else {						
						$out = FAILED;
					}		
				}
				else{
					$out = FAILED;
				}	
			}
			else{
				$out = FAILED;
			}		
		}
		else{		
			$out = FAILED;
		}			
	}
	break;		
    default:
    	/**
    	 * if an unsupported action is requested, reply it with FAILED
    	 */
      	$out = FAILED;
	break;
}
echo $out;
