<?php
/**
 * @version     1.0.1
 * @package     mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2016 Magic RM Comunicação. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

//No Direct Access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

/* Params */
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$module_id = $module->id;
$images = ModCarouselHelper::groupByKey($params->get('images'));

require JModuleHelper::getLayoutPath('mod_b3_carousel', $params->get('layout', 'default'));
