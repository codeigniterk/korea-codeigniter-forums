<?
$this->load->view('admin/top');
?>


<? $i = 1; ?>
<span class=txt03>현재위치: 회원/마스터 관리 > 회원 관리</span> <br />
<br />
<script type="text/JavaScript">
function chkBox(bool) { // 전체선택/해제
    var obj = document.getElementsByName("chk[]");
    for (var i=0; i<obj.length; i++) obj[i].checked = bool;
}
function revBox() { // 전체반전
    var obj = document.getElementsByName("chk[]");
    for (var i=0; i<obj.length; i++) obj[i].checked = !obj[i].checked;
}
</script>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
<form name='search_form' method='post' action='<?=SV_DIR?><?=$this->uri->uri_string()?>'>
<tr>
	<td height="30" colspan="4">총 <?=$getTotalData?> 명 &nbsp; &nbsp;
	<input type="text" name="search_word" class="input" value="<?=$this->validation->search_word?>" /> <input type="submit" value="검색" />
	</td>
	<td colspan="2"><? echo $this->validation->error_string; ?></td>
	<td colspan="2" align="right"><a href="http://www.hibori.com/index.php/admin/member/excel_wt">전체 엑셀출력</a> &nbsp;&nbsp;<a href="#" onClick="write_box=dhtmlmodal.open('Attendance_cancelBox', 'iframe', '<?=SV_DIR?>/admin/master_insert/', '운영자등록', 'width=625px,height=500px,center=1,resize=0,scrolling=0');return false;">등록</a></td>
</tr>
<tr>
	<td height="2" colspan="8" bgcolor="#D5D5D5"></td>
</tr>
<tr align="center" bgcolor="#F1F1F1" class=txt02 height=25>
    <td width="50"><INPUT type=checkbox onclick=chkBox(this.checked)>선택</td>
	<td  width="40">NO</td>
	<td  width="100">아이디</td>
	<td  width="100">성명</td>
	<td  width="140">이메일</td>
	<td  width="120">전화번호</td>
	<td  width="70">등록일</td>
	<td  width="70">상세</td>

</tr>
<tr>
	<td height="1" colspan="8" bgcolor="#D5D5D5"></td>
</tr>
<?
if( $getTotalData > 0 ) {

foreach($mlist as $data) :

?>
	<tr align=center>
	<td><INPUT type=checkbox name="chk[]" value="<?=$data['user_seq']?>"></td>
		<td width="50" height=23 align=center>
			<?=$data['user_seq']?>
		</td>
		<td width="100"><?=$data['user_id']?></td>
		<td><?=$data['user_nm']?></td>
		<td><?=$data['user_email']?></td>
		<td><?=$this->myclass->hp_dash($data['user_hp'])?></td>
		<td><?=$data['user_sign_dt']?></td>
		<td><a href="#" onClick="view_box=dhtmlmodal.open('Attendance_cancelBox', 'iframe', '<?=SV_DIR?>/admin/member_view/<?=$data['user_seq']?>', '상세보기', 'width=780px,height=500px,center=1,resize=0,scrolling=0');return false;">보기</a>
		</td>

	</tr>
	<tr>
	<td height="1" colspan="8" bgcolor="#D5D5D5"></td>
</tr>
<? endforeach; ?>
<tr><td colspan=8 height=40><INPUT type=button value="전체반전" onclick=revBox()> </td></tr>
<? } else { ?>
<tr><td colspan=8 height=40>결과가 없습니다.</td></tr>
<?}?>
</form>
</table>

<?
echo $pagenav;

$this->load->view('admin/bottom');
?>
