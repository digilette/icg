<?php
namespace Intellimage\Icg\Model;

class XmlMerger
{
    /**
     * @var string source xml file
     */
    private $_source;
    
    /**
     * @var SimpleXMLElement
     */
    private $_current;
    
    /**
     * @var string target xml file
     */
    private $_target;
    
    /**
     * @var string default indentation
     */
    private $_indentation = "    ";
    
    /**
     * Validates an load the xml file
     *
     * @return SimpleXMLElement
     */
    protected function _loadXmlFile($file) 
    {
        if (!file_exists($file)) {
            throw new Exception("The file " . $file . " doesn't exists");
        }
        $extension = substr($file, -4);
        if ($extension !== ".xml") {
            throw new Exception("The file " . $file . " doesn't have the xml extension");
        }
        
        $xml = simplexml_load_file($file);
        if ($xml === false) {
            throw new Exception("The file " . $file . " is not a valid xml file");
        }
        
        return $xml;
    }
    
    public function setIndentationSize($size)
    {
        $this->_indentation = str_repeat(" ", $size);
    }
    
    /**
     * Sets the source file to merge with
     * @param string $file
     * @return XmlMerge
     */
    public function setSource($file)
    {
        if ($this->_current = $this->_loadXmlFile($file)) {
            $this->_source = $file;
            if (!isset($this->_target)) {
                $this->setTarget($file);
            }
        }
        return $this;
    }
    
    /**
     * Sets the target file to save
     *
     */
    public function setTarget($file) 
    {
        $this->_target = $file;
    }
    
    /**
     * Saves the merged xml to a target file
     * @param string $target can be null if setTarget was called before
     * @throws Exception if no filel to write
     */
    public function save($target = null) 
    {
        if (isset($target)) {
            $this->setTarget($target);
        }
        
        $this->_save($this->_target, $this->asXml());
    }
    
    /**
     * 
     * @param string $filename if specified it saves to a file and retuns a boolean
     * @param string $content
     * @return boolean
     */
    protected function _save($filename, $content)
    {
        return file_put_contents($filename, $content);
    }
    
    /**
     * Merges configuration by loading a new xml file
     * @return boolean
     */
    public function mergeByFile($file)
    {
        if ($xml = $this->_loadXmlFile($file)) {
            return $this->mergeByXml($xml);
        }
        
        return false;
    }
    
    protected function _getCurrentXml()
    {
        return $this->_current->asXml();
    }
    
    /**
     * formats an xml
     * @return string
     */
    public function asXml()
    {
        $xmlString = $this->_getCurrentXml();
        $xmlString = $this->_makeReplaces($xmlString);
        return $xmlString;
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->_current->asXML());
        $xml = $dom->saveXML();
        if (isset($filename)) {
            return file_put_contents($filename, $xml);
        }
        return $xml;
    }
    
    /**
     * Merges an xml into the current loaded one
     * @param SimpleXMLElement $xml
     * @return boolean
     */
    public function mergeByXml($xml)
    {
        return $this->_mergeXml($this->_current, $xml);
    }
    
    private $_replaces = array();
    
    private function _mergeXml($destination, $source, $indentation=0)
    {
        $children = $source->children();
        if ($children->count() > 0) {
            foreach ($children as $name => $child) {
                if (!isset($destination->$name)) {
                    $id = uniqid("pm");
                    $childXml = $child->asXml();
                    $this->_replaces[$id] = $this->_indentation . $childXml . "\n" . str_repeat($this->_indentation, $indentation);
                    $destination->addChild($id);
                } else {
                    $this->_mergeXml($destination->$name, $child, $indentation + 1);
                }
            }
        }
    }
    
    /**
     * Make the replacements in the xml strings
     * @param string $xmlString
     * @return string
     */
    private function _makeReplaces($xmlString)
    {
        foreach ($this->_replaces as $id => $replace) {
            $xmlString = str_replace('<' . $id . '/>', $replace, $xmlString);
        }
        return $xmlString;
    }
}
