<?php

namespace application\models;


/**
 * Базовая клиентская модель
 *
 */
class BaseExampleModel extends \ItForFree\SimpleMVC\MVC\Model
{
    
    public function likesUpper($id,$tableName)
    {
        $modelData = $this->getById($id, $tableName);
        $modelData->likes++;
        $modelData->update();
    }
    
    public function getModelLikes($id, $tableName) //метод не узнаёт какая именно модель
    {
        $modelData = $this->getById($id, $tableName);
        return $modelData->likes;
    }

    public function getAll()
    {
        // Явно включаем views_count
        $sql = "SELECT *, views_count FROM $this->tableName ORDER BY $this->orderBy";
        $st = $this->pdo->prepare($sql);
        $st->execute();
        return $st->fetchAll(\PDO::FETCH_OBJ);
    }
}
