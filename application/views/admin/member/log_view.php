<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="<?=SV_DIR1?>/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/main1.css">
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<br>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td height="30" colspan="3"><?=$this->uri->segment(3)?>&nbsp; 로그인 기록 보기 &nbsp;&nbsp; (총 <?=$getTotalData?> 건)</td>
</tr>
<tr>
	<td height="2" colspan="3" bgcolor="#D5D5D5"></td>
</tr>
<tr align="center" bgcolor="#F1F1F1" class=txt02 height=25>
	<td width="20%">번호</td>
    <td  width="40%">IP</td>
	<td  width="40%">로그인 일시</td>
</tr>
<tr>
	<td height="1" colspan="3" bgcolor="#D5D5D5"></td>
</tr>
<?
if( $getTotalData > 0 ) {
if( $this->uri->segment(4) ) {
	$ii=$getTotalData-$this->uri->segment(4);
} else {
	$ii=$getTotalData;
}
foreach($llist as $data) :

?>
	<tr align=center>
		<td height="20"><?=$ii?></td>
		<td height="20"><?=$data['remote_ip']?></td>
		<td><?=$data['login_dt']?></td>
	</tr>
	<tr>
	<td height="1" colspan="3" bgcolor="#D5D5D5"></td>
</tr>
<?
$ii--;
endforeach; ?>
<? } else { ?>
<tr><td colspan=3 height=40>결과가 없습니다.</td></tr>
<?}?>
</table>
<br>
<?
echo $pagenav;
?>
