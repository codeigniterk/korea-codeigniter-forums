<?php

 function doBeginLoading()
 {
  echo "<div id=\"beginloading\" style=\"position:absolute; left:50%; top:50%; width:1024px; height:768px; z-index:1; border: 1px none #999999; visibility: show;\" >로딩중입니다....</div>";
 }


 function doEndLoading()
 {
  echo "<script language=\"JavaScript\" type=\"text/JavaScript\">document.getElementById('beginloading').style.visibility = \"hidden\";</script>";
 }
?>