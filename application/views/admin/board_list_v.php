<script>
$(function(){
	$("#create1").click(function() {
		jQuery.FrameDialog
		.create({
			url: '/admin/main/board_add',
			title: '게시판 추가',
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
			<ul id="h1_title"><strong>게시판 관리</strong></ul>
		</div>
		<!--// content_title -->
		<!-- content_box -->
		<div id="content_box">
			<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
			<form name='search_form' method='post' action='/<?php echo $this->uri->uri_string()?>'>
			<tr>
				<td height="30" colspan="5">
				<input type="text" name="search_word" class="input" value=""> <input type="submit" value="검색">
				</td>
				<td align="right">
				<a href="#" id="create1" title="게시판 추가">게시판 추가</a>
				</td>
			</tr>
			<tr>
				<td height="2" colspan="6" bgcolor="#D5D5D5"></td>
			</tr>
			<tr align="center" bgcolor="#F1F1F1" class=txt02 height=25>
				<td  width="40">NO</td>
				<td  width="200">게시판명(영문)</td>
				<td  width="100">스킨</td>
				<td  width="140">권한</td>
				<td  width="70">상태</td>
				<td  width="100">등록일</td>
			</tr>
			<tr>
				<td height="1" colspan="6" bgcolor="#D5D5D5"></td>
			</tr>
<?php
if( $getTotalData > 0 )
{

	foreach($mlist as $data)
	{
?>
				<tr align=center>
					<td height=23 align=center><?php echo $data['no']?></td>
					<td><?php echo $data['name']?> (<?php echo $data['name_en']?>)</a></td>
					<td><?php echo $data['skin']?></td>
					<td><?php echo $data['permission']?></td>
					<td><?php echo $data['enable']?></td>
					<td><?php echo $data['reg_date']?></td>
				</tr>
				<tr>
				<td height="1" colspan="6" bgcolor="#D5D5D5"></td>
			</tr>
<?php
	}
}
else
{
?>
			<tr><td colspan=6 height=40>결과가 없습니다.</td></tr>
<?php
}
?>
			</form>
			</table>
		<br>권한1 >> 1: 비회원, 3: 회원, 7: 포럼개발자, 15: 운영자
		<br><br>권한2 >> 목록보기 | 게시물보기 | 댓글작성 | 게시물쓰기
<?php
			echo $pagenav;
?>
		</div>
		<!--// content_box -->
	</div>
	<!--// content -->
