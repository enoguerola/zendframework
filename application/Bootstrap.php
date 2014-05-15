<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

 protected function _initAutoload(){
        $moduleLoader = new Zend_Application_Module_Autoloader(array('namespace' => '', 'basePath' => APPLICATION_PATH));
      
        $fron=Zend_Controller_Front::getInstance();
      $fron->registerPlugin(new My_Controller_Plugin_Acl());
      $fron->registerPlugin(new My_Controller_Plugin_CheckSession);
   //   $fron->registerPlugin(new My_Controller_Plugin_Active());
            
        return $moduleLoader;
      
 
        
    }
/*
    protected function _initNavigation() {
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $container = new Zend_Navigation($config);
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->navigation($container);
    }*/
    protected function _initViewHelpers(){
	$this->bootstrap('layout');
	$layout = $this->getResource('layout');
	$view = $layout->getView();
	$view->doctype('XHTML1_STRICT');
	$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
	$view->headMeta()->appendHttpEquiv('Cache-Control', 'no-cache');
	$view->headTitle()->setSeparator(' - ');
	$view->headTitle('');
	Zend_Session::start();
   }
}

