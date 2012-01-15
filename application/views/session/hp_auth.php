<?
include ($_SERVER[DOCUMENT_ROOT]."/common/main_func.php");
$connect = db_conn();
?>
<script language="javascript">
function snow_close(idx)
{
	//document.domain = '<?=$_SERVER[HTTP_HOST]?>';
	var divObj2=opener.document.seform;

	if(idx == 1){
	divObj2.cert_reg.value=1;
	divObj2.auth_code.focus();
	}
	if(idx == 2){
	divObj2.cert_reg.value=0;
	divObj2.user_hp.value="";
	divObj2.user_hp.focus();
	}
window.close();
}
</script>
<?
//echo"--- $_GET[user_hp] -- $_SERVER[DOCUMENT_ROOT]";

$awdd= array("-", ")", "(", "_", ".", "\/");
$hp=str_replace($awdd, "", $_POST[user_hp]);

$query="select user_id, user_hp from user where user_hp = '$hp'";
//echo "<br>$hp--$query<br>";
$res=mysql_query($query, $connect);
$row=mysql_fetch_array($res);

$tdt=date("Y-m-d");
$query1="select cert_user_hp from sms_certification where cert_user_hp = '$hp' and cert_dt like '".$tdt."%'";

$res1=mysql_query($query1, $connect);
$num = mysql_num_rows($res1);
//echo "<br>$num --<br>";
if($num > '14') {
	echo"
	1일 인증 제한건수(5회)를 초과했습니다.<br>
	<a href='#' onclick='javascript:window.close();'>닫기<a/>
	";
	exit;
}
if($hp == $row[user_hp]) {
	// 이 아래 sms 발송모듈 삽입
	$NAN = rand(100000, 999999);
	$tdt1=date("Y-m-d H:i:s");

	include ($_SERVER[DOCUMENT_ROOT]."/include/class.sms.php");

	$sms_server	= "211.172.232.124";	## SMS 서버
	$sms_id		= "hibori";				## icode 아이디
	$sms_pw		= "qhfl2674";				## icode 패스워드
	$portcode	= 2;				## 정액제 : 2, 충전식 : 1

	$SMS	= new SMS;
	$SMS->SMS_con($sms_server,$sms_id,$sms_pw,$portcode);

	$tran_phone	= $row[user_hp];		# 수신번호
	$tran_callback	= "0231432674";			# 회신번호
	$tran_msg		= "하이보리 인증번호는 [ $NAN ] 입니다.";	# 발송 메세지
	$tran_msg1 = iconv("UTF-8", "EUC-KR", $tran_msg);
	$tran_date	= "";				#발송시간
	#즉시 전송일 경우 $tran_date	= "" ;
	#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

	$result = $SMS->Add($tran_phone,"$tran_callback","$sms_id","$tran_msg1","$tran_date");
	//if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";
	$result = $SMS->Send(); //실제 발송요청
	if ($result) {
	//	echo "SMS 서버에 접속했습니다.<br>";
		$success = $fail = 0;
		foreach($SMS->Result as $result) {
			list($phone,$code)=explode(":",$result);
			if ($code=="Error") {
				echo "
			<script>
					alert('
			에러가 발생했습니다. 다시 전송하세요.');
			snow_close(2);
			</script>
			";
				$fail++;
			} else {
				$qt = "insert into sms_certification set cert_user_id='$row[user_id]',
						cert_user_hp = '$row[user_hp]',
						cert_no = '$NAN',
						cert_dt = '$tdt1'
						";
				mysql_query($qt);
				echo"

				<script>
					alert('	휴대폰으로 인증번호가 전송되었습니다. ');
			snow_close(1);
			</script>
				";
				$success++;
			}
		}
		//echo $success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
		$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
	}
	else echo "
	<script>
					alert('에러: SMS 서버와 통신이 불안정합니다. 다시 전송하세요.');
			snow_close(2);
			</script>
	";
	//sms 끝

} else {
	echo"
	<script>
					alert('	휴대폰번호가 틀립니다. 확인후 이용하세요');
			snow_close(2);
			</script>
	";
}
?>