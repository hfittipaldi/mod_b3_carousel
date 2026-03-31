<?php
/**
 * B3 Carousel Module
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 *
 * @copyright   Copyright (C) 2020 Hugo Fittipaldi. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @link        https://github.com/hfittipaldi/mod_b3_carousel
 */

// No direct access
\defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory as ModuleDispatcherFactoryServiceProvider;
use Joomla\CMS\Extension\Service\Provider\HelperFactory as HelperFactoryServiceProvider;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   3.0.0
     */
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactoryServiceProvider('\\Joomla\\Module\\B3Carousel'));
        $container->registerServiceProvider(new HelperFactoryServiceProvider('\\Joomla\\Module\\B3Carousel\\Site\\Helper'));
        $container->registerServiceProvider(new ModuleServiceProvider());
    }
};
