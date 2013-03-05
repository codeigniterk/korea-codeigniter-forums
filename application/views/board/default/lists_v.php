<script type="text/javascript" src="<?php echo JS_DIR ?>/jquery.post.js"></script>
<script>
$(document).ready(function(){
	$("#search_btn").click(function(){
		var sfl_val = $(":select:option[name=sfl]:selected").val();
		if($("#q").val() == ''){
			alert('검색어를 입력하세요');
			return false;
		} else {
			var act = '<?php echo  $url ?>/q/'+$("#q").val()+'/sfl/'+sfl_val;
			$("#bd_search").attr('action', act).submit();
    	}
	});
});

function board_search_enter(form) {
    var keycode = window.event.keyCode;
    if(keycode == 13) $("#search_btn").click();
}
</script>
<style>
.board_list { clear:both; width:100%; table-layout:fixed; margin:5px 0 0 0; }
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
.board_search .stx { height:18px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; }
</style>

<h2><?php echo  MENU_BOARD_NAME ?></h2>
<table width="97%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
    <table cellspacing="0" cellpadding="0" class="board_list">
    <col width="50" />
    <col />
    <col width="80" />
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

<?php
if($list_total > 0) {

foreach ($list as $lt)
{
	$vals = mktime(date("H") - 24, date("i"), date("s"), date
		("m"), date("d"), date("Y"));
	$dates = strtotime($lt['reg_date']);

	if ($dates >= $vals)
	{
		$new_icon = ' <img src="/images/icon_new.gif">';
	}
	else
	{
		$new_icon = ' ';
	}

	if ($lt['hit'] > 100)
	{
		$bl1 = '<b>';
		$bl2 = '</b>';
	}
	else
	{
		$bl1 = '';
		$bl2 = '';
	}

	if ($lt['voted_count'] > 30)
	{
		$recom_icon = ' <img src="/images/recom_new.gif">';
	}
	else
	{
		$recom_icon = ' ';
	}

    $bubble_title = strip_tags(strcut_utf8($lt['contents'], 200));
?>
 	<tr class="bg0">
    	<td class="num"><?php echo  $lt['no'] ?></td>
     	<td class="subject"><a href="/<?php echo  $this->seg_exp[0] ?>/view/<?php echo  $lt['no'] ?>/page/<?php echo $page_account?>/<?php echo $search_url?><?php echo $search_sfl?>" title="<?php echo  $bubble_title ?>"><?php echo  $bl1 ?><?php echo  strcut_utf8(strip_tags($lt['subject']), 30) ?><?php echo  $bl2 ?></a> [<?php echo $lt['reply_count']?>]<?php echo  $new_icon ?><?php echo  $recom_icon ?></td>
		<td class="name" align="center"><span class='guest'><?  if($lt['user_name']) { echo $lt['user_name']; } else { echo $lt['user_name']; } ?></span></td>
        <td class="datetime"><?php echo  substr($lt['reg_date'], 0, 10) ?></td>
        <td class="hit"><?php echo  $lt['hit'] ?></td>
	    <td class="hit"><?php echo  $lt['voted_count'] ?></td>
  	</tr>
<?php
}
}
else
{
?>
	<tr class="bg0">
		<td class="num" colspan="6">게시물이 없습니다.</td>
  	</tr>
<?php
}
?>
    </table>

    <div class="board_button">

        <div style="float:left;"></div>
        <div style="float:right;">

		<a href="/<?php echo  $this->seg_exp[0] ?>/write/0"><img src="/images/btn_write.gif" border='0'></a>

		<script>
		$("#write_post").click(function(){
			jQuery.FrameDialog
				.create({
					url: '/<?php echo  $this->seg_exp[0] ?>/write/0',
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

    <!-- 페이지 -->
    <div class="board_page"><?php echo  $pagination_links ?></div>

    <!-- 검색 -->
    <div class="board_search">
    <form id="bd_search" method="post" onsubmit="javascript:return false;">
<?php
$sfl_arr = array('subject'=>'제목', 'contents'=>'내용', 'all'=>'제목+내용', 'user_id'=>'회원아이디', 'user_name'=>'닉네임');
?>
        <select name="sfl">
<?php
while (list($key, $value) = each($sfl_arr))
{
	if ($sfl == $key) {
		$chk = ' selected';
	} else {
		$chk = '';
	}
?>
        	<option value="<?php echo $key?>" <?php echo $chk?>><?php echo $value?></option>
<?php
}
?>

        </select>
        <input name="q" id="q" class="stx" maxlength="15" value="<?php echo $search_word?>" onkeypress="board_search_enter(document.q);">
        <input type="button" id="search_btn" value="검색">
    </form>
    </div>

	</td>
</tr>
</table>
