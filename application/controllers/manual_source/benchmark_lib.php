<?php
/**
 * 벤치마크 Benchmarking Class
 *
 * Created on 2010. 1. 20.
 * @author 웅파 <blumine@gmail.com>
 * @package library
 * @subpackage controllers
 * @version 1.0
 */

class Benchmark_lib extends Controller {

	function Benchmark_lib()
	{
		parent :: Controller();
	}

	function index() {
		//프로파일링 선언
		//시작점1 my_mark_start과 종료점1 my_mark_end의 실행시간을 프로파일러에 자동으로 보여줌
		//_start, _end 로 접미사를 달고 앞부분의 단어를 동일하게 사용하면 프로파일러에서 자동 노출
		$this->output->enable_profiler(TRUE);

		//시작점1 선언
		$this->benchmark->mark('my_mark_start');

		for($i=1;$i < 500; $i++) {
			echo $i."-";
		}
		//종료점1 선언
		$this->benchmark->mark('my_mark_end');

		//시작점2 선언
		$this->benchmark->mark('another_mark_start');
		echo "<BR><BR>";
		for($j=1;$j < 300; $j++) {
			echo $j."-";
		}
		//종료점2 선언
		$this->benchmark->mark('another_mark_end');

		echo "<BR>";
		echo "<BR>";
		//시작점1과 종료점1 사이의 시간 측정
		echo "500번 반복시간 : ".$this->benchmark->elapsed_time('my_mark_start', 'my_mark_end');
		echo "<BR>";
		echo "<BR>";
		//시작점2과 종료점2 사이의 시간 측정
		echo "300번 반복시간 : ".$this->benchmark->elapsed_time('another_mark_start', 'another_mark_end');
		echo "<BR>";
		echo "<BR>";
		//Codeigniter 시작부터 최종 출력까지의 시간
		// {elapsed_time} 축약형태도 가능
		echo "Codeigniter 시작부터 최종 출력까지의 시간 : ".$this->benchmark->elapsed_time();
		echo "<BR>";
		echo "<BR>";
		//PHP 가 --enable-memory-limit 설정(configured with --enable-memory-limit)과 함께 설치되었다면
		//축약코드 {memory_usage}
		echo "이 컨트롤러가 사용한 메모리 : ".$this->benchmark->memory_usage();
		echo "<BR>";
		echo "<BR>";
		echo "아래 부분에 프로파일러가 출력됩니다";
	}
}