<?php
/**
 * 배열 Array helper
 *
 * Created on 2010. 3. 2.
 * @author 케이든
 * @package helper
 * @subpackage controllers
 * @version 1.0
 */
class Array_hlp extends Controller
{

	function Array_hlp()
	{
		parent :: Controller();
	}

	function index()
	{
		//load array helper
		$this->load->helper('array');

		//sample array
		$info = array
		(
			'name' => 'kaden',
			'age' => '26',
			'nationality' => 'korea'
		);

		echo '<h2>Array(배열) Helper</h2>';

		echo '<h3>샘플 배열</h3>';
		echo '<pre>';
		echo '$info = ';
		print_r($info);
		echo '</pre>';

		//element()
		echo '<h3>element()</h3>';
		echo '<p>element(\'name\', $info);<br/>';
		echo '->배열 $info에서 키 \'name\'에 해당하는 <strong>값</strong>을 리턴<br/>';
		echo '->return '.element('name', $info).'</p>';

		echo '<p>element(\'gender\', $info, \'male\');<br/>';
		echo '->배열 $info에서 키 \'gender\'에 해당하는 값을 리턴<br/>';
		echo '-><strong>키가 없거나, 해당 값이 빈 문자열, 또는 NULL</strong> 일경우, 3번째 인자로 전달된 \'male\'을 리턴<br/>';
		echo '->return '.element('gender', $info, 'male').'</p>';

		//random_element()
		echo '<h3>random_element()</h3>';
		echo '<p>random_element($info);<br/>';
		echo '->배열 $info에서 랜덤 <strong>값</strong>을 리턴<br/>';
		echo '->return '.random_element($info).'</p>';
	}
}
?>