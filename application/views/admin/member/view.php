<?
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/main1.css">
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<table>
<tr>
<td class="title"><img class="png24" src="<?=IMG_DIR?>/main/icon_title_orange.png" align="absmiddle"> 회원정보 상세보기</td>
</tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/img_b750_01.png"></td>
</tr>
<tr>
<td background="<?=IMG_DIR?>/main//img_b750_02.gif" align="center" class="maintd">
<table width="700">
<tr>
<td align="left" colspan="6"><h6><img class="png24" src="<?=IMG_DIR?>/main/icon_arrow.png"> 기본정보 </h6></td>
</tr>
<tr><td height="10"></td></tr>
<tr><td colspan="6" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="12"></td></tr>
<tr>
<td width="12"><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>

<td width="100">이름 </td>
<td width="238"><?=$member_info->user_nm?> <!--(<?=$member_info->user_jumin?>)--></td>
<td width="12"><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td width="100">아이디 </td>
<td width="238"><?=$member_info->user_id?><input type="hidden" name="user_id" id="user_id"  value="<?=$member_info->user_id?>"> </td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>비밀번호 </td>
<td><a href="#" onclick="window.open('<?=SV_DIR?>/admin/passwd_send/<?=$member_info->user_hp?>', 'him_auth_a', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=625,height=350')">
<img class="png24" src="<?=IMG_DIR?>/main/b_modifys.png" align=absmiddle alt="수정"></a></td>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>휴대폰번호</td>
<td><!--?=$member_info->telecom?--> <?=$this->myclass->hp_dash($member_info->user_hp)?>
</td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>닉네임 </td>
<td><?=$member_info->user_nickname?></td>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>이메일 </td>
<td><?=$member_info->user_email?></td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>관심지역 </td>
<td colspan="4"><?=$member_info->concern?></td>
</tr>
<tr><td height="6" colspan="6"></td></tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>마지막 로그인 </td>
<td colspan="4"><?=$member_info->login_dt?> &nbsp;&nbsp;<a href="#" onclick="window.open('<?=SV_DIR?>/admin/log_view/<?=$member_info->user_id?>', 'him_auth_a', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=625,height=350')">로그인 이력보기</a>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td background="<?=IMG_DIR?>/main//img_b750_02.gif" align="center" class="maintd">
<table width="700">
<tr>
<td align="left" colspan="6"><h6><img class="png24" src="<?=IMG_DIR?>/main/icon_arrow.png"> 부가정보 </h6></td>
</tr>
<tr><td height="10"></td></tr>
<tr><td colspan="6" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="12"></td></tr>
<tr>
<td width="12"><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td width="100">학교 </td>

<td width="588" class="smallt"><?=$member_info->primary_name?> 초등학교 <?=$member_info->primary_entrance?> ~ <?=$member_info->primary_graduate?></td>
</tr>
<tr><td height="4" colspan="3"></td></tr>
<tr>
<td></td>
<td></td>
<td class="smallt"><?=$member_info->middle_name?> 중학교 <?=$member_info->middle_entrance?> ~ <?=$member_info->middle_graduate?></td>
</tr>
<tr><td height="4" colspan="3"></td></tr>
<tr>
<td></td>
<td></td>
<td class="smallt"><?=$member_info->high_name?> 고등학교 <?=$member_info->high_entrance?> ~ <?=$member_info->high_graduate?>
</td>
</tr>
<tr><td height="4" colspan="3"></td></tr>

<tr>
<td></td>
<td></td>
<td class="smallt"><?=$member_info->university_name?> 대학교 <?=$member_info->university_entrance?> ~ <?=$member_info->university_graduate?></td>
</tr>
<tr><td height="4" colspan="3"></td></tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>직업 </td>
<td>
<?php
$SQL="select * from class_job where class_seq = '".$member_info->job."' ";
$res=$this->db->query($SQL);
$sq=$res->row();
?>
<?=$sq->class_name?></td>
</tr>
<tr><td height=4 colspan=3></td></tr>

<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/icon_dot1.png"></td>
<td>관심분야 </td>
<td>
<? echo $member_info->interest."<BR>"; ?>
</td>
</tr>
<tr><td height="15"></td></tr>
<tr><td colspan="6" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="10"></td></tr>
</table>

<table width="700">
<tr><td height="15"></td></tr>
</table>
<? if( $member_info->member_photo ) { ?>
<table width="700" align="center">
<tr>
<td align="left" colspan="3"><h6><img class="png24" src="<?=IMG_DIR?>/main/icon_arrow.png"> 사진 </h6></td>
</tr>
<tr><td height="10" colspan="3"></td></tr>
<tr><td colspan="3" height="1" bgcolor="#e3e3e3"></td></tr>
<tr><td height="15" colspan="3"></td></tr>
<tr>
<td width="82" height="82" rowspan="2"><img src="<?=SV_DIR1?><?=$member_info->member_photo?>"></td>
<td width="10"></td>
<td valign="top"></td>
</tr>
</table>
<? } ?>
</td>
</tr>
<tr>
<td><img class="png24" src="<?=IMG_DIR?>/main/img_b750_03.png"></td>
</tr>
<tr><td height="20"></td></tr>
<tr>
</table>
