<?php
    class Category{
        private $name;
        private $id;

        function __construct($name, $id = null) {
            $this->name = $name;
            $this->id = $id;
        }

        function getName() {
            return $this->name;
        }

        function setName($new_name){
          $this->name = $new_name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO categories (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name){
            $GLOBALS['DB']->exec("UPDATE categories SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function addTask($task){
            $GLOBALS['DB']->exec("INSERT INTO categories_tasks (category_id, task_id) VALUES ({$this->getId()}, {$task->getId()});");
        }

        static function getAll() {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            $categories = array();
            foreach($returned_categories as $category) {
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM categories;");
        }

        static function find($search_id) {
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category) {
                $category_id = $category->getId();
                if ($category_id == $search_id) {
                  $found_category = $category;
                }
            }
          return $found_category;
        }

        function getTasks()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT tasks.* FROM categories JOIN categories_tasks ON (categories_tasks.category_id = categories.id) JOIN tasks ON (tasks.id = categories_tasks.task_id) WHERE categories.id = {$this->getId()};");

            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }
        function deleteCategoryTasks(){
            $GLOBALS['DB']->exec("DELETE FROM categories_tasks WHERE category_id = {$this->getId()};");
        }
    }

?>
