<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?=CSS_DIR?>/common.css" rel="stylesheet" type="text/css">
<link href="<?=CSS_DIR?>/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<div id="acontent">
		<table width="98%" border="0" cellpadding="0" cellspacing="0">
		<form name="master_write" method="post" action="<?=$this->uri->uri_string()?>">
		<input type="hidden" name="status_mode" value="insert">
		<tr  bgcolor="#F1F1F1" height=25>
			<td  width="10%" align=center>아이디<font color=red>*</font></td>
			<td  width="20%"><input type="text" name="user_id" value="<?php echo set_value('user_id'); ?>"></td>
			<td  width="10%" align=center>권한<font color=red>*</font></td>
			<td  width="60%" colspan="3">
			<select name="auth_type">
				<option value="AD" selected>운영자</option>

			</select>
			</td>
		</tr>
		<tr bgcolor="#F1F1F1" height=25>
			<td  width="10%" align=center>도메인 <font color=red>*</font></td>
			<td colspan="5"><input type="text" name="site_domain" value="<?php echo set_value('site_domain'); ?>" size="80"></td>
		</tr>
		<tr bgcolor="#F1F1F1" height=25>
			<td  width="10%" align=center>이름 <font color=red>*</font></td>
			<td  width="20%"><input type="text" name="user_nm" value="<?php echo set_value('user_nm'); ?>"></td>
			<td  width="10%" align=center>비밀번호 <font color=red>*</font></td>
			<td  width="20%"><input type="password" name="user_pw" value="<?php echo set_value('user_pw'); ?>"></td>
			<td  width="10%" align=center>별명 <font color=red>*</font></td>
			<td  width="30%"><input type="text" name="user_nickname" value="<?php echo set_value('user_nickname'); ?>"></td>
		</tr>

		<tr  bgcolor="#F1F1F1" height=25>
			<td  width="10%" align=center>이메일</td>
			<td  width="20%"><input type="text" name="user_email" value="<?php echo set_value('user_email'); ?>"></td>
			<td  width="10%" align=center>전화</td>
			<td  width="20%"><input type="text" name="tel" value="<?php echo set_value('tel'); ?>"></td>
			<td  width="10%" align=center>휴대폰</td>
			<td  width="30%"><input type="text" name="hp" value="<?php echo set_value('hp'); ?>"></td>
		</tr>
		<tr>
			<td height="10" colspan="10" bgcolor="#ffffff"><?php echo form_error('user_id'); ?><?php echo form_error('site_domain'); ?><?php echo form_error('user_nm'); ?><?php echo form_error('user_pw'); ?><?php echo form_error('user_nickname'); ?></td>
		</tr>
		<tr>
			<td height="30" colspan="10" align="center"><input type="submit" value="입력"></td>
		</tr>
		</form>
		</table>
</div>