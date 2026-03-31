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

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Folder;

/**
 * Script file of B3 Carousel Module.
 *
 * This class will be called by Joomla!'s installer,
 * and is used for custom automation actions in its installation process.
 *
 * @package     Joomla.Site
 * @subpackage  mod_b3_carousel
 * @since       2.0
 */
return new class () implements InstallerScriptInterface
{
    private string $minimumJoomla = '4.0.0';
    private string $minimumPhp    = '8.1.0';

    public function install(InstallerAdapter $adapter): bool
    {
        echo Text::_('MOD_B3_CAROUSEL_INSTALL');
        return true;
    }

    public function update(InstallerAdapter $adapter): bool
    {
        echo Text::_('MOD_B3_CAROUSEL_UPDATE');
        return true;
    }

    public function uninstall(InstallerAdapter $adapter): bool
    {
        echo Text::_('MOD_B3_CAROUSEL_UNINSTALL');
        return true;
    }

    public function preflight(string $type, InstallerAdapter $adapter): bool
    {
        if ($type == 'update') {
            try {
                // Folders to delete
                $folderToDelete = [
                    'modules/mod_b3_carousel',
                    'media/mod_b3_carousel'
                ];

                foreach ($folderToDelete as $folder) {
                    if (is_dir(JPATH_ROOT . '/' . $folder)) {
                        Folder::delete(JPATH_ROOT . '/' . $folder);
                    }
                }
            } catch (Exception $e) {
                Factory::getApplication()->enqueueMessage(sprintf(Text::_('MOD_B3_CAROUSEL_FOLDER_DELETE_ERROR'), $e->getMessage()), 'error');
                return false;
            }
        }

        if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            Factory::getApplication()->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_PHP'), $this->minimumPhp), 'error');
            return false;
        }

        if (version_compare(JVERSION, $this->minimumJoomla, '<')) {
            Factory::getApplication()->enqueueMessage(sprintf(Text::_('JLIB_INSTALLER_MINIMUM_JOOMLA'), $this->minimumJoomla), 'error');
            return false;
        }

        return true;
    }

    public function postflight(string $type, InstallerAdapter $adapter): bool
    {
        return true;
    }
};
