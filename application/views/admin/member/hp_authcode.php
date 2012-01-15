<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="<?=SV_DIR1?>/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/main1.css">
<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<?
//echo"--- $_GET[user_hp] -- $_SERVER[DOCUMENT_ROOT]";
if( $mode == 'first' ) {

$awdd= array("-", ")", "(", "_", ".", "\/");
$hp=str_replace($awdd, "", $this->uri->segment(3));


	// 이 아래 sms 발송모듈 삽입
	$NAN = rand(100000, 999999);
	$tdt1=date("Y-m-d H:i:s");

	include ("/home/hibori/html/include/class.sms.php");

	$sms_server	= "211.172.232.124";	## SMS 서버
	$sms_id		= "hibori";				## icode 아이디
	$sms_pw		= "qhfl2674";				## icode 패스워드
	$portcode	= 2;				## 정액제 : 2, 충전식 : 1

	$SMS	= new SMS;
	$SMS->SMS_con($sms_server,$sms_id,$sms_pw,$portcode);

	$tran_phone	= $hp;		# 수신번호
	$tran_callback	= "0231432674";			# 회신번호
	$tran_msg		= "하이보리 인증번호는 [ $NAN ] 입니다.";	# 발송 메세지
	$tran_msg1 = iconv("UTF-8", "EUC-KR", $tran_msg);
	$tran_date	= "";				#발송시간
	#즉시 전송일 경우 $tran_date	= "" ;
	#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

	$result = $SMS->Add($tran_phone,"$tran_callback","$sms_id","$tran_msg1","$tran_date");
	//if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";
	//$result = $SMS->Send(); //실제 발송요청
	if ($result) {
	//	echo "SMS 서버에 접속했습니다.<br>";
		$success = $fail = 0;
		foreach($SMS->Result as $result) {
			list($phone,$code)=explode(":",$result);
			if ($code=="Error") {
				echo "
			<script>
				alert('에러가 발생했습니다. 다시 전송하세요.');
			</script>
			";
				$fail++;
			} else {

				echo"
				<script>
					alert('휴대폰으로 인증번호가 전송되었습니다. ');
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

			</script>
	";
	//sms 끝
?>
<br>
발송된 인증번호는 [ <?=$NAN?> ] 입니다. <br>
<br>인증번호와 고객님의 휴대폰으로 전송된 인증번호가 일치하면 아래 비밀번호 전송을 누르세요<br><br><br>
<a href="<?=SV_DIR?>/admin/passwd_send/<?=$this->uri->segment(3)?>/send">비밀번호 전송</a>
<?
}

if( $mode == 'last' ) {

$awdd= array("-", ")", "(", "_", ".", "\/");
$hp=str_replace($awdd, "", $this->uri->segment(3));

$qur="select user_nm from user where user_hp = ".$hp." ";
$q=$this->db->query($qur);
$qs =$q->row();

$nan = rand(100000, 999999);
$nan_md5 = md5($nan);
$sql= "update user set user_pw='$nan_md5' where user_hp = '$hp'";
$Res = $this->db->query($sql);

include ("/home/hibori/html/include/class.sms.php");

	$sms_server	= "211.172.232.124";	## SMS 서버
	$sms_id		= "hibori";				## icode 아이디
	$sms_pw		= "qhfl2674";				## icode 패스워드
	$portcode	= 2;				## 정액제 : 2, 충전식 : 1

	$SMS	= new SMS;
	$SMS->SMS_con($sms_server,$sms_id,$sms_pw,$portcode);

if($Res) {
	$tran_msg		= $qs->user_nm ."님의 하이보리 임시 비밀번호는  [ ".$nan." ] 입니다.";	# 발송 메세지
	$tran_msg1 = iconv("UTF-8", "EUC-KR", $tran_msg);
	$tran_date	= "";				#발송시간
	#즉시 전송일 경우 $tran_date	= "" ;
	#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

	$result = $SMS->Add($hp,"0231432674","hibori",$tran_msg1,$tran_date);
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
				alert('".$qs->user_nm." 님의 휴대폰으로 임시 비밀번호가 전송되었습니다. ');
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
?>
<br>
비밀번호를 고객님의 휴대폰으로 발송했습니다.<br>
<br>휴대폰으로 받은 비밀번호로 로그인후 마이보리에서 비밀번호 수정후 사용하시라고 고객에게 안내<br><br><br>
<a href="" onclick="self.close();">닫기</a>
<?
}
?>