<?
//주소에서 검색어 삭제
//print_r($this->seg_exp);
if (in_array('q', $this->seg_exp)) {
	$arr_key = array_keys($this->seg_exp, "q");
	$arr_val = $arr_key[0] + 1;

    if(@$this->seg_exp[$arr_val]){
	    $search_word = $this->seg_exp[$arr_val];
    } else {
        $search_word = '검색어 없음';
    }
	$search_url = "q/".$search_word;
	$arr_q = array_search('q', $this->seg_exp);
	array_splice($this->seg_exp, $arr_q,2);
} else {
  	$search_word = '';
	$search_url = '';
}
//주소에서 검색필드 삭제
if (in_array('sfl', $this->seg_exp)) {
	$arr_key1 = array_keys($this->seg_exp, "sfl");
	$arr_val1 = $arr_key1[0] + 1;
	if(@$this->seg_exp[$arr_val1]){
	    $sfl = $this->seg_exp[$arr_val1];
    } else {
        $sfl = 'subject';
    }
	$search_sfl = "/sfl/".$sfl;
	$arr_s = array_search('sfl', $this->seg_exp);
	array_splice($this->seg_exp, $arr_s,2);
} else {
  	$sfl ='';
	$search_sfl = '';
}

$cnt = count($this->seg_exp);
$url='';
for ($i=0; $i < $cnt; $i++) {
	$url .= '/'.$this->seg_exp[$i];
	//echo $url."<BR>";
}
?>
<script type="text/javascript" src="<?= JS_DIR ?>/jquery.post.js"></script>
<script>
$(document).ready(function(){
	$("#search_btn").click(function(){
		var sfl_val = $(":select:option[name=sfl]:selected").val();
		if($("#q").val() == ''){
			alert('검색어를 입력하세요');
			return false;
		} else {
			var act = '<?= $url ?>/q/'+$("#q").val()+'/sfl/'+sfl_val;
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

<h2><?= MENU_BOARD_NAME ?></h2>
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
    <!--tr class="bg1">
        <td class="num"><b>공지</b></td>
        <td class="subject"><a href='#'><span class='notice'>사용자 포럼 사이트 제작 논의 합시다!</span></a> <a href="#"><span class='comment'>(4)</span></a> </td>
        <td class="name"><span class='member'>관리자</span></td>
        <td class="datetime">04-14</td>
        <td class="hit">425</td>
    </tr-->
	<? foreach ($list as $lt) { ?>
	<?

	$vals = mktime(date("H") - 24, date("i"), date("s"), date
		("m"), date("d"), date("Y"));
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
?>
 	<tr class="bg0">
    	<td class="num"><?= $lt['no'] ?></td>
     	<td class="subject"><a href="/<?= $this->seg_exp[0] ?>/view/<?= $lt['no'] ?>/page/<?=$page_account?>/<?=$search_url?><?=$search_sfl?>" title="<?= $bubble_title ?>"><?= $bl1 ?><?= $this->
common->strcut_utf8(strip_tags($lt['subject']), 30) ?><?= $bl2 ?></a> [<?=$lt['reply_count']?>]<?= $new_icon ?><?= $recom_icon ?></td>
		<td class="name" align="center"><span class='guest'><?  if($lt['user_name']) { echo $lt['user_name']; } else { echo $lt['user_name']; } ?></span></td>
        <td class="datetime"><?= substr($lt['reg_date'], 0, 10) ?></td>
        <td class="hit"><?= $lt['hit'] ?></td>
	    <td class="hit"><?= $lt['voted_count'] ?></td>
  	</tr>
	<? } ?>
    </table>

    <div class="board_button">

        <div style="float:left;"></div>
        <div style="float:right;">

		<a href="/<?= $this->seg_exp[0] ?>/write/0"><img src="/images/btn_write.gif" border='0'></a>

		<!--a href="#" id="write_post"><img src="/images/btn_write.gif" border='0'></a-->

		<script>
		$("#write_post").click(function(){
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

    <!-- 페이지 -->
    <div class="board_page"><?= $pagination_links ?></div>

    <!-- 검색 -->
    <div class="board_search">
    <form id="bd_search" method="post" onsubmit="javascript:return false;">
    <?
		$sfl_arr = array('subject'=>'제목', 'contents'=>'내용', 'all'=>'제목+내용', 'user_id'=>'회원아이디', 'user_name'=>'닉네임');
	?>
        <select name="sfl">
        	<? while (list($key, $value) = each($sfl_arr)) {
        		if ($sfl == $key) {
        			$chk = ' selected';
                } else {
                  	$chk = '';
                }
			?>
        	<option value="<?=$key?>" <?=$chk?>><?=$value?></option>
            <? } ?>

        </select>
        <input name="q" id="q" class="stx" maxlength="15" value="<?=$search_word?>" onkeypress="board_search_enter(document.q);">
        <input type="button" id="search_btn" value="검색">
    </form>
    </div>

	</td>
</tr>
</table>
