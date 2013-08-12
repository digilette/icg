<?php
namespace Intellimage\Icg\Model;

use \Zend\Code\Generator;
use \Zend\Code\Reflection;

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
            return Generator\ClassGenerator::fromReflection(
                new Reflection\ClassReflection($classname)
            );
        });
        
        $this->setFileGeneratorFactory(function($arguments){
            return new Generator\FileGenerator($arguments);
        });
        
        $this->setClassGeneratorFactory(function($arguments){
            return new Generator\ClassGenerator($arguments);
        });
        
        $this->setDocBlockGeneratorFactory(function($arguments){
            return new Generator\DocblockGenerator($arguments);
        });
        
        $this->setMethodGeneratorFactory(function($arguments){
            return new Generator\MethodGenerator($arguments);
        });
        
        $this->setParameterGeneratorFactory(function($arguments){
            return new Generator\ParameterGenerator($arguments);
        });
        
        $this->setPropertyGeneratorFactory(function($arguments){
            return new Generator\PropertyGenerator($arguments);
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
    
    public function getFileGenerator($arguments = null)
    {
        return call_user_func_array($this->_fileGeneratorFactory, array($arguments));
    }
    
    public function setClassGeneratorFactory($classGeneratorFactory)
    {
        $this->_classGeneratorFactory = $classGeneratorFactory;
        return $this;
    }
    
    public function getClassGenerator($arguments = null)
    {
        return call_user_func_array($this->_classGeneratorFactory, array($arguments));
    }
    
    public function setDocBlockGeneratorFactory($docBlockGeneratorFactory)
    {
        $this->_docBlockGeneratorFactory = $docBlockGeneratorFactory;
        return $this;
    }
    
    public function getDocBlockGenerator($arguments = null)
    {
        return call_user_func_array($this->_docBlockGeneratorFactory, array($arguments));
    }
    
    public function setMethodGeneratorFactory($methodGeneratorFactory)
    {
        $this->_methodGeneratorFactory = $methodGeneratorFactory;
        return $this;
    }
    
    public function getMethodGenerator($arguments = null)
    {
        return call_user_func_array($this->_methodGeneratorFactory, array($arguments));
    }
    
    public function setParameterGeneratorFactory($parameterGeneratorFactory)
    {
        $this->_parameterGeneratorFactory = $parameterGeneratorFactory;
        return $this;
    }
    
    public function getParameterGenerator($arguments = null)
    {
        return call_user_func_array($this->_parameterGeneratorFactory, array($arguments));
    }

    public function setPropertyGeneratorFactory($propertyGeneratorFactory)
    {
        $this->_propertyGeneratorFactory = $propertyGeneratorFactory;
        return $this;
    }
    
    public function getPropertyGenerator($arguments = null)
    {
        return call_user_func_array($this->_propertyGeneratorFactory, array($arguments));
    }
    
}