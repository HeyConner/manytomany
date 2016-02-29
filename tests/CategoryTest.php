<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase{
        protected function tearDown(){
            Category::deleteAll();
        }

        function test_getName(){
            $name = "Work Stuff";
            $test_category = new Category($name);

            $result = $test_category->getName();

            $this->assertEquals($name, $result);
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
            $test_category = new Category($name);
            $test_category->save();

            $result = Category::getAll();

            $this->assertEquals($test_category, $result[0]);
        }

        function test_getAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $test_category = new Category($name);
            $test_category2 = new Category($name2);
            $test_category->save();
            $test_category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function test_deleteAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $test_category = new Category($name);
            $test_category2 = new Category($name2);
            $test_category->save();
            $test_category2->save();

            Category::deleteAll();
            $result = Category::getAll();

            $this->assertEquals([], $result);
        }
        function test_find() {
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $test_category = new Category($name);
            $test_category2 = new Category($name2);
            $test_category->save();
            $test_category2->save();

            $result = Category::find($test_category->getId());

            $this->assertEquals($test_category, $result);
        }
    }
?>
