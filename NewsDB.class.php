<?php
require 'INewsDB.class.php';
class NewsDB implements INewsDB{
	private $_db;
	const DB_NAME = "news.db";
	public function __construct(){
		if(is_file(self::DB_NAME)){
			$this->_db = new SQLite3(self::DB_NAME);
		}else{
			$this->_db = new SQLite3(self::DB_NAME);
			$sql = "CREATE TABLE msgs(
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				title TEXT,
				category INTEGER,
				description TEXT,
				source TEXT,
				datetime INTEGER);";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			$sql = "CREATE TABLE category(
				id INTEGER,
				name TEXT);";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			$sql = "INSERT INTO category(id, name)
				SELECT 1 as id, 'Политика' as name
				UNION SELECT 2 as id, 'Культура' as name
				UNION SELECT 3 as id, 'Спорт' as name;";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
		}
	}
	public function saveNews($title, $category, $description, $source){
		try{
			$dt = time();
			$sql = "INSERT INTO msgs(title, category, description, source, datetime)
				VALUES('$title', $category, '$description', '$source', $dt);";
			$result = $this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			if(!is_object($result)){
				throw new Exception($this->_db->lastErrorMsg());
			}else{
				return true;
			}
		}catch(Exception $e){
			return false;
		}

	}
	protected function db2Arr($data){
		$arr = array();
		while($row = $data->fetchArray(SQLITE3_ASSOC)){
			$arr[] = $row;
		}
		return $arr;
	}
	public function getNews(){
		$sql = "SELECT msgs.id as id, title, 
		category.name as category, 
		description, source, datetime
				FROM  msgs, category
				WHERE category.id = msgs.category
				ORDER BY msgs.id DESC;";
		$result = $this->_db->query($sql);
		return $this->db2Arr($result);
	}
	public function deleteNews($id){
		$sql = "DELETE FROM msgs
				WHERE msgs.id = $id;";
		$this->_db->exec($sql);			
	}
	public function clearStr($data){
		$data = trim(strip_tags($data));
		return $this->_db->escapeString($data);
	}
	public function clearInt($data){
		return abs((int)$data);
	}
	public function __destruct(){
		unset($this->_db);
	}
}
?>