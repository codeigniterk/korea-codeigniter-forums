<?php
$perm_arr = array('비회원'=>1,'회원'=>3,'포럼개발자'=>7,'운영자'=>15);
?>
<style>
.table1 { font:normal 12px gulim; font-size:12px; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div id="acontent">
	<br>
	<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" class="table1">
	<form name="master_write" method="post" action="/<?php echo $this->uri->uri_string()?>">
	<input type="hidden" name="status_mode" value="insert">
	<tr  bgcolor="#F1F1F1" height=25>
		<td  width="10%" align=center>게시판명</td>
		<td  width="30%"><input type="text" name="name" value="<?php echo set_value('name'); ?>"></td>
		<td  width="20%" align=center>게시판 영문명 </td>
		<td  width="40%"><input type="text" name="name_en" value="<?php echo set_value('name_en'); ?>"></td>

	</tr>
	<tr bgcolor="#F1F1F1" height=25>
		<td align=center>스킨</td>
		<td>
		<select name="skin">
			<option value="default" selected>기본스킨</option>
		</select>
		</td>
		<td align=center>사용여부 </td>
		<td>
		<select name="enable">
			<option value="Y" selected>사용</option>
			<option value="N">미사용</option>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F1F1F1" height=25>
		<td align=center>권한 </td>
		<td width="90%" colspan="3">
		목록보기:<select name="per1">
<?php
foreach ($perm_arr as $key=>$val)
{
?>
			<option value="<?php echo $val?>"><?php echo $key?></option>
<?php
}
?>
		</select>
		게시물보기:<select name="per2">
<?php
foreach ($perm_arr as $key=>$val)
{
?>
			<option value="<?php echo $val?>"><?php echo $key?></option>
<?php
}
?>
		</select>
		댓글쓰기:<select name="per3">
<?php
foreach ($perm_arr as $key=>$val)
{
?>
			<option value="<?php echo $val?>"><?php echo $key?></option>
<?php
}
?>
		</select>
		게시물쓰기:<select name="per4">
<?php
foreach ($perm_arr as $key=>$val)
{
?>
			<option value="<?php echo $val?>"><?php echo $key?></option>
<?php
}
?>
		</select>
		</td>
	</tr>


	<tr>
		<td height="10" colspan="4" bgcolor="#ffffff"><?php echo validation_errors(); ?></td>
	</tr>
	<tr>
		<td height="30" colspan="4" align="center"><input type="submit" value="입력"></td>
	</tr>
	</form>
	</table>
</div>