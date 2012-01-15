<?
$board_skin_path=VIEW_ROOT."/board/views/".MENU_SKIN;
$img_size = 600;
$reply_img_size = 600;
$searcht = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
       '@<style[^>]*?>.*?</style>@siU'    // Strip style tags properly
);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
img{border:0;}
a, a:link, a:visited, a:active{color:#383838; text-decoration:none;}
a:hover{text-decoration:underline;}
.boardview1{width:100%; border-top:1px solid #e0e1db; border-bottom:1px solid #efefef; color:#666; font-size:12px; border-collapse:collapse;}
.boardview1 caption{ padding:10 5 8 5; letter-spacing:-1px; text-align:left; font-weight: bold; color:#333;  font-size:14px; }
.boardview1 caption p { float:right; font:normal; font-size:9px; font-family:tahoma; letter-spacing:0px; padding-top:5px; }
.boardview1 caption strong { float:left; }
.boardview1 thead th{line-height:15px; padding:10px 0 5px 5px;; color:#333; text-align:left;}
.boardview1 thead td{padding:8px 0 5px 10px; text-align:right; }
/*.boardview1 tbody td{white-space:nowrap; text-overflow:ellipsis; overflow:hidden;}*/
.boardview1 tbody td.wr_contents{padding:10px; text-align:left; line-height:18px;}
.boardview1 tbody td.link{padding:5px; text-align:left;}
.boardview1 tbody td.sign{padding:10px; border-top:1px solid #e0e1db; border-bottom:1px solid #e0e1db; text-align:left;}
.boardview1 tbody td.good{padding:10px; text-align:right;}
.boardview1 tbody td.tags{padding:8 5 8 33px; text-align:left; background:url('/images/icon_tag.gif') no-repeat 10 8px;}
.boardview1 tbody td.files{padding:10px; text-align:left; background:#f4f4f4; border-top:1px solid #efefef; border-left:1px solid #efefef; border-right:1px solid #efefef;}
.category {color:#6C6C6C; font-size:12px; font-family:tahoma; font:normal; }
.view_num {color:#666666; font-size:9px; font-family:tahoma;}
.date {color:#888888; font-size:11px; font-family:tahoma;}
.ip {color:#B2B2B2; font-size:9px; font-family:tahoma;}

.board_button { width:100%; margin:5px 0 5px 0; padding:0px; text-align:center; }
#comment_list { width:95%; padding:10px; text-align:center; }
#comment_add { width:95%; padding:5px 15px 5px 5px; text-align:center; border:0px solid #efefef; }
/* #gBtn7 */
#gBtn7 a{display:block; background:url('/images/gBtn7_bg.gif') left 0; float:left; font:11px 돋움; color:#555; padding-left:6px; text-decoration:none; height:27px; cursor:pointer; overflow:hidden; letter-spacing:-1px; margin-left:3px;}
#gBtn7 a:hover{background:url('/images/gBtn7_bg.gif') left -27px}
#gBtn7 a span{display:block; float:left; background:url('/images/gBtn7_bg.gif') right 0; line-height:220%; padding-right:6px; height:27px; overflow:hidden}
#gBtn7 a span.btn_img{display:block; float:left; background:url('/images/gBtn7_bg.gif') right 0; line-height:220%; padding-top:4px; padding-right:6px; height:27px; overflow:hidden}
#gBtn7 a:hover span{background:url('/images/gBtn7_bg.gif') right -27px; color:#000}

.board_top { clear:both; }

.board_list { clear:both; width:100%; table-layout:fixed; margin:5px 0 10px 0; }
.board_list th { font-weight:bold; font-size:12px; }
.board_list th { white-space:nowrap; height:34px; overflow:hidden; text-align:center; }
.board_list th { border-top:1px solid #ddd; border-bottom:1px solid #ddd; }

.board_list tr.bg1 { background-color:#fafafa; border-bottom:1px solid #ddd; }
.board_list tr.bg0 { background-color:#ffffff; border-bottom:1px solid #ddd; }

.board_list td { padding:.5em; font-family:Tahoma; font-size:12px; color:#808080; }

.board_list td.num { color:#999999; text-align:center; }
.board_list td.checkbox { text-align:center; }
.board_list td.subject { overflow:hidden; }
.board_list td.name { padding:0 0 0 10px; }
.board_list td.datetime { font:normal 12px tahoma; text-align:center; }
.board_list td.hit { font:normal 12px tahoma; text-align:center; }
.board_list td.good { font:normal 12px tahoma; text-align:center; }
.board_list td.nogood { font:normal 12px tahoma; text-align:center; }

.board_list .notice { font-weight:normal; }
.board_list .current { font:bold 11px tahoma; color:#E15916; }
.board_list .comment { font-family:Tahoma; font-size:10px; color:#EE5A00; }

.board_button { clear:both; margin:10px 0 0 0; }

.board_page { clear:both; font:normal 12px tahoma; text-align:center; margin:3px 0 0 0; }
.board_page a:link { color:#777; }

.board_search { text-align:center; margin:10px 0 0 0; }
.board_search .stx { height:21px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; }
#file_list {
text-align: left;
padding: 10px 0 5px 20px;
width: 90%;
border: 3px solid #eee;
color: #ccc;
height: 20px;
margin: 5px 0 0 0px;
}
</style>
<script>

$(function(){
 	// Ajax Submission
	$('#add_comment_btn').click(function(){
	  	var oEditor = FCKeditorAPI.GetInstance('wcontent') ;
		var values = oEditor.GetHTML();
		if (values == '') {
			alert('내용을 입력하세요!');
			return false;
	 	} else {
	 		$.ajax({
	 			type: "POST",
	 			url: "/action/index",
	 			data: {
					"url1": "/<?=$this->uri->segment(1)?>/reply_edit/",
					"url2": "/page/<?=$page_account?>",
	 				"contents":values,
	 				"no": <?= $views['no'] ?>,
	 				"table": '<?= MENU_BOARD_NAME_EN ?>',
	 				"resize": '<?=$img_size?>',
					"wname":"name",
					"module_no": '<?= MENU_ID ?>',
	 				"skin": '<?=MENU_SKIN?>'
			 	},
			 	complete: function(r){
			  		$('#comment_list').html(r.responseText);
			  		oEditor.SetHTML('');
		  		}
	 		})
	 	}
	});

});
function reply_edit(r_no, url1, url2){
	$(function(){
		jQuery.FrameDialog
		.create({
			url: url1+r_no+url2,
			title: '댓글 수정',
			width : 800,
			height : 450,
			draggable : false,
			resizable : false,
			buttons: { "닫기": function() { $(this).dialog("close"); } }
		})
	});
}
/*
$(function(){
	$("a").each(function(){
		if($(this).attr("id")=="comment_edit") {
			$(this).click(function(){
				var r_no = $(this).attr("rev");
				jQuery.FrameDialog
				.create({
					url: "<?=$this->uri->segment(1)?>/reply_edit/"+r_no+"/page/<?=$page_account?>",
					title: '댓글 수정',
					width : 800,
					height : 450,
					draggable : false,
					resizable : false,
					buttons: { "닫기": function() { $(this).dialog("close"); } }
				})
			});
		}
	});
});
*/
function reply_delete(board_id,row_no,views_no){
	$(function(){
		$.ajax({
 			type: "POST",
 			url: "/action/delete",
 			data: {
 				"board_id" : board_id,
 				"row_no" : row_no,
 				"views_no" : views_no
 			},
 			success : function(data,status){
 				if(data == "1")
 					$('#row_num_'+row_no).remove();
 				else
 					alert(data);
 			}
		});
	});
}
</script>

<h2><?= MENU_BOARD_NAME ?></h2><br>
<table cellspacing="0" class="boardview1" border=0>

<strong><?=$views['subject']?></strong>

<colgroup>
	<col>
	<col>
</colgroup>
<thead>
<tr>
	<th scope="row"><?=($views['nickname'])?$views['nickname']:$views['user_name']?></th>
	<td><img src='/images/icon_comment.gif' border='0' align='absmiddle' title="코멘트"> <span class="view_num"><?=number_format($views['reply_count'])?></span> <img src='/images/icon_refer.gif' border='0' align='absmiddle' title="조회수"> <span class="view_num"><?=number_format($views['hit'])?></span> <img src='/images/icon_good.gif' border='0' align='absmiddle' title="추천"> <span class="view_num" id="recommend_count"><?=number_format($views['voted_count'])?></span>
	 <img src='/images/icon_good.gif' border='0' align='absmiddle' title="신고"> <span class="view_num" id="blamed_count"><?=number_format($views['blamed_count'])?></span>
	<img src='/images/icon_clock.gif' border='0' align='absmiddle'> <span class="date"><?= $views['reg_date']?></span> <span class="ip"><?=($this->session->userdata('auth_code') >= '15')?$views['ip']:''?></span></td>
</tr>
</thead>
<tbody>
<tr>
	<td colspan="2" class="wr_contents">
		<? $views['contents'] = $this->board_model->auto_link($views['contents']); ?>
		<? $views['contents'] = str_replace("<img", "<img name='target_resize_image[]' onclick='image_window(this)'", $views['contents']); ?>
		<!--내용 출력-->
        <?=$views['contents']?>
		<!-- file_list -->
		<? if($files_cnt > 0) { ?>
		<br />
		<div id="file_list">
		<? foreach ( $files as $fs ) { ?>
       	<a href="/<?=$this->uri->segment(1)?>/download/<?=$views['no']?>/<?=$fs['no']?>"><?=($fs['original_name'])?$fs['original_name']:$fs['file_name']?></a><br>
		<? } ?>
		</div>
		<? } ?>
		<!--// file_list-->
	</td>
</tr>
<tr>
	<td colspan="2" class="good">
		<div id="gBtn7" style="float:right">
			<? if ( $this->session->userdata('user_id') ) { ?>
		<a href="#" id="vote_icon"><span class="btn_img"><img src="/images/vote_for.png" width="16" height="16" border="0" alt="" align="absmiddle"> 추천</span></a> <a href="#" id="vote_against_icon"><span class="btn_img"><img src="/images/vote_against.png" width="16" height="16" border="0" alt="" align="absmiddle"> 신고</span></a>
		<script>
		$("#vote_icon").click(function(){
			var cfm = confirm('추천하시겠습니까?');
			if(cfm) {
				$.ajax({
					type: "POST",
					url: "/action/recommend",
					data: {"no":"<?=$views['no']?>", "mode":"recommend", "table":"<?=MENU_BOARD_NAME_EN?>"},
					success: function(data, textStatus){
						alert('추천되었습니다.');
						$("#recommend_count").text(data);
					}
				});
			}
		});
		$("#vote_against_icon").click(function(){
			var cfm = confirm('신고하시겠습니까?');
			if(cfm) {
				$.ajax({
					type: "POST",
					url: "/action/recommend",
					data: {"no":"<?=$views['no']?>", "mode":"blamed", "table":"<?=MENU_BOARD_NAME_EN?>"},
					success: function(data, textStatus){
						alert('신고되었습니다.');
						$("#blamed_count").text(data);
					}
				});
			}
		});
		</script>
		<? } else { ?>
		<a href="javascript:alert('로그인이 필요합니다.')"><span class="btn_img"><img src="/images/vote_for.png" width="16" height="16" border="0" alt="" align="absmiddle"> 추천</span></a> <a href="javascript:alert('로그인이 필요합니다.')"><span class="btn_img"><img src="/images/vote_against.png" width="16" height="16" border="0" alt="" align="absmiddle"> 신고</span></a>
		<? } ?>
		</div>
	</td>
</tr>
<?
if ($tags){
?>
<tr>
	<td colspan="2" class="tags"><b>태그</b> : <?=$tags?></td>
</tr>
<?
}
?>

</tbody>
</table>

<div class="board_button">
	<div style="float:left;" id="gBtn7">
	</div>
	<div style="float:right;" id="gBtn7">

		<a href="/<?= $this->seg_exp[0] ?>/lists/page/<?=$page_account?>" id="btn_list"><span>&nbsp;&nbsp;목록&nbsp;&nbsp;</span></a>
		<? if ($this->session->userdata('userid') == $views['user_id']) { ?><a href="#" id="btn_list" class="edit_post"><span>&nbsp;&nbsp;수정&nbsp;&nbsp;</span></a>
		<script>
		$(".edit_post").click(function(){
			jQuery.FrameDialog
				.create({
					url: "/<?= $this->seg_exp[0] ?>/edit/<?=$views['no']?>/page/<?=$page_account?>",
					title: '글 수정',
					width : 820,
					height : 600,
					draggable : false,
					resizable : false,
					buttons: { "닫기": function() { $(this).dialog("close"); } }
				})
		});
		</script>

		<? } ?>
		<? if ($this->session->userdata('userid') == $views['user_id']) { ?><a href="/<?= $this->seg_exp[0] ?>/delete/<?=$views['no']?>/page/<?=$page_account?>" id="btn_list"><span>&nbsp;&nbsp;삭제&nbsp;&nbsp;</span></a><? } ?>
		<a href="/<?= $this->seg_exp[0] ?>/write/0" class="write_post"><span>&nbsp;&nbsp;글쓰기&nbsp;&nbsp;</span></a>

		<!--a href="#" id="btn_list" class="write_post"><span>&nbsp;&nbsp;글쓰기&nbsp;&nbsp;</span></a-->
		<script>
		$(".write_post").click(function(){
			jQuery.FrameDialog
				.create({
					url: '/<?= $this->seg_exp[0] ?>/write/0',
					title: '글쓰기',
					width : 820,
					height : 600,
					draggable : false,
					resizable : false,
					buttons: { "닫기": function() { $(this).dialog("close"); } }
				})
		});
		</script>

	 </div>
</div>
<BR>
<!--덧글-->
<div id="comment_list">
<?
$reply_cnt = count($replys);
if ( $reply_cnt > 0 ) { ?>
<table border=0 cellpadding=0 cellspacing=0 width="600" style="margin-top:15px;">
<tr>
	<td height=1 colspan=2 bgcolor="#dddddd"><td>
</tr>
<?
foreach ($replys as $row) {
?>
<tr id="row_num_<?=$row['no']?>">
	<td>
		<table border=0 cellpadding=0 cellspacing=0 width="100%">
		<tr>
			<td height=5 colspan=2></td>
		</tr>
		<tr id="row_2_<?=$row['no']?>">
			<!--td width=73 valign=top>
			<img src="/images/noimage.gif" width=58 height=58 style="border:3px solid #f2f2f2">
			</td-->
			<!--td width=2 bgcolor="#dedede"></td-->
			<td valign=top style="padding-left:10px;">
				<div style="height:28px; line-height:20px;">
					<div style="float:left; margin:0px 0 0 2px;">
					<strong><a href="#" name="row_num_<?=$row['no']?>"><?=($row['nickname'])?$row['nickname']:$row['username']?></a></strong>
					<span style="color:#888888; font-size:11px;"><?=$row['reg_date']?></span>
					</div>
					<div style="float:right;">
					&nbsp;<span style="color:#B2B2B2; font-size:11px;"><?=($this->session->userdata('auth_code') >= '15')?$row['ip']:'' ?></span>&nbsp;
					<?if($row['user_id'] == $this->session->userdata('userid')) { ?>
					<a href="javascript:reply_edit('<?=$row['no']?>','/<?=$this->uri->segment(1)?>/reply_edit/', '/page/<?=$page_account?>');"><img src="/images/co_btn_modify.gif" align="absmiddle"></a> <a href="javascript:reply_delete('<?=MENU_BOARD_NAME_EN?>','<?=$row['no']?>','<?=$views['no']?>');" onclick="return confirm(&quot;삭제하시겠습니까?&quot;)"><img src="/images/co_btn_delete.gif" align="absmiddle"></a>
					<? } ?>
					</div>
				</div>
				<div style='line-height:18px; padding:7px; word-break:break-all; overflow:hidden; clear:both; text-align:left; '>
					<? $row['contents'] = $this->board_model->auto_link($row['contents']); ?>
					<?=$row['contents']?>
				</div>
			</td>
		</tr>
		<tr>
			<td height=5 colspan=2></td>
		</tr>
		<tr>
			<td height=1 colspan=2 bgcolor="#dddddd"><td>
		</tr>
		</table>
	</td>
</tr>
<? } ?>
</table>
<? } ?>
</div>
	<? if(($this->session->userdata('auth_code') == 'ADMIN' ) or ($this->session->userdata('auth_code') >= $reply_perm) or ($reply_perm == 1) ) {
	?>
	<div id="comment_add">
	<form name="add_comment" id="add_comment" method="post">
<?php

if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) ) {
    ?>
    <textarea name='wcontent' cols="80" rows="10"></textarea>
    <?php
    } else {
        echo $fck_write;
    }

?>


	<input type="button" value="등록" id="add_comment_btn">
	</form>
	</div>
	<? } ?>


    <table cellspacing="0" cellpadding="0" class="board_list">
    <col width="50" />
    <col />
    <col width="110" />
    <col width="80" />
    <col width="50" />
	<col width="50" />
    <tr>
	    <th>번호</th>
	    <th>제&nbsp;&nbsp;&nbsp;목</th>
	    <th>글쓴이</th>
	    <th>날짜</th>
	    <th>조회</th>
		<th>추천수</th>
	</tr>
	<? foreach ($bottom_all as $lt) {

		$vals = mktime(date("H") - 24, date("i"), date("s"), date("m"), date("d"), date("Y"));
		$dates = strtotime($lt['reg_date']);

		if ($dates >= $vals) {
			$new_icon = ' <img src="/images/icon_new.gif">';
		} else {
			$new_icon = ' ';
		}

		if ($lt['hit'] > 100) {
			$bl1 = '<b>';
			$bl2 = '</b>';
		} else {
			$bl1 = '';
			$bl2 = '';
		}

		if ($lt['voted_count'] > 30) {
			$recom_icon = ' <img src="/images/recom_new.gif">';
		} else {
			$recom_icon = ' ';
		}


	   $bubble_title = strip_tags($this->common->strcut_utf8($lt['contents'], 200));
	   if($lt['no'] == $views['no']) {
		   $sub_css = "subject_bold";
	   } else {
		   $sub_css = "subject";
	   }

	?>
    <tr class="bg0">
    	<td class="num"><?= $lt['no'] ?></td>
     	<td class="<?=$sub_css?>"><a href="/<?= $this->seg_exp[0] ?>/view/<?= $lt['no'] ?>/page/<?=$page_account?>" title="<?= $bubble_title ?>"><?= $bl1 ?><?= $this->
common->strcut_utf8(strip_tags($lt['subject']), 30) ?><?= $bl2 ?></a> [<?=$lt['reply_count']?>]<?= $new_icon ?><?= $recom_icon ?></td>
		<td class="name" align="center"><span class='guest'><?= ($lt['nickname'])?$lt['nickname']:$lt['user_name'] ?></span></td>
        <td class="datetime"><?= substr($lt['reg_date'], 0, 10) ?></td>
        <td class="hit"><?= $lt['hit'] ?></td>
	    <td class="hit"><?= $lt['voted_count'] ?></td>
  	</tr>
	<? } ?>
    </table>


<div class="board_button">
	<div style="float:left;" id="gBtn7">
	</div>
	<div style="float:right;" id="gBtn7">
	<a href="/<?= $this->seg_exp[0] ?>/lists/page/<?=$page_account?>" id="btn_list"><span>&nbsp;&nbsp;목록&nbsp;&nbsp;</span></a>
	 </div>
</div>

<script type="text/javascript" src="/include/js/imageresize.js"></script>
<script language="JavaScript">
	window.onload=function() {
		resizeBoardImage(<?=$img_size?>);
	}
</script>