<?php
	function ie6_ban() {

		if ( strpos($_SERVER["HTTP_USER_AGENT"], 'Trident') === FALSE && (strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE 6') !== FALSE && strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE 8') !== TRUE) && strpos($_SERVER["HTTP_USER_AGENT"], 'NT 5.1') !== FALSE ) {
?>
	<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both;  position: relative; '>
		<div style='width: 850px; height: 150px;  margin: 0 auto;  padding-top: 55px; overflow: hidden; color: black; '>
			<div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div>
			<div style='width: 400px; float: left; font-family: Arial, sans-serif;'>
			<div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>아직도 IE6를 사용하시는군요!<br>Codeigniter 한국사용자포럼은 IE6를 지원하지 않습니다.</div>
			<div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>본 사이트를 보실려면 웹브라우저를 업데이트 하세요!</div>
			</div>
			<div style='width: 75px; float: left;'><a href='http://www.firefox.com' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='파이어폭스 다운로드' /></a></div>
			<div style='width: 75px; float: left;'><a href='http://www.microsoft.com/korea/windows/internet-explorer/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='인터넷 익스플로러 8 다운로드'/></a></div>
			<div style='width: 73px; float: left;'><a href='http://www.apple.com/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='사파리 다운로드'/></a></div>
			<div style='width: 73px; float: left;'><a href='http://www.google.com/chrome?hl=ko' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='구글 크롬 다운로드'/></a></div>
			<div style='width: 73px; float: left;'><a href='http://www.opera.com/download/' target='_blank'><img src='http://fs.textcube.com/blog/3/31900/attach/XfGpjgFbro.gif' style='border: none;' alt='오페라 다운로드'/></a></div>
		</div>
	</div>
<?php
		exit;
		}
	}
?>