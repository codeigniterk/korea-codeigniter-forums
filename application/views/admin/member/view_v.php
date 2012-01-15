<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/admin.css">
<table>
<tr>
<td class="title"> 회원정보 상세보기</td>
</tr>
<tr>
<td align="center">
<table width="700">
<tr>
<td align="left" colspan="6"><h6> 기본정보 </h6></td>
</tr>
<tr><td height="10"></td></tr>
<tr><td colspan="6" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="12"></td></tr>
<tr>
<td width="12"></td>

<td width="100">이름 </td>
<td width="238"><?=$user_details->name?></td>
<td width="12"></td>
<td width="100">아이디 </td>
<td width="238"><?=$user_details->user_id?><input type="hidden" name="user_id" id="user_id"  value="<?=$user_details->user_id?>"> </td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td></td>
<td>비밀번호 </td>
<td><a href="#" onclick="window.open('<?=SV1_DIR?>/admin/passwd_send/<?=$user_details->hp?>', 'him_auth_a', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=625,height=350')">
<img  src="<?=IMG_DIR?>/main/b_modifys.png" align=absmiddle alt="수정"></a></td>
<td></td>
<td>휴대폰번호</td>
<td><?=$user_details->hp?>
</td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td></td>
<td>닉네임 </td>
<td><?=$user_details->nickname?></td>
<td></td>
<td>이메일 </td>
<td><?=$user_details->email_id?>@<?=$user_details->email_host?></td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td></td>
<td>마지막 로그인 </td>
<td colspan="4"><?=$user_details->last_login?> &nbsp;&nbsp;<a href="#" onclick="window.open('<?=SV1_DIR?>/admin/log_view/<?=$user_details->user_id?>', 'him_auth_a', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=625,height=350')">로그인 이력보기</a>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td background="<?=IMG_DIR?>/main//img_b750_02.gif" align="center" class="maintd">

<? if( $user_details->member_photo ) { ?>
<table width="700" align="center">
<tr>
<td align="left" colspan="3"><h6><img  src="<?=IMG_DIR?>/main/icon_arrow.png"> 사진 </h6></td>
</tr>
<tr><td height="10" colspan="3"></td></tr>
<tr><td colspan="3" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="15" colspan="3"></td></tr>
<tr>
<td width="82" height="82" rowspan="2"><img src="<?=SV_DIR1?><?=$user_details->member_photo?>"></td>
<td width="10"></td>
<td valign="top"></td>
</tr>
</table>
<? } ?>
</td>
</tr>
<tr><td height="20"></td></tr>
<tr>
</table>
