<script>
$(function(){
	$("#create1").click(function() {
		jQuery.FrameDialog
		.create({
			url: '/admin/main/master_add',
			title: '관리자 등록',
			width : 810,
			height : 250,
			draggable : false,
			resizable : false,
			buttons: { "닫기": function() { $(this).dialog("close"); } }
		})
	});
});
</script>
<!-- contant -->
	<div id="content">
		<!-- content_title -->
		<div id="content_title">
			<ul id="h1_title"><strong>회원(운영자) 관리</strong></ul>
		</div>
		<!--// content_title -->
		<!-- content_box -->
		<div id="content_box">
			<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
			<form name='search_form' method='post' action='/<?php echo $this->uri->uri_string()?>'>
			<tr>
				<td height="30" colspan="3">
				<input type="text" name="search_word" class="input" value=""> <input type="submit" value="검색">
				</td>
				<td colspan="2" align="right">
				<a href="#" id="create1" title="운영자 등록">운영자 등록</a>
				</td>
			</tr>
			<tr>
				<td height="2" colspan="7" bgcolor="#D5D5D5"></td>
			</tr>
			<tr align="center" bgcolor="#F1F1F1" class=txt02 height=25>
				<td  width="40">NO</td>
				<td  width="100">아이디</td>
				<td  width="100">성명(닉네임)</td>
				<td  width="140">이메일</td>
				<td  width="100">등록일</td>
				<td  width="70">상태</td>
				<td  width="100">최종 IP</td>
			</tr>
			<tr>
				<td height="1" colspan="7" bgcolor="#D5D5D5"></td>
			</tr>
<?php
if( $getTotalData > 0 )
{

	foreach($mlist as $data)
	{
		if( $data['banned'] == 1 )
		{
			$color = "#ff0000";
		}
		else
		{
			$color = "#000000";
		}
?>
				<tr align=center>
					<td width="50" height=23 align=center><?php echo $data['user_no']?></td>
					<td width="100"><a href="#" title="강제탈퇴" onclick="window.open('http://<?php echo $_SERVER['HTTP_HOST']?>/admin/main/banned/<?php echo $data['user_no']?>', 'him_auth', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=300,height=250')" style="color:<?php echo $color?>;"><?php echo $data['userid']?></a></td>
					<td><?php echo $data['username']?> ( <?php echo $data['nickname']?> )</td>
					<td><?php echo $data['email']?></td>
					<td><?php echo $data['created']?></td>
					<td><?php echo $data['auth_code']?></td>
					<td><?php echo $data['last_ip']?></td>
				</tr>
				<tr>
				<td height="1" colspan="7" bgcolor="#D5D5D5"></td>
			</tr>
<?php
	}
}
else
{
?>
			<tr><td colspan=8 height=40>결과가 없습니다.</td></tr>
<?php
}
?>
			</form>
			</table>

<?php
			echo $pagenav;
?>
		</div>
		<!--// content_box -->
	</div>
	<!--// content -->
