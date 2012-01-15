// JavaScript Document
/********************************************
* 	Filename:	js/init.js
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Sunday, April 20, 2008  16:22
***********************************************/


/**
 * initialization script 
 */
var langManager = new languageManager();
//en for english
//tr for turkish
langManager.load("en");  

var treeOps = new TreeOperations();

$(document).ready(function() {
	
	// binding menu functions
	$('#myMenu1 #addDoc').click(function()  {  treeOps.addElementReq(); });									   						    
	$('#myMenu1 #addFolder').click(function()  {  treeOps.addElementReq(true); });	
	$('#myMenu1 #edit, #myMenu2 #edit').click(function() {  treeOps.updateElementNameReq(); });
	$('#myMenu1 #delete, #myMenu2 #delete').click(function() {  treeOps.deleteElementReq(); });
	
	
	// setting menu texts 
	$('#myMenu1 #addDoc').append(langManager.addDocMenu);
	$('#myMenu1 #addFolder').append(langManager.addFolderMenu);
	$('#myMenu1 #edit, #myMenu2 #edit').append(langManager.editMenu);
	$('#myMenu1 #delete, #myMenu2 #delete').append(langManager.deleteMenu);
	
		
	// initialization of tree
	simpleTree = $('.simpleTree').simpleTree({
		autoclose: false,
		
		/**
		 * Callback function is called when one item is clicked
		 */	
		afterClick:function(node){
				//alert($('span:first', node).text() + " clicked");
				//alert($('span:first',node).parent().attr('id'));
		},
		/**
		 * Callback function is called when one item is double-clicked
		 */	
		afterDblClick:function(node){
			var iFrames = parent.document.getElementsByTagName('iframe');
			var node_name = $('span:first',node).text()
			iFrames[1].src="/admin/menu/config_board/"+node_name+"/";
			//alert(iFrames[1].src);
			
			
		},
		afterMove:function(destination, source, pos) {
		//	alert("destination-"+destination.attr('id')+" source-"+source.attr('id')+" pos-"+pos);	
			if (dragOperation == true) 
			{
				var params = "action=changeOrder&elementId="+source.attr('id')+"&destOwnerEl="+destination.attr('id')+"&position="+pos;
				treeOps.ajaxReq(params, structureManagerURL, function(result)
				{	
					if (result == -1) {
						alert(langManager.error+"\n"+langManager.willReload);
						window.location.reload();
					}
				});
			}
		},
		afterAjax:function(node)
		{
			if (node.html() == "") {
				node.html("<li class='line-last'></li>");
			}
		},		
		afterContextMenu: function(element, event)
		{
			var className = element.attr('class');
			if (className.indexOf('doc') >= 0) {
				$('#myMenu2').css('top',event.pageY).css('left',event.pageX).show();				
			}
			else {
				$('#myMenu1').css('top',event.pageY).css('left',event.pageX).show();
			}
			
			$('*').click(function() { $('#myMenu1, #myMenu2').hide();  });
			
		},
		animate:true
		//,docToFolderConvert:true		
	});		
});