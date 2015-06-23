<?php
$t = $news->clearStr($_POST['title']);
$c = $news->clearStr($_POST['category']);
$d = $news->clearStr($_POST['description']);
$s = $news->clearStr($_POST['source']);
if(empty($t) or empty($d)){
	$errMsg = "error";
}
$news->saveNews($t,$c,$d,$s);
header("Location: news.php");
?>