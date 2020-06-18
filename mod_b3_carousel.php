<?php
/**
 * B3 Carousel Module
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2020 Hugo Fittipaldi. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://github.com/hfittipaldi/mod_b3_carousel
 */

// no direct access
defined('_JEXEC') or die;

// Register helper
JLoader::register('modB3CarouselHelper', __DIR__ . '/helper.php');

JHtml::_('script', 'mod_b3_carousel/jquery.mobile.touch.min.js', ['relative' => true]);
JHtml::_('script', 'mod_b3_carousel/b3_carousel.js', ['relative' => true]);

$doc = JFactory::getDocument();
$now = JFactory::getDate();

/* Module id */
$module_id = $module->id;

/* Params */
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$indicators = (int) $params->get('indicators', 1);
$controls   = (int) $params->get('controls', 1);

$interval   = (int) $params->get('interval', 5000);
$interval   = $interval !== 5000 ? ' data-interval="' . $interval . '"' : '';
$interval   = $params->def('autoslide', 1) ? $interval : ' data-interval="false"';
$transition = (int) $params->get('transition') !== 0 ? ' carousel-fade' : '';
$pause      = !$params->def('pause', 1) ? ' data-pause="false"' : '';
$wrap       = !$params->def('wrap', 1) ? ' data-wrap="false"' : '';
$keyboard   = !$params->def('keyboard', 1) ? ' data-keyboard="false"' : '';

$images     = $params->get('slides');

$item     = 'carousel-';
$ctrlNext = 'carousel-control-next';
$ctrlPrev = 'carousel-control-prev';
$spanNext = 'carousel-control-next-icon';
$spanPrev = 'carousel-control-prev-icon';
if ($params->get('version') == '3.x') {
    $item     = '';
    $ctrlNext = 'right carousel-control';
    $ctrlPrev = 'left carousel-control';
    $spanNext = 'glyphicon glyphicon-chevron-right';
    $spanPrev = 'glyphicon glyphicon-chevron-left';

    JHtml::_('stylesheet', 'mod_b3_carousel/b3_carousel.css', ['relative' => true]);
}

require JModuleHelper::getLayoutPath('mod_b3_carousel', $params->get('layout', 'default'));
