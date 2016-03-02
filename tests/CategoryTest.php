<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase{
        protected function tearDown(){
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName(){
            $name = "Kitchen chores";
            $test_category = new Category($name);

            $result = $test_category->getName();

            $this->assertEquals($name, $result);
        }
        function testSetName() {
            $name = "Kitchen chores";
            $test_category = new Category($name);

            $test_category->setName("Home chores");
            $result = $test_category->getName();

            $this->assertEquals("Home chores", $result);
        }

        function test_getId(){
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);

            $result = $test_category->getId();

            $this->assertEquals($id, $result);
        }

        function test_save(){
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $result = Category::getAll();

            $this->assertEquals($test_category, $result[0]);
        }

        function test_getAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_category = new Category($name, $id);
            $test_category2 = new Category($name2, $id2);
            $test_category->save();
            $test_category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function test_deleteAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_category = new Category($name, $id);
            $test_category2 = new Category($name2, $id2);
            $test_category->save();
            $test_category2->save();

            Category::deleteAll();

            $result = Category::getAll();
            $this->assertEquals([], $result);
        }
        function test_find() {
            $name = "Wash the dog";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_category = new Category($name, $id);
            $test_category2 = new Category($name2, $id2);
            $test_category->save();
            $test_category2->save();

            $result = Category::find($test_category->getId());

            $this->assertEquals($test_category, $result);
        }

        function testUpdate(){
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $new_description = "Clean the dog";

            $test_task->update($new_description);

            $this->assertEquals($new_description, $test_task->getDescription());
        }


        function testDeleteCategory(){
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $test_category->delete();

            $this->assertEquals([$test_category2], Category::getAll());
        }

        function testAddTask(){
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File Reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            $test_category->addTask($test_task);

            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks(){
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "wash the dog";
            $id2= 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            $description2 = "Take out the trash";
            $id3 = 3;
            $test_task2 = new Task($description2, $id3);
            $test_task2->save();

            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }

    }
?>
