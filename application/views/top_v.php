<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<?php if(@$this->uri->segment(2) == 'view') { ?>
<!-- Facebook Interface -->
<meta property="og:title" content="<?=$views['subject']?>"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>"/>
<meta property="og:image" content=""/>
<meta property="og:site_name" content="CodeIgniter한국사용자포럼"/>
<meta property="fb:admins" content="1635036611"/>
<meta property="og:description" content="<?=mb_substr(strip_tags($views['contents']), 0, 150)?>"/>
<!-- Facebook Interface -->
<? } else { ?>
<meta name="description" content="CodeIgniter 한국사용자포럼, PHP Framework"/>
<meta name="keywords" content="CodeIgniter, 한국사용자포럼"/>
<? } ?>
<meta name="author" content="blumine@paran.com"/>
<meta name="verify-v1" content="7kp6EtaGhtyEGsfRh5SLPMGHpeTWE49I9fv96A8McIE=" />
<link rel="image_src" href="http://codeigniter-kr.org/images/logo_ci1.png" />
<link rel="shortcut icon" href="http://codeigniter-kr.org/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?=CSS_DIR?>/default.css" media="screen"/>
<link href="<?=CSS_DIR?>/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shCore.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushCss.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushDiff.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushPhp.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushSql.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushXml.js"></script>
<script type="text/javascript" src="<?=HIGH_DIR?>/scripts/shBrushJava.js"></script>
<link type="text/css" rel="stylesheet" href="<?=HIGH_DIR?>/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="<?=HIGH_DIR?>/styles/shThemeDefault.css"/>
<script type="text/javascript">
	SyntaxHighlighter.config.clipboardSwf = '<?=HIGH_DIR?>/scripts/clipboard.swf';
	SyntaxHighlighter.all();
</script>

<script type="text/javascript" src="<?=JS_DIR?>/common.js"></script>
<script type="text/javascript" src="<?= JS_DIR ?>/jquery-1.3.2.js"></script>
<script type="text/javascript"  src="<?=JS_DIR?>/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
<script type="text/javascript" src="<?=JS_DIR?>/jquery.jScale.js"></script>
<script type="text/javascript" src="<?= JS_DIR ?>/jquery.post.js"></script>
<script>
$(document).ready(function(){
	$("#mainsearch_btn").click(function(){
		if($("#mainq").val() == ''){
			alert('검색어를 입력하세요');
			return false;
		} else {
			var act = '/search/index/q/'+$("#mainq").val();
			$("#main_search").attr('action', act).submit();
    	}
	});
});

function top_search_enter(form) {
    var keycode = window.event.keyCode;
    if(keycode == 13) $("#mainsearch_btn").click();
}
</script>

<?php if(@$this->uri->segment(2) == 'view') { ?>
	<title><?=$views['subject']?> - CodeIgniter 한국사용자포럼</title>
<?php } else {?>
	<title>CodeIgniter 한국사용자포럼</title>
<?php }?>

</head>

<body>

<div class="outer-container">

<div class="inner-container">

	<div class="top">
		<? if( $this->session->userdata('user_id') ) : ?>
		<? if( $this->session->userdata('auth_code') >= '15' ) : ?><a href='/admin/main'>관리</a>&nbsp;<? endif; ?>
		<a href='/auth/modify'>회원정보 수정</a>&nbsp;
		<a href='/irc'>IRC 웹채팅</a>&nbsp;
		<a href='/auth/logout'>로그아웃</a>
		<? else:
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode = base64_encode($rpath);
		?>
		<? //회원가입 찾기 로그인  ?>
		<a href='/auth/register'>회원 가입</a>&nbsp;
		<a href='/auth/forgot_password'>아이디/비밀번호 찾기</a>&nbsp;
		<a href="/auth/login/<?=$rpath_encode?>">로그인</a>
		<? endif; ?>
	</div>

	<div class="header">

		<div class="title">
			<span class="left" style="padding-left:20px;"><a href="http://codeigniter.com" target="_blank"><!--img src="<?=THUMB_IMG?>?src=/images/ci_logo_flame.jpg&h=70&zc=1" align="absmiddle" border="0"--><img src="/system/../images/logo_ci1.png" border="0"></a></span>
			<span class="sitename"> &nbsp;<a href="/index.php">CodeIgniter 한국사용자포럼</a></span> <span class="t_low">BETA</span>
			<div class="slogan">빠르고, 유연한 PHP Framework!</div>

		</div>

	</div>

	<div class="path">

		<div class="nav">
			<a href="/">Home</a> <? if($this->uri->segment(1)) { ?>&#8250; <?=$this->uri->segment(1)?> <? } ?> <? if($this->uri->segment(2)) { ?>&#8250; <?=$this->uri->segment(2)?> <? } ?>
		</div>

		<div class="right">
		<!-- //통합검색 기능추가 by emc (2009/08/19) -->
		<form id="main_search" method="post" action="Search" onsubmit="javascript:return false;">
			<input name="mainq" id="mainq" class="searchfield" value="<?//=$search_word ?>" onkeypress="top_search_enter(document.mainq);">
			<input type="submit" id="mainsearch_btn" value="검색" class="searchbutton">
		</form>
		</div>

	</div>
<?php if($this->uri->segment('2')=='write' or $this->uri->segment('2')=='edit') { 	?>
	<div class="content0">
<?php } else { ?>
	<div class="main">

		<div class="content">
<?php }  ?>