<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

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

    // root route: main page- shows all previously registered students.
    $app->get("/", function() use ($app) {
        return $app["twig"]->render("index.html.twig", array("students" => Student::getAll(), "courses" => Course::getAll()));
    });

    // route for viewing all students.
    $app->get("/student", function() use ($app) {
        return $app["twig"]->render("students.html.twig", array("students" => Student::getAll()));
    });

    // route for viewing all courses.
    $app->get("/courses", function() use ($app) {
        return $app["twig"]->render("courses.html.twig", array("courses" => Course::getAll()));
    });

    //route to add new student
    $app->post("/student", function() use ($app) {
        $name = $_POST["name"];
        $date = $_POST["date"];
        // $id = $_POST["id"];
        $new = new Student($name, $date, $id=null);
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

    $app->post("/add_student", function() use ($app) {
        $course = Course::find($_POST['student_id']);
        $student = Student::find($_POST['course_id']);
        $course->addStudent($student);
        return $app["twig"]->render("course.html.twig", array("course" => $course, "courses" => Course::getAll(), "students" => $course->getStudents(), "all_students" => Student::getAll()));
    });

    $app->post("/add_courses", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($POST['student_id']);
        $student->addCourse($course);
        return $app["twig"]->render("student.html.twig", array("student" => $student, "students" => Student::getAll(), "course" => $student->getCourses(), "all_courses" => Course::getAll()));
    });

    $app->get("/courses/{id}/edit", function($id) use ($app) {
        $course = Course::find($id);
        return $app["twig"]->render("course_edit.html.twig", array("course" => $course));
    });

    $app->patch("/courses/{id}", function($id) use ($app) {
        $name = $_POST["name"];
        $course = Course::find($id);
        $course->update($name);
        return $app["twig"]->render("course_edit.html.twig", array("course" => $course));
    });

    $app->delete("/courses/{id}", function($id) use ($app) {
    $course = Course::find($id);
    $course->delete();
    return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/students/{id}/edit", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('student_edit.html.twig', array('student' => $student));
    });

    $app->patch("/students/{id}", function($id) use ($app) {
        $description = $_POST['description'];
        $student = Student::find($id);
        $student->update($description);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'all_courses' => Course::getAll(), 'courses' => $student->getcourses()));
    });

    $app->delete("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/delete_courses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll()));
    });


    $app->post("/delete_students", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render('index.html.twig', array('courses' => Course::getAll()));
    });

        return $app;

    ?>
