<?php
/**
 * 캘린더Calendaring Class
 *
 * Created on 2010. 1. 21.
 * @author 웅파 <blumine@gmail.com>
 * @package library
 * @subpackage controllers
 * @version 1.0
 */

class Calendar_lib extends Controller {

	function Calendar_lib()
	{
		parent :: Controller();
	}

	function index() {
		$prefs = array (
                'start_day'    => 'saturday',
                'month_type'   => 'long',
                'day_type'     => 'short',
				'show_next_prev'  => TRUE,
                'next_prev_url'   => 'http://codeigniter-kr.org/manual_source/calendar_lib/index/'
             );

		$prefs['template'] = '
		   {table_open}<table border="0" cellpadding="0" cellspacing="0" width="300">{/table_open}
		   {heading_row_start}<tr>{/heading_row_start}
		   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
		   {heading_row_end}</tr>{/heading_row_end}
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}
		   {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		   {table_close}</table>{/table_close}
		';

		//라이브러리 로딩
		$this->load->library('calendar', $prefs);
		//현재 월
		echo "<br>기본 달력, 현재 년월<br>";
		echo $this->calendar->generate();
		//2006년 6월 달력 생성
		echo "<br>2006년 6월로 지정<br>";
		echo $this->calendar->generate(2006, 6);
		//캘린더셀로 데이터 전달
		$data = array(
               3  => 'http://codeigniter-kr.org',
               7  => 'http://naver.com',
               13 => 'http://paran.com',
               26 => 'http://google.com'
             );
		echo "<br>이전 달, 다음 달 이동 링크는 아래 달력에서만 작동합니다<br>";
		echo $this->calendar->generate($this->uri->segment(4, '2010'), $this->uri->segment(5, '2'), $data);
	}
}
?>