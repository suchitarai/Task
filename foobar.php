<?php
$str="";
for($i=1;$i<=100;$i++){
	if(($i % 3==0) && ($i % 5==0)){
		$str=$str. "foobar, ";
	}else if($i % 3==0){
		$str=$str.  "foo, ";
	}else if($i % 5==0){
		$str=$str.  "bar, ";
	}else{
		$str=$str.  $i.", ";
	}
}
$str=rtrim($str,", ");
print $str;
?>