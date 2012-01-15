<?
//주소에서 검색어 삭제
if (in_array('q', $this->seg_exp)) {
	$arr_key = array_keys($this->seg_exp, "q");
	$arr_val = $arr_key[0] + 1;
	$search_word = $this->seg_exp[$arr_val];
	$arr_q = array_search('q', $this->seg_exp);
	array_splice($this->seg_exp, $arr_q,2);
} else {
  	$search_word = '';
}
//주소에서 검색필드 삭제
if (in_array('sfl', $this->seg_exp)) {
	$arr_key1 = array_keys($this->seg_exp, "sfl");
	$arr_val1 = $arr_key1[0] + 1;
	$sfl = $this->seg_exp[$arr_val1];
	$arr_s = array_search('sfl', $this->seg_exp);
	array_splice($this->seg_exp, $arr_s,2);
} else {
  	$sfl ='';
}

$cnt = count($this->seg_exp);
$url='';
for ($i=0; $i < $cnt; $i++) {
	$url .= '/'.$this->seg_exp[$i];
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
</script>
<style>
.board_top { clear:both; }

.board_list { clear:both; width:100%; table-layout:fixed; margin:5px 0 0 0; }
.board_list th { font-weight:bold; font-size:12px; } 
.board_list th { white-space:nowrap; height:34px; overflow:hidden; text-align:center; } 
.board_list th { border-top:1px solid #ddd; border-bottom:1px solid #ddd; } 

.board_list tr.bg1 { background-color:#fafafa; border-bottom:1px solid #ddd; } 
.board_list tr.bg0 { background-color:#ffffff; border-bottom:1px solid #ddd; } 

.board_list td { padding:.5em; font-family:Tahoma; font-size:12px; color:#808080; }
/*.board_list td { border-bottom:1px solid #ddd; }*/ 
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
</style>

<?= MENU_BOARD_NAME ?><br>
<table width="97%" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
    <table cellspacing="0" cellpadding="0" class="board_list">
    <col width="50" />
    <col width="100" />
    <col />
    <tr>
	    <th>번호</th>
	    <th>이미지</th>
	    <th>제목 / 내용</th>
	</tr>
	<? foreach ($list as $lt) { ?>
	<?
    if ($list_config["new_icon"] == 'Y') {
        $vals = mktime(date("H") - $list_config["new_time"], date("i"), date("s"), date
            ("m"), date("d"), date("Y"));
        $dates = strtotime($lt['reg_date']);

        if ($dates >= $vals) {
            $new_icon = ' <img src="' . PLUGIN_DIR . '/board/views/' . $skin .
                '/img/icon_new.gif">';
        } else {
            $new_icon = ' ';
        }
    } else {
        $new_icon = ' ';
    }

    if ($list_config["view_cnt_block"] == 'Y') {
        if ($lt['hit'] > $list_config["view_cnt"]) {
            $bl1 = '<b>';
            $bl2 = '</b>';
        } else {
            $bl1 = '';
            $bl2 = '';
        }
    } else {
        $bl1 = '';
        $bl2 = '';
    }
    if ($list_config["recomm_icon"] == 'Y') {
        if ($lt['voted_count'] > $list_config["recomm_cnt"]) {
            $recom_icon = ' <img src="' . PLUGIN_DIR . '/board/views/' . $skin .
                '/img/recom_new.gif">';
        } else {
            $recom_icon = ' ';
        }
    } else {
        $recom_icon = ' ';
    }

    $bubble_title = $this->CI->common->strcut_utf8($lt['contents'], 100);
    
?> 
 	<tr class="bg0"> 
        <td class="num"><?= $lt['no'] ?></td>
        <td style="padding:10px 5px 8px 5px;">
        <? if ($lt['file_name']) { ?>
        <img src="<?=DATA_DIR?>/<?=ADMIN_ID?>/files/upload/<?=$lt['file_name']?>" width='100' height="100" style='border:1 #eeeeee solid'>   
         <? } else { ?>
         <img src="<?=PLUGIN_DIR?>/board/views/<?=$skin?>/img/noimage.gif" width='100' height="100" style='border:1 #969696 solid'>
         <? } ?>
        </td>		
        <td align="right" valign="top" style="padding:10px 0 0 0;">
           <table width="98%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td width="85%"><img src="<?=PLUGIN_DIR?>/board/views/<?=$skin?>/img/icon_subject.gif" align='absmiddle' style='border-bottom:2px solid #fff;'>&nbsp;<a href="/<?= $this->seg_exp[0] ?>/<?= $this->seg_exp[1] ?>/view/<?= $lt['no'] ?>"><?= $bl1 ?><?= $this->
CI->common->strcut_utf8($lt['subject'], $list_config["subject_cnt"]) ?><?= $bl2 ?></a></td>
			<td width="15%" align="right" class="datetime"><?= substr($lt['reg_date'], 0, 10) ?></td>
			</tr>
        	<tr>
			<td width="100%" colspan="2" valign="top" style="padding:7px 0 0 0;line-height:17px;"><span style='font-size:9pt; letter-spacing:-1px;color:#999999;'><?= $bubble_title ?></span></td>
			</tr>
			<tr>
			<td colspan="2" valign="top" style="padding:8x 0 0 0;"><span class='guest'><?= $lt['user_name'] ?></span> 
			<? if ($list_config["view_count"] == "Y") { ?>
		   	<img src="<?=PLUGIN_DIR?>/board/views/<?=$skin?>/img/icon_view.gif" border='0' align=absmiddle>조회 : <?= $lt['hit'] ?>
		    <? } ?>
		    <? if ($list_config["view_recommend"] == "Y") { ?>
		    <img src="<?=PLUGIN_DIR?>/board/views/<?=$skin?>/img/icon_good.gif" border='0' align=absmiddle>추천 : <?= $lt['voted_count'] ?>
		    <? } ?>
			</td>
			</tr>
	 		</table>
	    </td>
  	</tr>
	<? } ?> 
    </table>

    <div class="board_button">

        <div style="float:left;"></div>
        <div style="float:right;"><a href="/<?= $this->seg_exp[0] ?>/<?= $this->seg_exp[1] ?>/write"><img src="<?= PLUGIN_DIR ?>/board/views/<?= $skin ?>/img/btn_write.gif" border='0'></a></div>
    </div>

    <!-- 페이지 -->
    <div class="board_page"><?= $pagination_links ?></div>

    <!-- 검색 -->
    <div class="board_search">
    <form id="bd_search" method="post" onsubmit="javascript:return false;">
    <?
		$sfl_arr = array('subject'=>'제목', 'contents'=>'내용', 'all'=>'제목+내용', 'user_id'=>'회원아이디', 'nickname'=>'닉네임');
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
        <input name="q" id="q" class="stx" maxlength="15" value="<?=$search_word?>">
        <input type="button" id="search_btn" value="검색">
    </form>
    </div>
	
	</td>
</tr>
</table>
