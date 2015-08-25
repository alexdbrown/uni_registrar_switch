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
        return $app["twig"]->render("students.html.twig", array("students" => Student::getAll());
    });

    // route for viewing all courses.
    $app->get("/courses", function() use ($app) {
        return $app["twig"]->render("courses.html.twig", array("courses" => Course::getAll()));
    });

    //route to add new student
    $app->post("/students", function() use ($app) {
        $name = $_POST["name"];
        $date = $_POST["date"];
        $id = $_POST["id"];
        $new = new Student($name, $date, $id);
        $student->save();
        return $app["twig"]->render("students.html.twig", array("students" => Student::getAll()));
    });

    //route bringing up a specific student's information
    $app->get("/student/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app["twig"]->render("student.html.twig", array("student" => $student, 'courses' => $student->getCourses(), "all_courses" => Course::getAll()));
    });

    //route to add new courses
    $app->post("/courses", function() use ($app) {
        $name = $_POST["name"];
        $number = $_POST["number"];
        $id = $_POST["id"];
        $new = new Course($name, $number, $id);
        $course->save();
        return $app["twig"]->render("courses.html.twig", array("courses" => Course::getAll()));
    });

    //route bringing up a specific course's information
    $app->get("/course/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app["twig"]->render("course.html.twig", array("course" => $course, "students" => $course->getStudents(), "all_students" => Student::getAll()));
    });






?>
