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
<tr>
	<td width="49%" valign="top"><?=$qna?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$etc_qna?></td>
</tr>
<tr>
	<td width="49%" valign="top"><?=$lecture?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$tip?></td>
</tr>
<tr>
	<td width="49%" valign="top"><?=$free?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$news?></td>
</tr>
<tr>
	<td width="49%" valign="top"><?=$notice?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$comment?></td>
</tr>
<tr>
	<td width="49%" valign="top"><?=$ci_make?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$ad?></td>
</tr>
<tr>
	<td width="49%" valign="top"><?=$source?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$file?></td>
</tr>
<?php
	//코멘트, 포럼 개발자 최근리스트 표시 by emc
	if($this->session->userdata('auth_code') >= '7') {
?>
<tr>
	<td width="49%" valign="top"><?=$ci?></td>
	<td width="2%"></td>
	<td width="49%" valign="top"><?=$su?></td>
</tr>

<?php } ?>
</table>