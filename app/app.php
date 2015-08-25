<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();
    $app["debug"] = true;

    $server = "mysql:host=localhost;dbname=university_registrar";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    date_default_timezone_set("UTC");

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => __DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // root route: main page.
    $app->get("/", function() use ($app) {
        return $app["twig"]->render("index.html.twig");
    });

    // route for viewing all students.
    $app->get("/students", function() use ($app) {
        return $app["twig"]->render("students.html.twig"
        array("students" => Student::getAll());
    });



?>
