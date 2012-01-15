<?
include ($_SERVER[DOCUMENT_ROOT]."/common/main_func.php");
$connect = db_conn();

//print_r($_POST);
?>
<script>
function wclose()
{
//document.domain = '<?=$_SERVER[HTTP_HOST]?>';
//opener.document.location.reload();
top.opener.document.location.reload();
window.close();
}
</script>
<?
$awdd= array("-", ")", "(", "_", ".", "\/");
$hp=str_replace($awdd, "", $_POST[user_hp]);
$qry  ="select smsc.cert_no, us.user_id, us.user_nm from sms_certification as smsc, user as us where smsc.cert_user_hp = us.user_hp and smsc.cert_user_hp = '$hp' order by smsc.cert_dt desc limit 1";
$res=mysql_query($qry,$connect);
$row=mysql_fetch_array($res);
//echo $qry;
//print_r($row);
if($row[cert_no] == $_POST[auth_code]) {
//echo "인증완료 이후액션";
	include ($_SERVER[DOCUMENT_ROOT]."/include/class.sms.php");
	$sms_server	= "211.172.232.124";	## SMS 서버
	$sms_id		= "hibori";				## icode 아이디
	$sms_pw		= "qhfl2674";				## icode 패스워드
	$portcode	= 2;				## 정액제 : 2, 충전식 : 1

	$SMS	= new SMS;
	$SMS->SMS_con($sms_server,$sms_id,$sms_pw,$portcode);

	$tran_phone	= $hp;		# 수신번호
	$tran_callback	= "0231432674";			# 회신번호

	if($_POST[radio_id]=='id') {
		$tran_msg		= "$row[user_nm] 님의 하이보리 ID는  [ $row[user_id] ] 입니다.";	# 발송 메세지
		$tran_msg1 = iconv("UTF-8", "EUC-KR", $tran_msg);
		$tran_date	= "";				#발송시간
		#즉시 전송일 경우 $tran_date	= "" ;
		#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

		$result = $SMS->Add($tran_phone,"$tran_callback","$sms_id","$tran_msg1","$tran_date");
		//if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";
		$result = $SMS->Send(); //실제 발송요청
		if ($result) {
			//echo "SMS 서버에 접속했습니다.<br>";
			$success = $fail = 0;
			foreach($SMS->Result as $result) {
				list($phone,$code)=explode(":",$result);
				if ($code=="Error") {
					echo "

				<script>
					alert('에러가 발생했습니다. 다시 전송하세요.');
					wclose();
						</script>

				";
					$fail++;
				} else {

					echo"


					<script>
					alert('$row[user_nm] 님의 휴대폰으로 ID가 전송되었습니다. ');
					wclose();
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
					wclose();
						</script>
		";


	} else if($_POST[radio_id]=='pw') {
		echo"임시비밀번호 생성후 업데이트후 sms 발송";
		$nan = rand(100000, 999999);
		$nan_md5 = md5($nan);
		$sql= "update user set user_pw='$nan_md5' where user_hp = '$hp'";
		$Res = mysql_query($sql, $connect);
		if($Res) {
			$tran_msg		= "$row[user_nm] 님의 하이보리 임시 비밀번호는  [ $nan ] 입니다.";	# 발송 메세지
			$tran_msg1 = iconv("UTF-8", "EUC-KR", $tran_msg);
			$tran_date	= "";				#발송시간
			#즉시 전송일 경우 $tran_date	= "" ;
			#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

			$result = $SMS->Add($tran_phone,"$tran_callback","$sms_id","$tran_msg1","$tran_date");
			//if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";
			$result = $SMS->Send(); //실제 발송요청
			if ($result) {
				//echo "SMS 서버에 접속했습니다.<br>";
				$success = $fail = 0;
				foreach($SMS->Result as $result) {
					list($phone,$code)=explode(":",$result);
					if ($code=="Error") {
						echo "
					<script>
					alert('에러가 발생했습니다. 다시 전송하세요.');
					wclose();
						</script>
					";
						$fail++;
					} else {

						echo"

						<script>
						alert('".$row[user_nm]." 님의 휴대폰으로 임시 비밀번호가 전송되었습니다. ');
						wclose();
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
					alert('	에러: SMS 서버와 통신이 불안정합니다. 다시 전송하세요.');
					wclose();
			</script>
			";
		}
	}
} else {
echo "<script>
					alert('인증번호가 틀립니다. 다시 인증해주세요.');
					wclose();
						</script>
";
}
?>