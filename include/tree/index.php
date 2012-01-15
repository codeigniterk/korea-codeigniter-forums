<?php
/********************************************
*
*	Filename:	index.php
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Tuesday, Feb 23, 2009  10:21
*
*********************************************/

define("IN_PHP", true);

require_once("common.php");

$sql = 'SELECT
			Id, name, slave
		FROM '
			. TREE_TABLE_PREFIX .'_elements
		WHERE
			ownerEl = 0
		ORDER BY
			position';

$rootName = "Root";
if (defined("DEMO_MODE"))
{
	$treeElements = "<li class='text' id='4'>"
						."<span>Folder-1</span>"
						."<ul class='ajax'>"
							."<li id='4'>{url:manageStructure.php?action=getElementList&ownerEl=4}</li>"
						."</ul>"
					."</li>"
					."<li class='text' id='12'>"
						."<span>Folder-2</span>"
						."<ul class='ajax'>"
							."<li id='12'>{url:manageStructure.php?action=getElementList&ownerEl=12}</li>"
						."</ul>"
					."</li>"
					."<li class='text' id='13'>"
						."<span>Folder-3</span>"
							."<ul class='ajax'>"
								."<li id='13'>{url:manageStructure.php?action=getElementList&ownerEl=13}</li>"
							."</ul>"
						."</li>";
}
else {
	$treeElements = getElementList($db, $sql, "manageStructure.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="keywords"  content="" />
<meta name="description" content="" />
<title>Editable jquery tree with php codes</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/jquery/plugins/simpleTree/style.css" />
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/style.css" />
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/jquery/jquery-pack.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/jquery/plugins/simpleTree/jquery.simple.tree.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/langManager.js" ></script>

<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/treeOperations.js"></script>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST']?>/include/tree/js/init.js"></script>
</head>
<body>

<div class="contextMenu" id="myMenu1">
		<li id="addFolder">
			<img src="js/jquery/plugins/simpleTree/images/folder_add.png" /> </li>
		<li id="addDoc"><img src="js/jquery/plugins/simpleTree/images/page_add.png" /> </li>
		<li id="edit"><img src="js/jquery/plugins/simpleTree/images/folder_edit.png" /> </li>
		<li id="delete"><img src="js/jquery/plugins/simpleTree/images/folder_delete.png" /> </li>
</div>
<div class="contextMenu" id="myMenu2">
		<li id="edit"><img src="js/jquery/plugins/simpleTree/images/page_edit.png" /> </li>
		<li id="delete"><img src="js/jquery/plugins/simpleTree/images/page_delete.png" /> </li>
</div>

<div id="wrap">
	<div id="annualWizard">
			<ul class="simpleTree" id='pdfTree'>
					<li class="root" id='0'><span><?php echo $rootName; ?></span>
						<ul>
							<?php echo $treeElements; ?>
						</ul>
					</li>
			</ul>
	</div>
</div>
<div id='processing'></div>
</body>
</html>