<?php
    class Task{
        private $description;
        private $id;

        function __construct($description, $id = null){
            $this->description = $description;
            $this->id = $id;
        }

        function setDescription($new_description){
            $this->description = (string) $new_description;
        }

        function getDescription(){
            return $this->description;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll(){
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();
            foreach($returned_tasks as $task){
                $description = $task['description'];
                $id = $task['id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }

        static function find($search_id){
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task){
                $task_id = $task->getId();
                if($task_id == $search_id){
                    $found_task = $task;
                }
            }
            return $found_task;
        }

        function update($new_description)
        {
            $GLOBALS['DB']->exec("UPDATE tasks SET description = '{$new_description}' WHERE id = {$this->getId()};");
            $this->setDescription($new_description);
        }

        static function deleteALL(){
            $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }

        function addTask($task)
        {
            $GLOBALS['DB']->exec("INSERT INTO categories_tasks (category_id, task_id) VALUES ({$this->getId()}, {$task->getId()});");
        }

        function getTasks()
        {
            $query = $GLOBALS['DB']->query("SELECT task_id FROM categories_tasks WHERE category_id = {$this->getId()};");
            $task_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $tasks = array();
            foreach($task_ids as $id) {
                $task_id = $id['task_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE id = {$task_id};");
                $returned_task = $result->fetchAll(PDO::FETCH_ASSOC);

                $description = $returned_task[0]['description'];
                $id = $returned_task[0]['id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
    }
?>
