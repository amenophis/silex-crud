<?php

namespace Amenophis\Crud;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

class ProviderFactory
{
    /**
     * Create a new ServiceProvider instance
     * @param String $configFilename Yml configuration file
     * @return \Amenophis\Crud\ServiceProvider Newly created instance
     */
    public static function create($configFilename)
    {
        $config = Yaml::parse($configFilename);
        
        $processor = new Processor();
        $configuration = new Configuration();
        $options = $processor->processConfiguration($configuration, array($config));
        
        return new ServiceProvider($options);
    }
}