
<!-- contant -->
	<div id="content">
		<!-- content_title -->
		<div id="content_title">
			<ul id="h1_title"><strong>- 운영자 관리</strong></ul>
		</div>
		<!--// content_title -->
		<!-- content_box -->
		<div id="content_box">
			<? $i = 1; ?>
			<link href="<?=CSS_DIR?>/jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript"  src="<?=JS_DIR?>/jquery-1.3.2.min.js"></script>
			<script type="text/javascript"  src="<?=JS_DIR?>/jquery-ui-1.7.1.custom.min.js"></script>
			<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>

			<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
			<form name='search_form' method='post' action='<?=SV1_DIR?><?=$this->uri->uri_string()?>'>
			<tr>
				<td height="30" colspan="4">
				<input type="text" name="search_word" class="input" value="<?=$this->validation->search_word?>"> <input type="submit" value="검색">
				</td>
				<td colspan="2"><? echo $this->validation->error_string; ?></td>
				<td colspan="2" align="right">
				<!--a href="http://hbuilder.com/admin/members/master_add" class="alert-actuator" title="운영자 등록">등록</a-->
				<a href="#" class="create1" title="운영자 등록">등록</a>
				</td>
			</tr>
			<script>
			$(".create1").click(function() {
				jQuery.FrameDialog
				.create({
					url: 'http://codeigniter-kr.org/admin/members/master_add',
					title: '관리자 등록',
					width : 810,
					height : 600,
					draggable : false,
					resizable : false,
					buttons: { "닫기": function() { $(this).dialog("close"); } }
				})
			});
			</script>

			<tr>
				<td height="2" colspan="8" bgcolor="#D5D5D5"></td>
			</tr>
			<tr align="center" bgcolor="#F1F1F1" class=txt02 height=25>
				<td  width="40">NO</td>
				<td  width="100">아이디</td>
				<td  width="100">성명</td>
				<td  width="140">이메일</td>
				<td  width="70">등록일</td>
				<td  width="70">상태</td>
				<td width="50">상세</td>
			</tr>
			<tr>
				<td height="1" colspan="8" bgcolor="#D5D5D5"></td>
			</tr>
			<?
			if( $getTotalData > 0 ) {

			foreach($mlist as $data) :

			?>
				<tr align=center>
					<td width="50" height=23 align=center><?=$data['user_no']?></td>
					<td width="100"><?=$data['userid']?></td>
					<td><?=$data['username']?></td>
					<td><?=$data['email']?></td>
					<td><?=$data['created']?></td>
					<td>관리자</td>
					<td><a href="#" onclick="window.open('http://codeigniter-kr.org/admin/members/detail_view/<?=$data['user_no']?>', 'him_auth', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=625,height=350')">보기</a></td>
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
			?>
		</div>
		<!--// content_box -->
	</div>
	<!--// content -->
