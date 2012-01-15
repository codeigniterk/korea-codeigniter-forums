<?php
/**
 * HTML 테이블 Class
 *
 * Created on 2010. 3. 2.
 * @author 미드필드
 * @package library
 * @subpackage controllers
 * @version 1.0
 */

class Table_lib extends Controller {

	function Table_lib()
	{
		parent :: Controller();
        $this->load->library('table');
	}

	function index() {

        $data = array(
                     array('Name', 'Color', 'Size'),
                     array('Fred', 'Blue', 'Small'),
                     array('Mary', 'Red', 'Large'),
                     array('John', 'Green', 'Medium')
                     );

        // example 1
        echo $this->table->generate($data);


        echo '<br /><br />';
        echo '이번 예제는 데이터베이스 쿼리결과로 테이블을 만드는것을 보여줍니다.테이블 클래스는 테이블 이름들로부터 제목(heading)을 자동으로 설정합니다. set_heading() 함수를 이용하면 여러분이 직접 제목을 작성하실수도 있습니다.그 방법은 저 아래서 설명합니다.';

        $query = $this->db->query("SELECT * FROM board_news");
        echo $this->table->generate($query);

        echo '<br /><br />';
        echo '이번 예제는 각각의 파라미터를 이용해서 테이블을 만드는법을 보여줍니다';

        $this->table->set_heading('Name', 'Color', 'Size');

        $this->table->add_row('Fred', 'Blue', 'Small');
        $this->table->add_row('Mary', 'Red', 'Large');
        $this->table->add_row('John', 'Green', 'Medium');

        echo $this->table->generate();

        echo '<br /><br />';
        echo '이번예제는 위와 유사하나 개별파라미터가 아닌 배열을 통해 테이블을 만드는법을 보여줍니다';

        $this->table->set_heading(array('Name', 'Color', 'Size'));

        $this->table->add_row(array('Fred', 'Blue', 'Small'));
        $this->table->add_row(array('Mary', 'Red', 'Large'));
        $this->table->add_row(array('John', 'Green', 'Medium'));

        echo $this->table->generate();

        echo '<br /><br />';
        echo '테이블 모양 바꾸기 Changing the Look of Your Table <br/>';
        echo '여러분이 원하는 레이아웃에 맞추어 테이블 템플릿을 설정할 수 있습니다. 아래는 기본적인 테이블 템플릿 설정 예제입니다';
        $tmpl = array (
                            'table_open'          => '<table border="1" cellpadding="4" cellspacing="0">',

                            'heading_row_start'   => '<tr>',
                            'heading_row_end'     => '</tr>',
                            'heading_cell_start'  => '<th>',
                            'heading_cell_end'    => '</th>',

                            'row_start'           => '<tr>',
                            'row_end'             => '</tr>',
                            'cell_start'          => '<td>',
                            'cell_end'            => '</td>',

                            'row_alt_start'       => '<tr>',
                            'row_alt_end'         => '</tr>',
                            'cell_alt_start'      => '<td>',
                            'cell_alt_end'        => '</td>',

                            'table_close'         => '</table>'
                      );

        $this->table->set_template($tmpl);

        echo $this->table->generate();
	}
}
?>