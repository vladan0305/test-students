<?php

class SchoolBoard {

    private $type;

    public function getType(){

        return $this->type;
        
    }

    public function setType($type){

        $this->type= $type;
        return $this;
    }

}

?>