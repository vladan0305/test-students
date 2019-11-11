<?php
function getStudent($id) {
    /*** mysql hostname ***/
    $hostname = "localhost";
    /*** mysql username ***/
    $username = "root";
    /*** mysql password ***/
    $password = "";
    /*** mysql database name ***/
    $database = "quantox";

    try {
        $connection = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Make query string
    $sqlQueryString = "SELECT * FROM students LEFT JOIN grades ON  students.id = grades.student_id WHERE students.id = " . $id ."";
    
    // Execute query (with params or without)
    $statement = $connection->prepare($sqlQueryString);
    
    // Execute return TRUE or FALSE
    $status = $statement->execute();
    if($status){
        $rows = $statement->fetchAll();
        
        $numberOfRows = count($rows);
        if($numberOfRows > 0){
            $student = [
                "id" => $id,
                "name" => $rows[0]["name"],
                "type" => $rows[0]["type"],
                "format" => $rows[0]["format"],
                "grades" => []
            ];
            foreach ($rows as $value) {
                $student['grades'][] = $value["grade"];
            }
            return $student;
        }
    }

    }catch( PDOException $exception ) {
        echo "Something went wrong: " . $exception->getMessage() . "<br>";
    }
}