// JavaScript Document
/********************************************
* 	Filename:	js/treeOperations.js
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Sunday, April 20, 2008  16:28
***********************************************/



/**
 * Operations used in tree structure
 */
var simpleTree;
var structureManagerURL = "manageStructure.php";
var dragOperation = true;
var operationFailed = "-1";

function TreeOperations()
{
	
	treeOps = this;
	this.ajaxActive = true;
	this.treeBusy = false;
	this.timer = 0;
	this.folderElement = false;
	this.lookAtFolderElement = false;

	
	this.inputText = "<input type='text' id='inputText' maxlength='30'>";
	this.inputId = '#inputText';
//*******************************************************	
	for (var n in arguments[0]) 
	{ 
		this[n] = arguments[0][n]; 
	}
//*******************************************************
	this.isTreeBusy = function()
	{
		if (this.treeBusy == true){
			alert(langManager.doOneOperationAtATime);
		}
		return (this.treeBusy);
	}
	this.setTreeBusy = function(busy)
	{
		this.treeBusy = busy;
	}
//**************************************************************
	this.showOperationInfo = function (text){
		
		$('#processing').html(text);		
		
		$('#processing').fadeIn(1, function(){			
			treeOps.timer = setTimeout("$('#processing').fadeOut(1000)", 1000);			
		});
		
	}
//*******************************************************
	this.showInProcessInfo = function(show)
	{
		if (show == true) {
			clearTimeout(treeOps.timer);
			$('#processing').hide();
			$('#processing').html(langManager.operationInProcess);
			$('#processing').show();
			
		}
		else {
			$('#processing').hide();
		}		
	}
//*******************************************************
	this.trGetSelected = function()
	{
		return simpleTree.get(0).getSelected();
	}


	this.trGetSelectedWithAlert = function()
	{
		var selectedNode = treeOps.trGetSelected();
		if (selectedNode.html() == null){
			alert(langManager.selectNode2MakeOperation);
			return null;
		}
		return selectedNode;
	}
//**********************************************************
//         YENI ELEMAN EKLEME FONKSIYONLARI
//**********************************************************
	this.trAddElement = function(result)
	{
		//treeOps.treeBusy = false; ajax makes it false
		var info;
		if (typeof(result) == "undefined")
		{
			info.id = "null";
			info.name = "undefined";
		}
		else {
			info = eval("(" + result + ")");
			//alert(info.elementName);
		}	
		
		$('#inputText').parent().attr('id', info.elementId);
		$('#inputText').replaceWith("<span>"+info.elementName+"</span>");
		
		simpleTree.get(0).setTreeNodes($('#'+info.elementId).get(0));
		
		if (info.slave == 0) { // eger dosya doc degilse klas�r yapiliyor.
			simpleTree.get(0).convertToFolder($("#"+info.elementId));
		}
	}    
	/////////////////////////////////////////////////////////////
	this.addElementReq = function(folder)
	{    // Menu de yeni eleman ekle se�enegi tiklandiginda ilk bura �agrilir 
		 // ve yeni bir yazi alani eklenir.
		
		if ( treeOps.isTreeBusy() == true ||  
			 treeOps.trGetSelectedWithAlert() == null
			) 
		{
			// aga�ta baska bir islem yapiliyorsa veya se�ili eleman 
			// yok ise islem yapilmasi engelleniyor
			return;
		}			
		dragOperation = false;
		
		
		
		if (treeOps.trGetSelected().get(0).className.indexOf('close') >= 0)
		{
			var childUl = $('>ul', treeOps.trGetSelected().get(0));
			if (childUl.is('.ajax')) {
				simpleTree.get(0).nodeToggle(treeOps.trGetSelected().get(0), treeOps.addElementReq);
				treeOps.lookAtFolderElement = true;
				treeOps.folderElement = folder;				
				return;
			}
			else {				
				simpleTree.get(0).nodeToggle(treeOps.trGetSelected().get(0));
			}
		}
		
		
		treeOps.treeBusy = true;	
		var content = $.trim($('ul', treeOps.trGetSelected()).html());

		if (content == "") 
		{
			// Klas�r�n alti bosken altina yeni eleman eklenemiyordu bu y�zden asagidaki kodlar yazildi.
			// eger IE de fazladan g�z�ken dosyanin g�z�kmemesi i�in son iki silme (remove) satiri eklendi.
			$('ul', treeOps.trGetSelected()).html('<li class="line"> </li><li class="doc-last"></li><li class="line-last"/>');
			
			simpleTree.get(0).addNode("newElement", "name", null);
			treeOps.trGetSelected().prev().remove();
			treeOps.trGetSelected().prev().remove();
		}
		else {
			simpleTree.get(0).addNode("newElement", "name", null);			
		}
		
		
		var slave = 1;
		
		if (treeOps.lookAtFolderElement == true){
			folder = treeOps.folderElement;
		}
		treeOps.lookAtFolderElement = false;
		
		if (folder == true) {
			simpleTree.get(0).convertToFolder(treeOps.trGetSelected());
			slave = 0;
		}
		
		treeOps.trGetSelected().html(treeOps.inputText);
		$('#inputText').focus();
		
		$('#inputText').bind("keypress", 
			 function(evt)
			 {												
				if (evt.keyCode == 13) // when pressed enter 
				{	
				    var name = $('#inputText').attr('value');										
					var ownerEl = $('#inputText').parent().parent().parent().attr('id');
					var params = encodeURI("action=insertElement"+"&name="+name+"&ownerEl="+ownerEl+"&slave="+slave);
					
					treeOps.ajaxReq(params, structureManagerURL, treeOps.trAddElement);
					dragOperation = true;
				}
				else if (evt.keyCode == 27) // when pressed esc 
				{	
				    
					treeOps.setTreeBusy(false);
					dragOperation = true;
					if ($('#inputText').parent().attr('class').indexOf('last')>=0) {
						var className = $('#inputText').parent().prev().prev().attr('class');
						$('#inputText').parent().prev().prev().attr('class',className+'-last');										
					}
					//$('#inputText').parent().prev().remove();
					$('#inputText').parent().remove();
				}
				//$('#inputText').unbind("keypress");
			}
			);		
	}
/*******************************************************
	ELEMAN SILME FONKSIYONLARI
********************************************************/
	this.trDeleteElement = function(result)
	{
		if (result != operationFailed)	{
			// component haline getirirken burayi �ikar
			if (treeOps.trGetSelected().attr('id') == $('#ownerElement').attr('value'))
			{			
				$('#activeElement').html('');
				$('#activeElement').removeClass('ajaxInfo');
				$('#ownerElement').attr('value', '');
				$('#action').attr('value','');
				tinyMCE.get('richTextArea').setContent('');
				contentChanged = false;
			}
			simpleTree.get(0).delNode();				
		}
		else{
			alert("Error in operation");
		}
	}
	/////////////////////////////////////////////////////
	this.deleteElementReq = function()
	{	
		if ( treeOps.isTreeBusy() == true ||  
			 treeOps.trGetSelectedWithAlert() == null
			) 
		{
			// aga�ta baska bir islem yapiliyorsa veya se�ili eleman 
			// yok ise islem yapilmasi engelleniyor
			return;
		}	
	
		if (confirm(langManager.deleteConfirm))
		{
			treeOps.treeBusy = true;
			var params = "action=deleteElement&elementId="+treeOps.trGetSelected().attr('id');
			treeOps.ajaxReq(params, structureManagerURL, treeOps.trDeleteElement);
		}	
	}
/*******************************************************	
	ELEMANIN ISMINI DEGISTIRME FONKSIYONLARI
*******************************************************/
	this.trUpdateElementName = function(result)
	{
		var info = eval('('+result +')');
		var tmp_node = "<span>"+info.elementName+"</span>";
		$('#inputText', '#'+info.elementId).replaceWith(tmp_node);
			
		simpleTree.get(0).setTreeNodes2($('#'+info.elementId));
	}

/**
 * when user right click on an element this function is executed 
 */
	this.updateElementNameReq = function()
	{
		if ( treeOps.isTreeBusy() == true ||  
			 treeOps.trGetSelectedWithAlert() == null
			) 
		{
			return;
		}			
		treeOps.treeBusy = true;
		
		var elementName = $('span.active').text();
		var elementId = treeOps.trGetSelected().attr('id');	
		
		$('span:first', treeOps.trGetSelected()).replaceWith("<input type='text' id='inputText' value='"+elementName+"'/>");	
		$('#inputText').focus();
		$('#inputText').bind("keypress",
								 function(evt)
								 {
									 if (evt.keyCode == 13) { //pressed enter
										var name = $('#inputText').attr('value'); 										
									 	var params = "action=updateElementName&name="+name+"&elementId="+elementId;
									 	
										treeOps.ajaxReq (params, structureManagerURL, treeOps.trUpdateElementName);										
									 }
									 else if (evt.keyCode == 27) { // pressed esc
									 	treeOps.setTreeBusy(false);
									    $('#inputText').replaceWith("<span>"+elementName+"</span>");
									 	simpleTree.get(0).setTreeNodes($('#'+elementId))
									 }
								 }
							);
		
	}
//*******************************************************
	this.trReload = function()
	{
		//simpleTree.get(0).setAjaxNodes(getSelected(), null, null);
	}
//*******************************************************	
	this.ajaxReq = function(params, url, callback)
	{
		if (treeOps.ajaxActive == true)
		{
		 	$.ajax({
   					type: 'POST',
					url: url,
					data: params,
					dataType: 'script',
					timeout:100000,
					beforeSend: function(){ treeOps.showInProcessInfo(true);  },
					success: function(result){	
						
							treeOps.treeBusy = false;
							treeOps.showInProcessInfo(false);
							
							if (result == operationFailed) {
								alert(langManager.error);									
							}						
							else{
								callback(result);
								treeOps.showOperationInfo(langManager.missionCompleted);
							}
					},
					failure: function(result) {								
							treeOps.treeBusy = false;
							treeOps.showInProcessInfo(false);
							if (result == operationFailed) {
								alert("Error in ajax.")
							}
					},
					error: function(par1, par2, par3){
						treeOps.showInProcessInfo(false);
						alert("Error in ajax..")
					}
			});
		}
		else {
			callback();
			treeOps.treeBusy = false;
		}
	}
}