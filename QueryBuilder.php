<?php

class QueryBuilder{
	
	private $pdo;
	
	public function __construct($pdo){
		$this->pdo = $pdo;
	}
	
	public function getAll($table){
		$sql = "SELECT * FROM {$table}";
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		return $statement->FetchAll(PDO::FETCH_ASSOC);
	}

	public function getOne($table, $id){
		$sql = "SELECT * FROM {$table} WHERE id=:id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(['id' => $id]);
		return $statement->Fetch(PDO::FETCH_ASSOC);
	}

	public function create($table, $array){
		//Получить ключи из масссива
		$array_keys = array_keys($array);
		//Преобразовать полученный массив в строку
		$keys_string = implode(',', $array_keys);
		//Получить метки
		$tags = ':' . implode(', :', $array_keys);
		$sql = "INSERT INTO {$table} ({$keys_string}) VALUE ({$tags})";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($array);
	}

	public function update($table, $array, $id){
		//Получить ключи из масссива
		$array_keys = array_keys($array);
		$key_val = '';
		//Получить значения
		foreach($array_keys as $key){
		//Получить пару -> ключ=:метка
		$key_tag .= $key . '=:' . $key . ',';
		}
		//Убираем запятую вконце строки
		$keys = rtrim($key_tag, ',');
		
		//Добавляем в массив id
		$array['id'] = $id;
		
		$sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($array);
	}
	
	public function delete($table, $id){
		$sql = "DELETE FROM {$table} WHERE id=:id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute(['id' => $id]);
	}
}

?>