<?php
/**
 * B3 Carousel Module
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2017 Hugo Fittipaldi. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://github.com/hfittipaldi/mod_b3_carousel
 */

// no direct access
defined('_JEXEC') or die;

// Register helper
JLoader::register('modB3CarouselHelper', __DIR__ . '/helper.php');

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base() . '/media/mod_b3_carousel/css/b3_carousel.css');

/* Module id */
$module_id = $module->id;

/* Params */
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$fluidContainer  = (int) $params->get('fluidContainer', 1);
$fluid           = $fluidContainer === 1 ? '' : ' col-xs-12';

$autoslide       = (int) $params->get('autoslide', 1);
$interval        = (int) $params->get('interval', 5000);
$transition      = (int) $params->get('transition', 0);

$transition = $transition !== 0 ? ' carousel-fade' : '';

$interval   = $interval !== 5000 ? ' data-interval="' . $interval . '"' : '';
$interval   = $autoslide !== 0 ? $interval : ' data-interval="false"';

$indicators = (int) $params->get('indicators', 1);
$controls   = (int) $params->get('controls', 1);

$pause      = (int) $params->get('pause') !== 1 ? ' data-pause="false"' : '';
$wrap       = (int) $params->get('wrap') !== 1 ? ' data-wrap="false"' : '';
$keyboard   = (int) $params->get('keyboard') !== 1 ? ' data-keyboard="false"' : '';

$images     = modB3CarouselHelper::getCarousel($params->get('slides'));

require JModuleHelper::getLayoutPath('mod_b3_carousel', $params->get('layout', 'default'));
