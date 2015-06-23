<?php

function req($param ,$n){
	$idir = new DirectoryIterator($param);
	foreach($idir as $file){
		if ($file->getType() == "dir" And !$file->isDot()){
			//print $file->getPathname().'<br>';
			req($file->getPathname(),$n);
		}else{
			if($file->getFilename() == $n.".class.php"){
				//print $file->getPathname();
				include $file->getPathname();
			}
		}
	}
}
//
function __autoload($n){
	$param = $_SERVER['DOCUMENT_ROOT'];
	req($param,$n);
}
//
$news = new NewsDB();
//
$errMsg="";
//
if($_SERVER['REQUEST_METHOD'] == "POST"){
	include 'save_news.inc.php';
}
if($_SERVER['REQUEST_METHOD'] == "GET"){
	include 'delete_news.inc.php';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Новостная лента</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Последние новости</h1>
<?php
include 'get_news.inc.php';
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

Заголовок новости:<br />
<input type="text" name="title" /><br />
Выберите категорию:<br />
<select name="category">
<option value="1">Политика</option>
<option value="2">Культура</option>
<option value="3">Спорт</option>
</select>
<br />
Текст:<br />
<textarea name="description" cols="50" rows="5"></textarea><br />
Источник:<br />
<input type="text" name="source" /><br />
<br />
<input type="submit" value="Добавить!" />

</form>

<?php
?>

</body>
</html>