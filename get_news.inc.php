<?php
$result = $news->getNews();
foreach($result as $item){
	$id = $item['id'];
	$title = $item['title'];
	$category  = $item['category'];
	$description = nl2br($item['description']);
	$datetime = date('d-m-Y H:i:s', $item['datetime']);
	echo <<<LABEL
	<hr>
	<h3>$title</h3>
	<p>$description<br />[$category] @ $datetime</p>
	<a href="?id=$id">удалить</a>
LABEL;
}
?>