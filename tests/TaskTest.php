<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase{

        protected function tearDown(){
            Task::deleteAll();
        }

        function test_save(){
            $description = "Wash the dog";
            $test_task = new Task($description);

            $test_task->save();

            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getId() {
            //Arrange
            $description = "Wash the dog.";
            $id = 1;
            $test_task = new Task($description, $id);

            //Act
            $result = $test_task->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_find(){
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_task = new Task($description);
            $test_task2 = new Task($description2);
            $test_task->save();
            $test_task2->save();

            $id = $test_task->getId();
            $result = Task::find($id);

            $this->assertEquals($test_task, $result);
        }
    }
?>
