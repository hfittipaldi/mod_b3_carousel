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

/**
 * Helper for mod_b3_carousel
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 * @since       1.0
 */
class ModB3CarouselHelper
{
    /**
     * Get all slides from the carousel
     *
     * @param  [[Type]] $slides [[Description]]
     *
     * @return array [[Description]]
     */
    public static function getCarousel($slides)
    {
        $items = null;
        foreach ($slides as $slide)
        {
            if (!empty($slide->main_image))
            {
                $items[] = $slide;
            }
        }

        return $items;
    }
}
