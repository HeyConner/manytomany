<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase{

        protected function tearDown(){
            Task::deleteAll();
            Category::deleteAll();
        }

        function test_save()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $result = Task::getAll();

            $this->assertEquals($test_task, $result[0]);
        }

        function test_getId()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $result = $test_task->getId();

            $this->assertEquals(true, is_numeric($result));
        }


        function test_getAll()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id2);
            $test_task2->save();

            $result = Task::getAll();

            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_deleteAll()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            Task::deleteAll();

            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function test_find(){

            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $id = 1;
            $id2 = 2;
            $test_task = new Task($description, $id);
            $test_task2 = new Task($description2, $id);
            $test_task->save();
            $test_task2->save();


            $result = Task::find($test_task->getId());

            $this->assertEquals($test_task, $result);
        }
    }
?>
