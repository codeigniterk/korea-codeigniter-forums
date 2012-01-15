<style>
ul, ol, li, h4, h5{margin:0; padding:0; font-size:12px;}
.q_latest{width:100%;} /* 전체 크기 조절 */
.q_latest_ol{list-style:none;}
.q_latest_ol h4{padding-left:5px; border-bottom:2px solid #696969;}
.q_latest_ol ul{list-style:none;}
.q_latest_ol li{margin-top:5px; width:98%;}
.comment{font-family:굴림; font-size:8pt; color:#FF6633;}
.q_latest_line{clear:both; height:1px; border-bottom:1px dotted #dedede; font-size:1px;}
</style>
<table border="0" width="640">
<tr><td height="20" bgcolor="#B2B2B2" colspan="2">샘플 예제 리스트</td></tr>
<tr><td height="20" colspan="2"></td></tr>
<? foreach($arr as $arrs){
$arr_link = explode(".", $arrs);
$arr1 = explode("_", $arr_link[0]);
//var_dump($arr_link);
switch($arr1[1]){
	case ("lib"):
		$title = "클래스";
	break;
	case ("hlp"):
		$title = "헬퍼";
	break;
	case ("gnl"):
		$title = "일반토픽";
	break;
}
?>
<tr>
	<td width="30%"><?=$title?></td>
	<td width="70%" valign="top">
	<a href="<?=BASEURL?>view_frame/index/<?=$arr1[0]?>" target="_blank"><?=$arr1[0]?></a>
	</td>
</tr>
<? } ?>
</table>