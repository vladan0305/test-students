<?php

abstract class Formatter
{
    public static function getFormatter($format)
    {
        if ($format === 'xml') {
            return XmlFormatter::getInstance();
        }
        return JsonFormatter::getInstance();
    }
    
    public abstract function formatResult($response);
    
    public function serializeStudentToArray($student)
    {
        $pass = $student->pass();
        $response = [
            'id' => $student->getId(),
            'name' => $student->getName(),
            'grades' => $student->getGrades(),
            'average' => $student->avgGrade(),
            'result' => $pass
        ];
        return $response;
    }
}

class JsonFormatter extends Formatter
{
    private static $instance;
    private function __construct()
    {
    }
    /**
     * @return JsonFormatter
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new JsonFormatter();
        }
        return self::$instance;
    }
    /**
     * @param array $response
     *
     * @return mixed
     */
    public function formatResult($response)
    {
        return json_encode($response);
    }
}

class XmlFormatter extends Formatter
{
    private $rootElement = 'student';
    private static $instance;
    private function __construct()
    {
    }
    
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new XmlFormatter();
        }
        return self::$instance;
    }
    /**
     * @param array $response
     *
     * @return mixed
     */
    public function formatResult($response)
    {
        header("Content-type: text/xml; charset=utf-8");
        $xmlData = new SimpleXMLElement(sprintf('<?xml version="1.0"?><%s></%s>', $this->rootElement, $this->rootElement));
        $this->arrayToXml($response, $xmlData);
        return $xmlData->asXML();
    }
    /**
     * @param array $data
     * @param SimpleXMLElement $xmlData
     */
    private function arrayToXml($data, &$xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }
            if (is_array($value)) {
                $subnode = $xmlData->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}

?>