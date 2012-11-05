<?php
namespace Amenophis\CRUD\ControllerProvider;

class Provider implements \Silex\ControllerProviderInterface
{
    public $options;
    public $repository;
    
    public function __construct($config_file)
    {
        $config = \Symfony\Component\Yaml\Yaml::parse($config_file);
        
        $processor = new \Symfony\Component\Config\Definition\Processor();
        $configuration = new \Amenophis\Admin\Configuration\AdminConfiguration();
        $this->options = $processor->processConfiguration($configuration, array($config));
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
        ->bind($that->options['route']);
        
        $controllers->match('/add', function() use ($that, $app){
            return "";
        })
        ->bind($that->options['route'].'_add');
        
        $controllers->match('/{id}/edit', function($id) use ($that, $app){
            return "";
        })
        ->bind($that->options['route'].'_edit');
        
        $controllers->match('/{id}/delete', function() use ($that, $app){
            return "";
        })
        ->bind($that->options['route'].'_delete');
        
        return $controllers;
    }
}