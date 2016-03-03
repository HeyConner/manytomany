<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
     'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/categories", function() use ($app){
        $new_category = new Category($_POST['name']);
        $new_category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/categories/{id}", function($id) use ($app){
        $category = Category::find($id);
        return $app['twig']->render("category.html.twig", array('found_category' => $category, 'tasks' => $category->getTasks(), 'categories' => Category::getAll()));
    });

    $app->post('/delete_categories', function() use ($app){
        Category::deleteAll();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });


    return $app;
?>
