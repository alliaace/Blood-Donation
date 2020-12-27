<?php
class timeconversions{
	function ago($time){
	$d = strtotime($time);
	$then=new DateTime($time);
	$now=new DateTime();
	$p='';
	$out;
	//console.log(then +" : " +now);
	if(($now->format('d')-$then->format('d'))>0){
		if(($now->format('d')-$then->format('d'))>1){
			$p='s';
		}
		$out=$now->format('d')-$then->format('d')." day".$p;
	}else if(($now->format('h')-$then->format('h'))>0){
		if(($now->format('h')-$then->format('h'))>1){
			$p='s';
		}
		$out=$now->format('h')-$then->format('h')." hour".$p;
	}else if(($now->format('i')-$then->format('i'))>1){
			$out=$now->format('i')-$then->format('i')." minutes".$p;
	}else{
			$out="1 minute";
	}
	return $out;
}
}

?>