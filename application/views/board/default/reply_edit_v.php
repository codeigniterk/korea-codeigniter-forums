<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="CodeIgniter 한국사용자포럼"/>
<meta name="keywords" content="CodeIgniter, 한국사용자포럼"/>
<meta name="author" content="author"/>
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/default.css" media="screen"/>
<link href="<?=CSS_DIR?>/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<script type="text/javascript" src="<?= JS_DIR ?>/jquery-1.3.2.min.js"></script>
<script type="text/javascript"  src="<?=JS_DIR?>/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
<script type="text/javascript" src="<?=JS_DIR?>/jquery.jScale.js"></script>
<script>
$(function(){
 	$("a").each(function(){
		if($(this).attr("id")=="file_delete") {
			$(this).click(function(){
				var span_no = $(this).attr("ref");
				var hrefs = $(this).attr("raf");
				//alert(hrefs);

				var cfm = confirm('삭제하시겠습니까?');
				if(cfm) {
					$.ajax({
						type: "POST",
						url: hrefs,
						data:{
							"table":'<?=MENU_BOARD_NAME_EN?>',
							"file_table":'files'
							},
						complete: function(r){
							alert('삭제되었습니다.');
							$('#file_row_'+span_no).hide();
						}
					})
				}

			});
		}
	});
});
</script>
<title>CodeIgniter 한국사용자포럼</title>
</head>

<body>
<div style="text-align:center;">
<form action="<?=$this->uri->uri_string()?>" method="post" name="edit_post" enctype="multipart/form-data">
<table width="100%" align="center">
<tr>
	<td>
	<?php
    if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) ) {
    ?>
    <textarea name='contents' cols="80" rows="10"><?php echo $views['contents'];?></textarea>
    <?php
    } else {
        echo $fck_write;
    }
    ?>
	</td>
</tr>
<!--tr>
	<td>Tag</td>
	<td><input type="text" value="<?=$tags?>" size="50" name="tags" /> (예 : 제목, 한국, 홍수)</td>
</tr>
<tr>
	<td>파일첨부</td>
	<td><input type="file" name="userfile" /></td>
</tr-->
<!-- file_list -->
<? if($files_cnt > 0) { ?>
<!--tr>
	<td></td>
	<td height="25">
	<?
	$ss=0;
	foreach ( $files as $fs ) { ?>
	<span id="file_row_<?=$ss?>">
	<a href="/data/files/<?=$fs['file_name']?>"><?=$fs['original_name']?></a>&nbsp; - <a href="#" raf="/action/file_delete/<?=$fs['no']?>" ref="<?=$ss?>" id="file_delete">파일 삭제</a><br>
	</span>
	<?
	$ss++;
	} ?>
	</td>
</tr-->
<!--// file_list-->
<? } ?>
<tr>
	<td align="center"><?php echo validation_errors(); ?></td>
</tr>
<tr>
	<td align="center"><input type="submit" value="수정" /></td>
</tr>
</table>
</form>
</div>
</body>
</html>