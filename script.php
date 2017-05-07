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

// No direct access
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
    public $release;
    public $min_joomla_release;
    public $minimum_php_version = '5.6';

    /**
     * This method is called after a module is installed.
     *
     * @return void
     */
    public function install()
    {
        echo '<p>The module has been installed</p>';
    }

    /**
     * This method is called after a module is uninstalled.
     *
     * @return void
     */
    public function uninstall()
    {
        echo '<p>The module has been uninstalled</p>';
    }

    /**
     * This method is called after a module is updated.
     *
     * @param  \stdClass $parent - Parent object calling object.
     *
     * @return void
     */
    public function update($parent)
    {
        echo '<p>The module has been updated to version ' . $parent->get('manifest')->version . '</p>';
    }

    /**
     * Runs just before any installation action is preformed on the component.
     * Verifications and pre-requisites should run in this function.
     *
     * @param  string    $type   - Type of PreFlight action. Possible values are:
     *                           - * install
     *                           - * update
     *                           - * discover_install
     * @param  \stdClass $parent - Parent object calling object.
     *
     * @return void
     */
    public function preflight($type, $parent)
    {
        $app = JFactory::getApplication();

        $jversion = new JVersion();

        // Installing component manifest file version
        $this->release = $parent->get("manifest")->version;

        // Manifest file minimum Joomla version
        $this->minimum_joomla_release = $parent->get("manifest")->attributes()->version;

        // Show the essential information at the install/update back-end
        echo '<p>Installing module manifest file version = ' . $this->release;
        echo '<br />Current manifest cache module version = ' . self::getParam('version');
        echo '<br />Installing component manifest file minimum Joomla version = ' . $this->minimum_joomla_release;
        echo '<br />Current Joomla version = ' . $jversion->getShortVersion();
        echo '<br />Minimum PHP required version = ' . $this->minimum_php_version;
        echo '<br />Current PHP version = ' . phpversion() . '</p>';

        // Abort if the current Joomla release is older
        if (version_compare($jversion->getShortVersion(), $this->minimum_joomla_release, 'lt'))
        {
            $app->enqueueMessage('Cannot install B3 Carousel Module in a Joomla release prior to ' . $this->minimum_joomla_release, 'warning');
            return false;
        }

        // Abort if the PHP version is not newer than the minimum PHP required version
        if (version_compare(phpversion(), $this->minimum_php_version, 'lt'))
        {
            $app->enqueueMessage('Cannot install B3 Carousel Module in a PHP version prior to ' . $this->minimum_php_version, 'warning');
            return false;
        }

        // Abort if the module being installed is not newer than the currently installed version
        if ($type == 'update')
        {
            $oldRelease = self::getParam('version');
            $rel = $oldRelease . ' to ' . $this->release;
            if (version_compare($this->release, $oldRelease, 'le'))
            {
                $app->enqueueMessage('Incorrect version sequence. Cannot upgrade ' . $rel, 'warning');
                return false;
            }

            if (version_compare($oldRelease, '2.0', 'lt'))
            {
                self::migrateData();
            }
        }
    }

    /**
     * Runs right after any installation action is preformed on the component.
     *
     * @return void
     */
    public function postflight()
    {
    }

    /**
     * Get a variable from the manifest file (actually, from the manifest cache).
     *
     * @param  string $name [[Description]]
     *
     * @return string [[Description]]
     */
    public function getParam($name)
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
    public function updateManifestCache()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__extensions'))
            ->set($db->quoteName('params') . ' = ' . $db->quote('{"slides":"{"main_image":"","alternative_image":"","title":"","link":"","target":"0","caption":""}","full_width":"1","autoslide":"1","transition":"0","interval":"5000","indicators":"1","controls":"1","pause":"1","wrap":"1","keyboard":"1","cache":"1","cache_time":"900","cachemode":"static"}'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('mod_b3_carousel'));

        $db->setQuery($query)
            ->execute();
    }

    public function migrateData()
    {
        // Read the existing component value(s)
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'params')))
            ->from($db->quoteName('#__modules'))
            ->where($db->quoteName('module') . ' = ' . $db->quote('mod_b3_carousel'))
            ->where($db->quoteName('published') . ' = 1');
        $db->setQuery($query);

        $array = $db->loadAssocList();

        // Select the required fields from the table.
        $query = $db->getQuery(true);
        $query = "UPDATE #__modules SET params = CASE id ";
        foreach ($array as $value)
        {
            $params = json_decode($value['params']);
            $query .= 'WHEN ' . $value['id'] . ' THEN ' . $db->quote(self::_arrayToObject($params)) . ' ';
            $ids[] = $value['id'];
        }
        $query .= 'END WHERE id IN (' . implode(',', $ids) . ')';

        $db->setQuery($query)
            ->execute();

        self::updateManifestCache();
    }

    protected function _arrayToObject($params)
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

                    if ($property == 'target')
                    {
                        $argument = $argument == 0 ? 1 : 0;
                    }

                    $result['slides']['slides' . $key][$property] = $argument;
                }
            }

            $result['slides']['slides' . $key]['article_id'] = '';
        }

        $result['full_width']       = $params->fluidContainer;
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
    protected function _groupByKey($json)
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
     * @access protected
     */
    protected function _columnsList($data)
    {
        foreach ($data as $key => $row)
        {
            $ordering[$key]   = $row['ordering'];
            $main_image[$key] = $row['main_image'];
        }

        // Ordena os dados com ordering ascendente, main_image ascendente
        // Adiciona $data como o último parâmetro, para ordenar pela chave comum
        array_multisort($ordering, SORT_ASC, $main_image, SORT_ASC, $data);

        return $data;
    }
}
