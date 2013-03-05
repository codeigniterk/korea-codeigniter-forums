<br>
<form action="<?php echo $this->uri->uri_string()?>" method="post" name="write_post" enctype="multipart/form-data">
<table width="98%" align="center">
<tr>
	<td width="80">글 제목</td>
	<td align="left"><input type="text" value="<?php echo set_value('subject')?>" size="50" name="subject" />
<?php
if ($this->session->userdata('auth_code') == 'ADMIN' )
{
?>
	&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="fixed" /> 글 고정
<?php
}
?>
	</td>
</tr>
<tr>
	<td>글 내용</td>
	<td align="left">
<?php
if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) )
{
?>
    <textarea name='contents' cols="80" rows="10"></textarea>
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
	<td align="left"><input type="text" value="<?php echo set_value('tags')?>" size="50" name="tags" /> (예 : 제목, 한국, 홍수)</td>
</tr>
<tr>
	<td>파일첨부</td>
	<td align="left"><input type="file" name="userfile" /> (7z|tgz|tar|gz|zip|rar|pdf|ppt|xls|docx|xlsx|pptx)</td>
</tr>
<tr>
	<td colspan="2" align="center"><?php echo validation_errors(); ?><?php echo @$file_error?></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" value="등록" /></td>
</tr>
</table>
</form>