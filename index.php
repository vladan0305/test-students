<?php

require "model/db.php";
include "model/Student.php";
include "Formatter/Formatter.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];

    $std = getStudent($id);

    $student = new Student($std);

    $response = JsonFormatter::getInstance()->serializeStudentToArray($student);
    
}

echo Formatter::getFormatter($student->format)->formatResult($response);

?>