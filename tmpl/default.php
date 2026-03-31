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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Module\B3Carousel\Site\Helper\B3CarouselHelper;

$now = Factory::getDate();

$transition = (int) $params->get('transition', 0) !== 0 ? ' carousel-fade' : '';

$interval = (int) $params->get('interval', 5000);
$interval = $interval !== 5000 ? ' data-bs-interval="' . $interval . '"': '';
$interval = $params->get('autoslide', 1) ? $interval . ' data-bs-ride="carousel"': ' data-bs-interval="false"';

$pause    = !$params->get('pause', 1) ? ' data-bs-pause="false"': '';
$wrap     = !$params->get('wrap', 1) ? ' data-bs-wrap="false"': '';
$keyboard = !$params->get('keyboard', 1) ? ' data-bs-keyboard="false"': '';

// Slides
$images = $params->get('slides');

if ($images !== null) : ?>

<div id="b3Carousel-<?= $module->id; ?>" class="b3Carousel carousel slide<?= $transition; ?>" data-bs-touch="true"<?= $interval . $pause . $wrap . $keyboard; ?>>
    <?php if ($params->get('indicators')) { ?>
    <!-- Indicators -->
    <div class="carousel-indicators">
    <?php
    $k = 0;
    foreach ($images as $image) :
        $publish_start = !empty($image->publish_start) ? $image->publish_start : $now;
        $publish_end   = !empty($image->publish_end) ? $image->publish_end : $now;

        if ($now >= $publish_start && $now <= $publish_end) : ?>

        <button type="button" data-bs-target="#b3Carousel-<?=$module->id;?>" data-bs-slide-to="<?=$k;?>"<?= $k === 0 ? ' class="active" aria-current="true"' : ''; ?> aria-label="Slide 1"></button>

    <?php $k++;
        endif;
    endforeach; ?>
    </div>
    <?php } // Endif ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

    <?php
    $styles = '';
    $k = 0;
    foreach ($images as $image) :
        if ($image->alternative_image !== '') {
            $styles .= '
.item-' . $module->id . '-' . $k . ' {
    background-image:url(' . Uri::base() . $image->alternative_image . ');
}';
        }

        $alt = $image->title;
        if ($alt === '') {
            $parts = explode('/', $image->main_image);
            $alt = array_pop($parts);
        }

        $link = B3CarouselHelper::getUrl($image);
        $imageAttrs = HTMLHelper::cleanImageURL($image->main_image);

        $publish_start = !empty($image->publish_start) ? $image->publish_start : $now;
        $publish_end   = !empty($image->publish_end) ? $image->publish_end : $now;
        if ($now >= $publish_start && $now <= $publish_end) : ?>

        <div class="carousel-item item-<?= $module->id . '-' . $k . ($k === 0 ? ' active' : ''); ?>">
            <?php if ($link !== '') : ?>
            <a href="<?= Route::_($link); ?>"<?= $image->target == 0 ? ' target="_blank"' : ''; ?>>
                <img src="<?= Uri::base() . $imageAttrs->url; ?>" alt="<?= $alt; ?>" />
            </a>
            <?php else : ?>
            <img src="<?= Uri::base() . $imageAttrs->url; ?>" alt="<?= $alt; ?>" />
            <?php endif; ?>

            <?php if ($image->caption) : ?>
            <div class="carousel-caption">
                <?= $image->caption; ?>
            </div>
            <?php endif; ?>

        </div>
    <?php $k++;
        endif;
    endforeach; ?>
    </div>

    <?php if ($params->get('controls')) : ?>
    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#b3Carousel-<?=$module->id;?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#b3Carousel-<?=$module->id;?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    <?php endif; ?>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myCarouselElement = document.getElementById('b3Carousel-<?=$module->id;?>');
        var carousel = new bootstrap.Carousel(myCarouselElement);
    });
</script>

    <?php
    if ($styles !== '') :
        $wa->addInlineStyle($styles);
    endif;

else : ?>

<div class="alert alert-warning" role="alert">
    <?= Text::_('MOD_B3_CAROUSEL_NO_IMAGE'); ?>
</div>

<?php endif;
