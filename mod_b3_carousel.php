<?php
/**
 * B3 Carousel Module
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2016 Hugo Fittipaldi. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://github.com/hfittipaldi/mod_b3_carousel
 */

// no direct access
defined( '_JEXEC' ) or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();

/* Module id */
$module_id = $module->id;

/* Params */
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$autoslide       = (int) $params->get('autoslide', 1);
$interval        = (int) $params->get('interval', 5000);
$transition      = (int) $params->get('transition', 0);

if ($transition !== 0)
{
    $transition = ' carousel-fade';
    $doc->addStyleSheet(JURI::base() . '/media/mod_b3_carousel/css/b3_carousel.css');
}
else
{
    $transition = '';
}

$interval   = $interval !== 5000 ? ' data-interval="' . $interval . '"' : '';
$interval   = $autoslide !== 0 ? $interval : ' data-interval="false"';

$indicators = (int) $params->get('indicators', 1);
$controls   = (int) $params->get('controls', 1);

$pause      = (int) $params->get('pause') !== 1 ? ' data-pause="false"' : '';
$wrap       = (int) $params->get('wrap') !== 1 ? ' data-wrap="false"' : '';
$keyboard   = (int) $params->get('keyboard') !== 1 ? ' data-keyboard="false"' : '';

$images     = modB3CarouselHelper::groupByKey($params->get('images'));

require JModuleHelper::getLayoutPath('mod_b3_carousel', $params->get('layout', 'default'));
