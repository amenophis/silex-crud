<?php
namespace Amenophis\Crud;

class ServiceProvider implements \Silex\ControllerProviderInterface
{
    public $options;
    public $repository;
    
    public function __construct($options = array())
    {
        $this->options = $options;
    }
    
    public function init(\Silex\Application $app) {
        if(!$this->repository = $app['db.orm.em']->getRepository($this->options['entity'])) throw new \Exception(printf("Repository for Entity '%s' not found", $this->options['entity']));
    }
    
    public function connect(\Silex\Application $app) {
        $this->init($app);
        
        $controllers = $app['controllers_factory'];
        
        $that = $this;
        
        $controllers->get('/', function() use ($that, $app){
            return $app['twig']->render('amenophis_admin_list.html.twig', array(
                'items' => $that->repository->findAll(),
                'options' => $that->options
            ));
        })
        ->bind($this->options['route']);
        
        $controllers->match('/add', function() use ($that, $app){
            return "";
        })
        ->bind($this->options['route'].'_add');
        
        $controllers->match('/{id}/edit', function($id) use ($that, $app){
            return "";
        })
        ->bind($this->options['route'].'_edit');
        
        $controllers->match('/{id}/delete', function() use ($that, $app){
            return "";
        })
        ->bind($this->options['route'].'_delete');
        
        return $controllers;
    }
}