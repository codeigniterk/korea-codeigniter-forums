<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div id="acontent">
	<br>
	<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
	<form name="master_write" method="post" action="/<?php echo $this->uri->uri_string()?>">
	<input type="hidden" name="status_mode" value="insert">
	<tr  bgcolor="#F1F1F1" height=25>
		<td  width="10%" align=center>아이디</td>
		<td  width="20%"><input type="text" name="user_id" value="<?php echo set_value('user_id'); ?>"></td>
		<td  width="10%" align=center>권한</td>
		<td  width="60%" colspan="3">
		<select name="auth_type">
			<option value="15" selected>운영자</option>
			<option value="7">포럼개발자</option>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F1F1F1" height=25>
		<td  width="10%" align=center>비밀번호 </td>
		<td  width="20%"><input type="password" name="user_pw" value="<?php echo set_value('user_pw'); ?>"></td>
		<td  width="10%" align=center>이름 </td>
		<td  width="20%"><input type="text" name="user_nm" value="<?php echo set_value('user_nm'); ?>"></td>
		<td  width="10%" align=center>별명 </td>
		<td  width="30%"><input type="text" name="user_nickname" value="<?php echo set_value('user_nickname'); ?>"></td>
	</tr>

	<tr  bgcolor="#F1F1F1" height=25>
		<td  width="10%" align=center>이메일</td>
		<td  width="20%"><input type="text" name="user_email" value="<?php echo set_value('user_email'); ?>"></td>
		<td  width="10%" align=center></td>
		<td  width="20%"></td>
		<td  width="10%" align=center></td>
		<td  width="30%"></td>
	</tr>
	<tr>
		<td height="10" colspan="10" bgcolor="#ffffff"><?php echo validation_errors(); ?></td>
	</tr>
	<tr>
		<td height="30" colspan="10" align="center"><input type="submit" value="입력"></td>
	</tr>
	</form>
	</table>
</div>