<div id="content">
	<div id="content_title">
		<ul id="h1_title"><strong>로그인</strong></ul>
	</div>
	<!--// content_title -->
	<!-- content_box -->
	<div id="content_box">
		<table class="tables">
		<?=form_open($this->uri->uri_string(), array('id' => 'login_form'))?>
		<tr height="20">
		<td width="65">아이디</td>
		<td><input type="text" id="input" name="user_id" value="<?php echo $this->validation->user_id;?>" title="아이디" size="16"></td>
		</tr>
		<tr height="20">
		<td>비밀번호</td>
		<td><input type="password" id="input" name="user_password" value="<?php echo $this->validation->user_password;?>" title="비밀번호" size="16"></td>
		</tr>
		<tr><td colspan="2">
		<?php echo $this->validation->user_id_error; ?>
		<?php echo $this->validation->user_password_error; ?>
		</td></tr>
		<tr>
		<td align="center" height="45" colspan="2"><input type="submit" value="로그인"></td>
		</tr>
		<?=form_close()?>
		</table>
	</div>
</div>