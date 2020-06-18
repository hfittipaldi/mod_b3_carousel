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
