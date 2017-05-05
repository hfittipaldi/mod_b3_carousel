<?php
/**
 * B3 Carousel Module.
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
 * Script file of B3 Carousel module.
 *
 * This class will be called by Joomla!'s installer,
 * and is used for custom automation actions in its installation process.
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 * @since       2.0
 */
class mod_b3_carouselInstallerScript
{
    private static $release;
    private static $minimum_joomla_release;
    private static $minimum_php_version = '5.6';

    /**
     * Method to install the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    public static function install($parent)
    {
        echo '<p>The module has been installed</p>';
    }

    /**
     * Method to uninstall the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    public static function uninstall($parent)
    {
        echo '<p>The module has been uninstalled</p>';
    }

    /**
     * Method to update the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    public static function update($parent)
    {
        // TODO: get all modules params and update them
        // read the existing component value(s)
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'params')))
            ->from($db->quoteName('#__modules'))
            ->where($db->quoteName('module') . ' = ' . $db->quote('mod_b3_carousel'));
        $db->setQuery($query);

        $array = $db->loadAssocList();

        // Select the required fields from the table.
        $query = $db->getQuery(true);
        $query = "UPDATE #__modules SET params = CASE id ";
        foreach ($array as $value)
        {
            $params = json_decode($value['params']);
            $query .= 'WHEN ' . $value['id'] . ' THEN \'' . self::_arrayToObject($params) . '\' ';
            $ids[] = $value['id'];
        }
        $query .= 'END WHERE id IN (' . implode(',', $ids) . ')';

        $db->setQuery((string)$query)
            ->execute();

        // TODO: update manifest_cache on #__extensions
        self::setParams();

        echo '<p>The module has been updated to version' . $parent->get('manifest')->version . '</p>';
    }

    /**
     * Method to run before an install/update/uninstall method
     *
     * @param class $parent is the class calling this method
     * @param string $type is the type of change (install, update or discover_install)
     *
     * @return void
     */
    public static function preflight($type, $parent)
    {
        $jversion = new JVersion();

        // Installing component manifest file version
        self::$release = $parent->get("manifest")->version;

        // Manifest file minimum Joomla version
        self::$minimum_joomla_release = $parent->get("manifest")->attributes()->version;

        // Show the essential information at the install/update back-end
        echo '<p>Installing module manifest file version = ' . self::$release;
        echo '<br />Current manifest cache module version = ' . self::getParam('version');
        echo '<br />Installing component manifest file minimum Joomla version = ' . self::$minimum_joomla_release;
        echo '<br />Current Joomla version = ' . $jversion->getShortVersion();
        echo '<br />Minimum PHP required version = ' . self::$minimum_php_version;
        echo '<br />Current PHP version = ' . phpversion() . '</p>';

        // abort if the current Joomla release is older
        if (version_compare($jversion->getShortVersion(), self::$minimum_joomla_release, 'lt'))
        {
            Jerror::raiseWarning(null, 'Cannot install B3 Carousel Module in a Joomla release prior to ' . self::$minimum_joomla_release);
            return false;
        }

        // abort if the PHP version is not newer than the minimum PHP required version
        if (version_compare(phpversion(), self::$minimum_php_version, 'lt'))
        {
            Jerror::raiseWarning(null, 'Cannot install B3 Carousel Module in a PHP version prior to ' . self::$minimum_php_version);
            return false;
        }

        $message = $type == 'install' ? 'installed' : 'uninstalled';

        // abort if the module being installed is not newer than the currently installed version
        if ($type == 'update')
        {
            $oldRelease = self::getParam('version');
            $rel = $oldRelease . ' to ' . self::$release;
            if (version_compare(self::$release, $oldRelease, 'le'))
            {
                Jerror::raiseWarning(null, 'Incorrect version sequence. Cannot upgrade ' . $rel);
                return false;
            }

            $message = 'updated from ' . $rel;
        }

        echo '<p>' . JText::_('B3 Carousel Module was succefully ' . $message . '.') . '</p>';
    }

    /**
     * Method to run after an install/update/uninstall method
     *
     * @param class $parent is the class calling this method
     * @param string $type is the type of change (install, update or discover_install)
     *
     * @return void
     */
    public static function postflight($type, $parent)
    {
    }

    /**
     * Get a variable from the manifest file (actually, from the manifest cache).
     *
     * @param  string $name [[Description]]
     *
     * @return string [[Description]]
     */
    public static function getParam($name)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName('manifest_cache'))
            ->from($db->quoteName('#__extensions'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('mod_b3_carousel'));
        $db->setQuery($query);
        $manifest = json_decode($db->loadResult(), true);

        return $manifest[$name];
    }

    /*
     * Sets parameter values in the module's row of the extension table
     *
     * @return void
     */
    public static function setParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__extensions'))
            ->set($db->quoteName('params') . ' = ' . $db->quote('{"slides":"{"main_image":"","alternative_image":"","title":"","link":"","target":"0","caption":""}","fluidContainer":"1","autoslide":"1","transition":"0","interval":"5000","indicators":"1","controls":"1","pause":"1","wrap":"1","keyboard":"1","cache":"1","cache_time":"900","cachemode":"static"}'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('mod_b3_carousel'));

        $db->setQuery($query)
            ->execute();
    }

    private static function _arrayToObject($params)
    {
        $array = self::_groupByKey($params->images);

        foreach($array as $key => $value)
        {
            foreach ($value as $property => $argument)
            {
                if ($property != 'ordering')
                {
                    if ($property == 'description')
                    {
                        $property = 'caption';
                    }

/*
                    if (!in_array($property, array('main_image', 'alternative_image', 'link')))
                    {
                        $argument = str_replace('/', '\/', $argument);
                    }
*/

                    $result['slides']['slides' . $key][$property] = $argument;
                }
            }

            $result['slides']['slides' . $key]['article_id'] = '';
        }

        $result['fluidContainer']   = $params->fluidContainer;
        $result['autoslide']        = $params->autoslide;
        $result['transition']       = $params->transition;
        $result['interval']         = $params->interval;
        $result['indicators']       = $params->indicators;
        $result['controls']         = $params->controls;
        $result['pause']            = $params->pause;
        $result['wrap']             = $params->wrap;
        $result['keyboard']         = $params->keyboard;
        $result['layout']           = $params->layout;
        $result['moduleclass_sfx']  = $params->moduleclass_sfx;
        $result['cache']            = $params->cache;
        $result['cache_time']       = $params->cache_time;
        $result['cachemode']        = $params->cachemode;
        $result['module_tag']       = $params->module_tag;
        $result['bootstrap_size']   = $params->bootstrap_size;
        $result['header_tag']       = $params->header_tag;
        $result['header_class']     = $params->header_class;
        $result['style']            = $params->style;

        return json_encode($result);
    }

    /**
     * Group an object by key
     *
     * @param   array  $json An object containing the item data
     *
     * @access public
     */
    private static function _groupByKey($json)
    {
        $return = null;

        $imagesJSON = json_decode($json);
        if ($imagesJSON !== null)
        {
            foreach ($imagesJSON as $i => $sub)
            {
                foreach ($sub as $k => $v)
                {
                    $result[$k][$i] = $v;
                }
            }
            $return = self::_columnsList($result);
        }

        return $return;
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
            $ordering[$key]   = $row['ordering'];
            $main_image[$key] = $row['main_image'];
        }

        // Ordena os dados com ordering ascendente, main_image ascendente
        // adiciona $data como o último parãmetro, para ordenar pela chave comum
        array_multisort($ordering, SORT_ASC, $main_image, SORT_ASC, $data);

        return $data;
    }
}
