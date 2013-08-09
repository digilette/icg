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
    
    private function _mergeTwoFiles($xmlstring, $xmlstring2, $indentationSize = 4)
    {
        $mockXmlMerger = $this->mockXmlMerger(array('_loadXmlFile', 'setTarget'));
        $mockXmlMerger->setIndentationSize($indentationSize);
        $sourceFilename = "somefile";
        $xml = simplexml_load_string($xmlstring);
        $mockXmlMerger->expects($this->at(0))
            ->method("_loadXmlFile")
            ->will($this->returnValue($xml));

        $mockXmlMerger->expects($this->once())
            ->method("setTarget")
            ->with($this->equalTo($sourceFilename))
            ->will($this->returnValue(null));

        $mockXmlMerger->setSource($sourceFilename);

        $sourceMergeFilename = "other_file";
        
        $xml2 = simplexml_load_string($xmlstring2);
        $mockXmlMerger->expects($this->at(0))
            ->method("_loadXmlFile")
            ->will($this->returnValue($xml2));
            
        $mockXmlMerger->mergeByFile($sourceMergeFilename);
        return $mockXmlMerger;
    }
    
    
    public function testIdentationShouldBePreserved()
    {
        $first = "    <something><value>the value</value></something>";
        $second = "     <somethingelse><value>the value</value></somethingelse>";
        $middle = "    <middle>\n</middle>";
        $xmlstring = "<xml>\n$first\n$middle\n$second\n</xml>";
        $mergeValues = "<merged>it works</merged>";
        $xmlstring2 = "<xml><middle>\n$mergeValues\n</middle></xml>";
        $indentationSize = 8;
        $mockXmlMerger = $this->_mergeTwoFiles($xmlstring, $xmlstring2, $indentationSize);
        $resultXml = $mockXmlMerger->asXml();
        
        $regex = "#\\n" . preg_quote($first) . "#";
        $this->assertRegExp($regex, $resultXml, "should have original indentation");
        $regex = "#\\n" . preg_quote($second) . "#";
        $this->assertRegExp($regex, $resultXml, "should have original indentation");
        $regex = "#\\n" . str_repeat(" ", $indentationSize) . preg_quote($mergeValues) . "#";
        $this->assertRegExp($regex, $resultXml, "should have setted indentation");
    }
    
    public function testSourceAndMergedNodesShouldExist()
    {
        $value = "<value>the value</value>";
        $first = "<something>$value</something>";
        $middle = "<middle></middle>";
        $xmlstring = "<xml>$first$middle</xml>";
        $mergeValues = "<merged>it works</merged>";
        $xmlstring2 = "<xml><middle>\n$mergeValues\n</middle></xml>";

        $mockXmlMerger = $this->_mergeTwoFiles($xmlstring, $xmlstring2);
        $resultXmlStr = $mockXmlMerger->asXml();
        
        $resultXml = simplexml_load_string($resultXmlStr);
        $this->assertEquals($resultXml->something->value->asXml(), $value, "String source value exists and match");
        $this->assertEquals($resultXml->middle->merged->asXml(), $mergeValues, "String merged value exists and match");
    }
}