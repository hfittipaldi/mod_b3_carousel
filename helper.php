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
     * @param  object $slides Collection of slides
     *
     * @return array Return an array of objects, discarted the empty ones
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

    /**
     * [[Description]]
     *
     * @param  object $image [[Description]]
     *
     * @return string [[Description]]
     */
    public static function getUrl($image)
    {
        $article = JTable::getInstance('content');
        $article->load($image->article_id);
        $catid = $article->get('catid');

        $route = $image->link;
        if ($image->article_id !== '')
        {
            $route = ContentHelperRoute::getArticleRoute($image->article_id, $catid);
        }

        return $route;
    }
}
