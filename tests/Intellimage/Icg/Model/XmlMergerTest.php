<?php
namespace Test\Intellimage\Icg\Model;

use \Intellimage\Icg\Model;
use \Intellimage\Icg\Helper;

class XmlMergerTest extends \PHPUnit_Framework_TestCase
{
    private $_xmlMerger = null;
    
    public function mockXmlMerger($methods)
    {
        return $this->getMock("\Intellimage\Icg\Model\XmlMerger", $methods);
    }
    
    public function testWillSetTargetWhenNameProvided()
    {
        //$xmlMerger = new Model\XmlMerger();
        
        
        
        /*$mockXmlMerger->expects($this->once())
            ->method("_save")
            ->will($this->returnValue(1));*/
        
        
        //$mockXmlMerger->save();
        
    }
    
    public function testWillSaveFileToProvidedName()
    {
        
        $filename = 'somemock_filename';
        $mockXmlMerger = $this->mockXmlMerger(array('_save', '_getCurrentXml'));
        $mockXmlMerger->expects($this->once())
            ->method("_save")
            ->with($this->equalTo($filename))
            ->will($this->returnValue(1));
        
        $mockXmlMerger->expects($this->once())
            ->method("_getCurrentXml")
            ->will($this->returnValue(null));
        
        $mockXmlMerger->save($filename);

        $mockXmlMerger = $this->mockXmlMerger(array('_save', '_getCurrentXml'));
        $mockXmlMerger->setTarget($filename);
        $mockXmlMerger->expects($this->once())
            ->method("_save")
            ->with($this->equalTo($filename))
            ->will($this->returnValue(1));
        
        $mockXmlMerger->expects($this->once())
            ->method("_getCurrentXml")
            ->will($this->returnValue(null));
        $mockXmlMerger->save();
    }
    
    /**
     * @expectedException Exception
     */
    public function testWillThrowExceptionIfNoFileProvided()
    {
        $mockXmlMerger = $this->mockXmlMerger(array('_getCurrentXml'));
        $mockXmlMerger->expects($this->once())
            ->method("_getCurrentXml")
            ->will($this->returnValue(""));
        
        $mockXmlMerger->save();
    }
    
    
    
    public function testIdentationShouldBePreserved()
    {
        
    }
    
    public function testMergedNodesShouldExist()
    {
        
    }
}