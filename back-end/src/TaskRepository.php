<?php

class TaskRepository {

    private PDO $conn;

    public function __construct(Database $database){
        $this->conn = $database->getConnection();
    }

    public function getTasks ():array{

        $sql = 'SELECT * FROM tasks';

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask (object $data){

        $sql = 'INSERT INTO tasks (title,  status)
                VALUES (:title, :status)';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":title", $data->title, PDO::PARAM_STR);
        $stmt->bindValue(":status", $data->status, PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function deleteTask (string $id) :int{

        $sql = 'DELETE FROM tasks WHERE id = :id';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function editTask (object $data){

        $sql = 'UPDATE tasks SET status = :status
        WHERE id = :id';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":status", $data->status, PDO::PARAM_STR);
        $stmt->bindValue(":id", $data->id, PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }


}