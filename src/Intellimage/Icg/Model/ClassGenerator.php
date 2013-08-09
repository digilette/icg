<?php
namespace Intellimage\Icg\Model;

class ClassGenerator
{
    private $_classReflectionGeneratorFactory = null;
    
    private $_fileGeneratorFactory = null;
    
    private $_classGeneratorFactory = null;
    
    private $_docBlockGeneratorFactory = null;
    
    private $_methodGeneratorFactory = null;
    
    private $_parameterGeneratorFactory = null;
    
    private $_propertyGeneratorFactory = null;
    
    public function __construct()
    {
        $this->setClassReflectionGeneratorFactory(function($classname){
            return Zend_CodeGenerator_Php_Class::fromReflection(new Zend_Reflection_Class($classname));
        });
        
        $this->setFileGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_File($arguments);
        });
        
        $this->setClassGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_Class($arguments);
        });
        
        $this->setDocBlockGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_Docblock($arguments);
        });
        
        $this->setMethodGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_Method($arguments);
        });
        
        $this->setParameterGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_Parameter($arguments);
        });
        
        $this->setPropertyGeneratorFactory(function($arguments){
            return new Zend_CodeGenerator_Php_Property($arguments);
        });
    }
    
    public function setClassReflectionGeneratorFactory($classReflectionGeneratorFactory)
    {
        $this->_classReflectionGeneratorFactory = $classReflectionGeneratorFactory;
    }
    
    public function getClassGeneratorFromReflection($classname)
    {
        return call_user_func_array($this->_classReflectionGeneratorFactory, array($classname));
    }
    
    public function setFileGeneratorFactory($fileGeneratorFactory)
    {
        $this->_fileGeneratorFactory = $fileGeneratorFactory;
        return $this;
    }
    
    public function getFileGenerator($arguments)
    {
        return call_user_func_array($this->_fileGeneratorFactory, array($arguments));
    }
    
    public function setClassGeneratorFactory($classGeneratorFactory)
    {
        $this->_classGeneratorFactory = $classGeneratorFactory;
        return $this;
    }
    
    public function getClassGenerator($arguments)
    {
        return call_user_func_array($this->_classGeneratorFactory, array($arguments));
    }
    
    public function setDocBlockGeneratorFactory($docBlockGeneratorFactory)
    {
        $this->_docBlockGeneratorFactory = $docBlockGeneratorFactory;
        return $this;
    }
    
    public function getDocBlockGenerator($arguments)
    {
        return call_user_func_array($this->_docBlockGeneratorFactory, array($arguments));
    }
    
    public function setMethodGeneratorFactory($methodGeneratorFactory)
    {
        $this->_methodGeneratorFactory = $methodGeneratorFactory;
        return $this;
    }
    
    public function getMethodGenerator($arguments)
    {
        return call_user_func_array($this->_methodGeneratorFactory, array($arguments));
    }
    
    public function setParameterGeneratorFactory($parameterGeneratorFactory)
    {
        $this->_parameterGeneratorFactory = $parameterGeneratorFactory;
        return $this;
    }
    
    public function getParameterGenerator($arguments)
    {
        return call_user_func_array($this->_parameterGeneratorFactory, array($arguments));
    }

    public function setPropertyGeneratorFactory($propertyGeneratorFactory)
    {
        $this->_propertyGeneratorFactory = $propertyGeneratorFactory;
        return $this;
    }
    
    public function getPropertyGenerator($arguments)
    {
        return call_user_func_array($this->_propertyGeneratorFactory, array($arguments));
    }
    
}