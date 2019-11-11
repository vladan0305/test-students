<?php

class Student {

    public $id;
    public $name;
    public $type;
    public $format;
    public $grades = [];

    public function __construct($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->type = $array["type"];
        $this->format = $array["format"];
        $this->grades = $array["grades"];
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getGrades()
    {
        return $this->grades;
    }

    public function setGrades($grades)
    {
        $this->grades = $grades;
        return $this;
    }

    public function getFormat() {
        return $this->format;
    }

    public function setFormat($format) {
        $this->format = $format;
        return $this;
    }

    public function avgGrade(){
        $grd = 0;
        if($this->type == 'CSM'){
            foreach($this->grades as $grade) {
                $grd += $grade;
            }
            return $grd / count($this->grades);
        }
        if($this->type == 'CSMB'){
            if(count($this->grades) > 1){
                unset($this->grades[min($this->grades)]);
            }
            foreach($this->grades as $grade){
                $grd += $grade;
            }
            return $grd / count($this->grades);
        }
        return "Error";
    }

    public function pass() {
        if($this->type == "CSM") {
            $pass = $this->avgGrade();
            if($pass >= 7) {
                return "Passed";
            } else {
                return "Failed";
            }
        }
    
        if($this->type == "CSMB") {
            if(max($this->grades) > 8) {
                return "Passed";
            } else {
                return "Failed";
            }
        }
        return "Error";
    }

}

?>