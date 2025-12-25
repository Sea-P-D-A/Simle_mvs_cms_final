<?php
namespace application\models;

class Category extends BaseExampleModel 
{
    public string $tableName = "categories";
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    public $name = null;
    public $description = null;
    public $views_count = 0; // ДОБАВЛЯЕМ
    
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name, description, views_count) VALUES (:name, :description, :views_count)"; 
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue(":views_count", $this->views_count, \PDO::PARAM_INT);
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update()
    {
        $sql = "UPDATE $this->tableName SET name = :name, description = :description, views_count = :views_count WHERE id = :id";  
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue(":views_count", $this->views_count, \PDO::PARAM_INT);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
    
    // Метод для увеличения счетчика просмотров
    public function incrementViews($category_id = null)
    {
        $id = $category_id ?? $this->id;
        if (!$id) return false;
        
        $sql = "UPDATE $this->tableName SET views_count = views_count + 1 WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $id, \PDO::PARAM_INT);
        return $st->execute();
    }
}