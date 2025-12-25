<?php
namespace application\models;

class Subcategory extends BaseExampleModel 
{
    public string $tableName = "subcategories";
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    public $name = null;
    public $categoryId = null;
    public $description = null; // Добавляем если есть в БД
    public $views_count = 0; // ДОБАВЛЯЕМ
    
    // Метод для получения названия категории
    public function getCategoryName()
    {
        if ($this->categoryId) {
            $sql = "SELECT name FROM categories WHERE id = :id";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":id", $this->categoryId, \PDO::PARAM_INT);
            $st->execute();
            $row = $st->fetch();
            return $row ? $row['name'] : null;
        }
        return null;
    }
    
    // Метод для получения статей этой подкатегории
    public function getArticles()
    {
        $sql = "SELECT * FROM notes WHERE subcategoryId = :id ORDER BY publicationDate DESC";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCategoryNameForId($categoryId)
    {
        if (!$categoryId) return null;
        
        $sql = "SELECT name FROM categories WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $categoryId, \PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        return $row ? $row['name'] : null;
    }

    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name, categoryId, description, views_count) VALUES (:name, :categoryId, :description, :views_count)"; 
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue(":views_count", $this->views_count, \PDO::PARAM_INT);
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }

    public function update()
    {
        $sql = "UPDATE $this->tableName SET name = :name, categoryId = :categoryId, description = :description, views_count = :views_count WHERE id = :id";  
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue(":views_count", $this->views_count, \PDO::PARAM_INT);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
    
    // Метод для увеличения счетчика просмотров
    public function incrementViews($subcategory_id = null)
    {
        $id = $subcategory_id ?? $this->id;
        if (!$id) return false;
        
        $sql = "UPDATE $this->tableName SET views_count = views_count + 1 WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $id, \PDO::PARAM_INT);
        return $st->execute();
    }
}