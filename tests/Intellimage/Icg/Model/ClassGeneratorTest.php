<?php
namespace Test\Intellimage\Icg\Model;

use \Intellimage\Icg\Model;
use \Intellimage\Icg\Helper;

class ClassGeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $_ClassGenerator = null;
    
    public function mockClassGenerator($methods)
    {
        return $this->getMock("\Intellimage\Icg\Model\ClassGenerator", $methods);
    }
    
    public function testWillSaveFileToProvidedName()
    {   
        $classGenerator = new Model\ClassGenerator;
        //var_dump($classGenerator, $classGenerator->getFileGenerator(), $classGenerator->getClassGenerator());
    }
}