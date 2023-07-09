<?php

class TaskController {

    public function __construct(private TaskRepository $repository){}

    public function processRequest (string $method){

        if($method == "GET") {

            http_response_code(200);
            echo json_encode($this->repository->getTasks());

        }

        if ($method == "POST") {
            
            $data = json_decode(file_get_contents("php://input"));
            $id = $this->repository->createTask($data);

            http_response_code(201);
            echo json_encode(["message" => "Task added", "id" => $id]);
        }

        if($method == "PUT") {

            $data = json_decode(file_get_contents("php://input"));

            $id = $this->repository->editTask($data);

            http_response_code(201);
            echo json_encode(["message" => "Task edited", "id" => $id]);
        }

        if($method == "DELETE") {

            $id = htmlspecialchars($_GET["id"]);
            
            $rows = $this->repository->deleteTask($id);
            
            echo json_encode(["Message" => "task deleted", "rows" => $rows]);
        }
    }

}