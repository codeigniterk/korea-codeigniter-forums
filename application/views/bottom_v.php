<?php if($this->uri->segment('2')!='write' && $this->uri->segment('2')!='edit') { 	?>

		</div>

		<div class="navigation">

			<h2>CodeIgniter정보</h2>
			<ul>
				<li><a href="/news/lists/page/1">CI 뉴스 및 다운로드</a></li>
				<li><a href="/user_guide/" target="_blank">CI 한글매뉴얼(1.7.3)</a></li>
				<li><a href="/user_guide2.0/" target="_blank">CI 영문매뉴얼(2.0.1)</a></li>
				<!--li><a href="/sample_list/"><strong>CI 한글매뉴얼 실행예제 모음</strong></a></li-->
				<li><a href="/user_guide_print/print.php" target="_blank">한글매뉴얼 일괄출력(1.7.3)</a></li>
				<!--li><a href="#">CI Wiki</a></li-->
			</ul>

			<h2>포럼</h2>
			<ul>
				<li><a href="/notice/lists/page/1">공지사항</a></li>
				<li><a href="/free/lists/page/1">자유게시판</a></li>
				<li><a href="/tip/lists/page/1">TIP게시판</a></li>
				<li><a href="/lecture/lists/page/1">강좌게시판</a></li>
				<li><a href="/qna/lists/page/1">CI 묻고답하기</a></li>
			</ul>

			<h2>자료실</h2>
			<ul>
				<li><a href="/source/lists/page/1">CI 코드</a></li>
				<li><a href="/file/lists/page/1">일반 자료</a></li>
				<li><a href="/source/view/289/page/2/">포럼소스 다운받기</a></li>
				<li><a href="/source/view/401/page/1/">마냐님 공개보드 다운</a></li>
			</ul>

			<? if($this->session->userdata('auth_code') >= '7') {?>
			<h2>개발자 전용</h2>
			<ul>
				<li><a href="/ci/lists/page/1">포럼개발자</a></li>
				<li><a href="http://codeigniter-kr.org/trac" target="_blank">TRAC바로가기</a></li>
				<? if($this->session->userdata('auth_code') >= '15') {?>
				<li><a href="/su/lists/page/1">운영자게시판</a></li>
				<? } ?>
			</ul>
			<? } ?>
			<h2>포럼 트위터</h2>
			<ul>
			<?
			/*
			 * 트위터 목록 보여주기
			 */
			if(@$twitter){
				$i=0;
				foreach($twitter as $tw){
					if($i == 3) break;
					echo "<li><a href='http://twitter.com/codeigniterK' target='_blank'>".$tw->text."</a></li>";
					$i++;
				}
			}
			?>
			</ul>
			<div id="ad">
				<p>ICMS Banner</p>
			</div>



		</div>

		<div class="clearer">&nbsp;</div>

	</div>
<?php } else {?>
	</div>
	<?php } ?>
	<div class="footer">

		<span class="left">
			&copy; 2009 <a href="mailto:blumine@gmail.com">CodeIgniter 한글사용자포럼</a>
		</span>

		<span class="right">Sponsor by <a href="http://www.icms.kr/" target="_new">ICMS Inc.<a> &nbsp;&nbsp;<a href="http://templates.arcsin.se/" target="_new">Website template</a> by <a href="http://arcsin.se/" target="_new">Arcsin</a></span>

		<div class="clearer"></div>

	</div>

</div>

</div>

<!--구글 analytics-->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2977920-4");
pageTracker._trackPageview();
} catch(err) {}</script>
<!--구글 analytics-->
</body>

</html>