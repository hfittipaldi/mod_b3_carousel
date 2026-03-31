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

namespace Joomla\Module\B3Carousel\Site\Helper;

// no direct access
\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Database\DatabaseInterface;

/**
 * Helper for mod_b3_carousel
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 * @since       1.0
 */
class B3CarouselHelper
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
        $article = Table::getInstance('content');
        $article->load($image->article_id);
        $catid = $article->get('catid');

        $route = $image->link;
        if ($image->article_id !== '')
        {
            $route = RouteHelper::getArticleRoute($image->article_id, $catid);
        }

        return $route;
    }
}
