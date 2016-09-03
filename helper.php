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
     * Group an object by key
     *
     * @param   array  $json An object containing the item data
     *
     * @access public
     */
    public static function groupByKey($json)
    {
        $imagesJSON = self::_getJSON($json);
        if ($imagesJSON !== null)
        {
            $result = array();
            foreach ($imagesJSON as $i => $sub)
            {
                foreach ($sub as $k => $v)
                {
                    $result[$k][$i] = $v;
                }
            }
            $return = self::_columnsList($result);

            if ($return !== null)
                return $return;
        }

        return null;
    }

    /**
     * Retrieves the data in JSON format
     *
     * @param   array  $data An object containing the item data
     *
     * @access private
     */
    private static function _getJSON($data)
    {
        $result = json_decode($data, true);

        if (version_compare(phpversion(), '5.6', '<'))
        {
            $result = call_user_func_array('json_decode', func_get_args());
        }

        if (json_last_error() === JSON_ERROR_NONE)
            return $result;

        return null;
    }

    /**
     * Retrieves the list of columns
     *
     * @param   array  $data An object containing the item data
     *
     * @access private
     */
    private static function _columnsList($data)
    {
        foreach ($data as $key => $row)
        {
            $main_image[$key]        = $row['main_image'];
            $alternative_image[$key] = $row['alternative_image'];
            $title[$key]             = $row['title'];
            $link[$key]              = $row['link'];
            $target[$key]            = $row['target'];
            $description[$key]       = $row['description'];
            $ordering[$key]          = $row['ordering'];
        }

        // Ordena os dados com ordering ascendente, main_image ascendente
        // adiciona $data como o último parãmetro, para ordenar pela chave comum
        array_multisort($ordering, SORT_ASC, $main_image, SORT_ASC, $data);

        return $data;
    }
}
