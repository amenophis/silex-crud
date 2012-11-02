<?php
namespace Amenophis\Admin\ControllerProvider;

class Admin implements \Silex\ControllerProviderInterface
{
    protected $options;
    
    public function __construct($options = array()) {
        $this->options = $options;
        if(!$this->options['entity']) throw new Exception("You must provide 'entity' option");
    }
    
    public function connect(\Silex\Application $app) {
        $controllers = $app['controllers_factory'];
        
        $that = $this;
        
        $controllers->get('/list', function() use ($that, $app){
            $repository = $app['db.orm.em']->getRepository($this->options['entity']);
            if(!$repository) throw new Exception(printf("Repository for Entity '%s' not found", $that->options['entity']));
            
            return $app['twig']->render('amenophis_admin_list.html.twig', array(
                'items' => $repository->findAll(),
                'options' => $that->options
            ));
        });
        
        $controllers->match('/add', function() use ($that, $app){
            return "";
        });
        
        $controllers->match('/edit', function() use ($that, $app){
            return "";
        });
        
        $controllers->match('/delete', function() use ($that, $app){
            return "";
        });
        
        return $controllers;
    }
}