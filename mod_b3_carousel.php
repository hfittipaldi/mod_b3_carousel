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

JHtml::_('stylesheet', 'mod_b3_carousel/b3_carousel.css', ['relative' => true]);
JHtml::_('script', 'mod_b3_carousel/jquery.mobile.touch.min.js', ['relative' => true]);
JHtml::_('script', 'mod_b3_carousel/b3_carousel.js', ['relative' => true]);

/* Module id */
$module_id = $module->id;

/* Params */
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$full_width = (int) $params->get('full_width', 1);
$transition = (int) $params->get('transition') !== 0 ? ' carousel-fade' : '';

$interval   = (int) $params->get('interval', 5000);
$interval   = $interval !== 5000 ? ' data-interval="' . $interval . '"' : '';
$interval   = $params->def('autoslide', 1) ? $interval : ' data-interval="false"';

$indicators = (int) $params->get('indicators', 1);
$controls   = (int) $params->get('controls', 1);

$pause      = !$params->def('pause', 1) ? ' data-pause="false"' : '';
$wrap       = !$params->def('wrap', 1) ? ' data-wrap="false"' : '';
$keyboard   = !$params->def('keyboard', 1) ? ' data-keyboard="false"' : '';

$images     = $params->get('slides');

require JModuleHelper::getLayoutPath('mod_b3_carousel', $params->get('layout', 'default'));
