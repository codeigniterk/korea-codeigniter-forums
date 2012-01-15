<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
/*
$hook['post_controller'][] = array(
               'function' => 'doBeginLoading',
               'filename' => 'preload.php',
               'filepath' => 'hooks'
);
$hook['post_system'][] = array(
               'function' => 'doEndLoading',
               'filename' => 'preload.php',
               'filepath' => 'hooks'
);
*/
$hook['pre_system'][] = array(
               'function' => 'ie6_ban',
               'filename' => 'ie6_banned.php',
               'filepath' => 'hooks'
);
/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */