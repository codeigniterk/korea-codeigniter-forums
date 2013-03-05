<script>
$(function(){
 	$(".file_delete").each(function(){
		$('.file_delete').click(function(){
			var span_no = $(this).attr("ref");
			var hrefs = $(this).attr("raf");
			alert(span_no+'--'+hrefs);
/*
			var cfm = confirm('삭제하시겠습니까?');
			if(cfm) {
				$.ajax({
					type: "POST",
					url: hrefs,
					data:{
						"module_no":'<?php echo $this->uri->segment(3)?>',
						"table":'<?php echo MENU_BOARD_NAME_EN?>',
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
*/
		});

	});
});
</script>

<br>
<form action="/<?php echo $this->uri->uri_string()?>" method="post" name="edit_post" enctype="multipart/form-data">
<table width="95%">
<tr>
	<td width="80">글 제목</td>
	<td align="left"><input type="text" value="<?php echo $views['subject']?>" size="50" name="subject" />
<?php
if ( $views['is_notice'] == 'Y' )
{
	$notice_chk = ' checked';
}
else
{
	$notice_chk = '';
}
?>
	&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="fixed" <?php echo $notice_chk?> /> 글 고정
	</td>
</tr>
<tr>
	<td>글 내용</td>
	<td align="left">
<?php
if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) )
{
?>
    <textarea name='contents' cols="80" rows="10"><?php echo $views['contents'];?></textarea>
<?php
}
else
{
    echo $fck_write;
}
?>
	</td>
</tr>
<tr>
	<td>Tag</td>
	<td align="left"><input type="text" value="<?php echo $tags?>" size="50" name="tags" /> (예 : 제목, 한국, 홍수)</td>
</tr>
<tr>
	<td>파일첨부</td>
	<td align="left"><input type="file" name="userfile" /> (7z|tgz|tar|gz|zip|rar|pdf|ppt|xls|docx|xlsx|pptx)</td>
</tr>
<!-- file_list -->
<?php
if($files_cnt > 0)
{
?>
<tr>
	<td></td>
	<td height="25">
<?php
	$ss=0;
	foreach ( $files as $fs )
	{
?>
	<span id="file_row_<?php echo $ss?>">
	<a href="/data/files/<?php echo $fs['file_name']?>"><?php echo $fs['original_name']?></a>&nbsp; - <a href="#" raf="/action/file_delete/<?php echo $fs['no']?>" ref="<?php echo $ss?>" class="file_delete">파일 삭제</a><br>
	</span>
<?php
		$ss++;
	}
?>
	</td>
</tr>
<!--// file_list-->
<?php
}
?>
<tr>
	<td colspan="2" align="center"><?php echo validation_errors(); ?><?php echo @$file_error?></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="수정" /></td>
</tr>
</table>
</form>

