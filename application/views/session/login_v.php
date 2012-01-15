<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 로그인 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=SV_DIR1?>/system_css/main1.css" />
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
</HEAD>

<body >

<table width="320" align="center" class="layertable">
<?=form_open($this->uri->uri_string(), array('id' => 'login_form'))?>
<tr>
<td align="center">
<table width="270">
<tr>
<td>
<!-- contents 영역 -->
<h3><img class="png24" src="<?=IMG_DIR?>/main/icon_arrow.png"> 로그인 </h3>
<p>
<table>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/img_b270_01.png"></td>
</tr>
<tr>
<td background="<?=IMG_DIR?>/main/img_b270_02.gif" align="center" class="maintd">
<table>
<tr height="20">
<td width="12"><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td width="65">아이디</td>
<td><input type="text" id="input" name="user_id" value="<?php echo $this->validation->user_id;?>" title="아이디" size="16"></td>
</tr>
<tr><td height="4" colspan="3"></td></tr>
<tr height="20">
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>비밀번호</td>
<td><input type="password" id="input" name="user_password" value="<?php echo $this->validation->user_password;?>" title="비밀번호" size="16"></td>
</tr>
<tr><td colspan="3">
<?php echo $this->validation->user_id_error; ?>
<?php echo $this->validation->user_password_error; ?>
</td></tr>
</table>
</td>
</tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/img_b270_03.png"></td>

</tr>
</table>
<!-- // contents 영역 -->
</td>
</tr>
</table>
<tr>
<td align="center" height="45">
<!-- 버튼 영역 -->
<input type="image" class="png24" src="<?=IMG_DIR?>/main/b_ok1.png" alt="확인" style="cursor:pointer">&nbsp;&nbsp;<img class="png24" src="<?=IMG_DIR?>/main/b_close1.png" alt="닫기" onclick="javascript:parent.login.hide();" style="cursor:pointer">
<!--// 버튼 영역 -->
</td>
</tr>
<tr><td align="center" height="45">
<script>
function id_search() {
	parent.login.setSize(430, 380);
	location="<?=SV_DIR?>/session/search";
}
</script>
<a href="#" onclick="parent.document.location='<?=SV_DIR?>/join/step/index/<?=$this->uri->segment(5)?>';"><img src="<?=IMG_DIR?>/main/toplink_6.png" class="png24" style="cursor:pointer"></a>&nbsp;
<a href="#" onclick="id_search(); return false;"><img src="<?=IMG_DIR?>/main/toplink_7.png" class="png24" style="cursor:pointer"></a>
</td></tr>
<?=form_close()?>
</table>
 </BODY>
</HTML>
