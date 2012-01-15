<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>언제 어디서나 좋은 사람들과 소통하는 HiBori</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript">
<!--
// 아이디 중복검사시 체크
function checkIDOverlap(act) {
	//document.domain = "<?=$this->input->server('HTTP_HOST')?>";
	var form=document.seform;
	//alert('<?=$this->input->server('HTTP_HOST')?>');
	if (form.user_hp.value.length < 10) {
		alert('휴대폰번호를 입력하세요.');
		form.user_hp.focus();
		return false;
	} else {
		window.open('', 'HP_auth', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=0,height=0');
		form.target = 'HP_auth';
		form.action="<?=SV_DIR2?>/views/session/hp_auth.php";
		form.submit();
	}
}
function AcheckIDOverlap(act) {
	//document.domain = "<?=$this->input->server('HTTP_HOST')?>";
	//alert('<?=$this->input->server('HTTP_HOST')?>');
	var form=document.seform;
	if (form.user_hp.value.length < 10) {
		alert('휴대폰번호를 입력하세요.');
		form.user_hp.focus();
		return false;
	} else if (form.auth_code.value == 0) {
		alert('인증번호를 입력하세요.');
		return false;
	} else if (form.cert_reg.value == 0) {
		alert('인증번호 받기를 클릭하세요.');
		return false;
	} else {
		window.open('', 'HP_auth1', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=0,height=0');
		form.target = 'HP_auth1';
		form.action="<?=SV_DIR2?>/views/session/auth_code.php";
		form.submit();
	}
}
//-->
</script>
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/main1.css">
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>

</HEAD>

<BODY topmargin=0 leftmargin=0>

<!--?=form_open('', array('id' => 'search_id_pw_form', 'name' => 'search_id_pw_form'))?-->
<form method="post" id="seform" name="seform">
<input type="hidden" name="cert_reg" id="cert_reg" value="<?=$cert_reg;?>" />
<table width="400" align="center">
<tr>
<td height=65 background="<?=IMG_DIR?>/main/findidpw_topb.png">
<!-- Top 영역 -->
<h1><img src="<?=IMG_DIR?>/main/title_findidpw.png" alt="ID,PW찾기"></h1>
<!--// Top 영역 -->
</td>
</tr>
<tr>
<td align="center">
	<table width="346">
	<tr>
	<td>
	<!-- contents 영역 -->
	<h3><img src="<?=IMG_DIR?>/main/icon_arrow.png"> 아이디 비밀번호 찾기 </h3>
	<p>
		<table>
		<tr>
		<td><img src="<?=IMG_DIR?>/main/img_b346_01.png"></td>
		</tr>
		<tr>
		<td background="<?=IMG_DIR?>/main/img_b346_02.png" align="center" class="maintd">
			<table width="290">
			<tr>
			<td height="30" valign="top" class="text">휴대폰으로 본인 인증을 하시면<BR>아이디 또는 임시 비밀번호를 휴대폰 문자로 보내드립니다.</td>
			</tr>
			<tr height="40">
			<td align="center">

				<table width="100%" class="box">
				<tr>
				<td bgcolor="#e5e5e5" align="center" height="25" colspan="2"><input type=radio name="radio_id" value="id" checked title="아이디" > 아이디&nbsp;&nbsp;&nbsp;<input type=radio name="radio_id" value="pw" title="비밀번호" > 비밀번호</td>
				</tr>
				<tr><td height="8" colspan="2"></td></tr>
				<tr height="21">
				<td width="65" style="padding-left:8px;">휴대폰번호</td>
				<td><input type="text" class="input" name="user_hp" id="user_hp" value="<?=$this->validation->user_hp;?>" tabindex="1" title="휴대폰번호" size="15"> &nbsp;<img src="<?=IMG_DIR?>/main/b_sendphone.png" align=absmiddle alt="인증번호보내기" onclick="checkIDOverlap('a');" style="cursor:pointer"></td>
				</tr>
				<tr height="21">
				<td style="padding-left:8px;">인증번호</td>
				<td><input type="text" class="input" name="auth_code" id="auth_code" tabindex="2" title="인증번호" size="15"></td>
				</tr>
				<tr><td height="8" colspan="2"></td></tr>
				</table>

			</td>
			</tr>
			<tr>
			<td class="warning"><?php echo $this->validation->error_string; ?><br></td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td><img src="<?=IMG_DIR?>/main/img_b346_03.png"></td>
		</tr>
		</table>
	<!-- // contents 영역 -->
	</td>
	</tr>
	</table>
<tr>
<td align="center" height="60">
<!-- 버튼 영역 -->
<img class="png24" src="<?=IMG_DIR?>/main/b_ok.png" alt="확인" onclick="AcheckIDOverlap('b');" style="cursor:pointer">&nbsp;&nbsp;<img class="png24" src="<?=IMG_DIR?>/main/b_cancle.png" alt="취소" onclick="parent.login.hide();"  style="cursor:pointer"></a>
<!--// 버튼 영역 -->
</td>
</tr>
</table>

 <?=form_close();?>

</BODY>
</HTML>