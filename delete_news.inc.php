<?php
$id = $news->clearInt($_GET['id']);
$news->deleteNews($id);
?>