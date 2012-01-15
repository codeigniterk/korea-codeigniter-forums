<script>
$(function(){
 	$("a").each(function(){
		if($(this).attr("id")=="file_delete") {
			$('#file_delete').click(function(){
				var span_no = $(this).attr("ref");
				var hrefs = $(this).attr("raf");
				//alert(hrefs);

				var cfm = confirm('삭제하시겠습니까?');
				if(cfm) {
					$.ajax({
						type: "POST",
						url: hrefs,
						data:{
							"module_no":'<?=$this->uri->segment(3)?>',
							"table":'<?=MENU_BOARD_NAME_EN?>',
							"file_table":'files'
							},


						success : function(data,status){
							if(data == "1")
							{
								alert('삭제 되었습니다.');
								$('#file_row_'+span_no).hide();
							}
							else {
								alert('삭제 실패 하였습니다.');
							}
						}

					})
				}

			});
		}
	});
});
</script>

<br>
<form action="<?=$this->uri->uri_string()?>" method="post" name="edit_post" enctype="multipart/form-data">
<table width="95%" >
<tr>
	<td width="80">글 제목</td>
	<td><input type="text" value="<?=$views['subject']?>" size="50" name="subject" />
	<? if ( $views['is_notice'] == 'Y' ) {
			$notice_chk = ' checked';
		} else {
			$notice_chk = '';
		}
	?>
	&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="fixed" <?=$notice_chk?> /> 글 고정
	</td>
</tr>
<tr>
	<td>글 내용</td>
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
<tr>
	<td>Tag</td>
	<td><input type="text" value="<?=$tags?>" size="50" name="tags" /> (예 : 제목, 한국, 홍수)</td>
</tr>
<tr>
	<td>파일첨부</td>
	<td><input type="file" name="userfile" /> (7z|tgz|tar|gz|zip|rar|pdf|ppt|xls|docx|xlsx|pptx)</td>
</tr>
<!-- file_list -->
<? if($files_cnt > 0) { ?>
<tr>
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
</tr>
<!--// file_list-->
<? } ?>
<tr>
	<td colspan="2" align="center"><?php echo validation_errors(); ?><?=@$file_error?></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="수정" /></td>
</tr>
</table>
</form>

