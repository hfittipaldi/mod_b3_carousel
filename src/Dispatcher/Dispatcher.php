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

namespace Joomla\Module\B3Carousel\Site\Dispatcher;

// no direct access
\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    protected function getLayoutData(): array
    {
        $data = parent::getLayoutData();

        $data['document'] = $data['app']->getDocument();
        $data['wa'] = $data['document']->getWebAssetManager();
        $data['wa']->getRegistry()->addExtensionRegistryFile('mod_b3_carousel');

        return $data;
    }
}
