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

if ($images !== null) { ?>

<div id="b3Carousel-<?php echo $module_id; ?>" class="b3Carousel carousel slide<?php echo $transition; ?>"
     data-ride="carousel"<?php echo $interval . $pause . $wrap . $keyboard; ?>>
    <?php if ($indicators === 1) { ?>
    <!-- Indicators -->
    <ol class="carousel-indicators">
    <?php
    $k = 0;
    foreach ($images as $image)
    {
        $publish_start = !empty($image->publish_start) ? $image->publish_start : $now;
        $publish_end   = !empty($image->publish_end) ? $image->publish_end : $now;

        if ($now >= $publish_start && $now <= $publish_end)
        {
    ?>
        <li data-target="#b3Carousel-<?php echo $module_id; ?>" data-slide-to="<?php echo $k; ?>"
            <?php echo $k === 0 ? ' class="active"': ''; ?>></li>
    <?php $k++;
        } // Endif
    } // Endforeach ?>
    </ol>
    <?php } // Endif ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

    <?php
    $styles = '';
    $k = 0;
    foreach ($images as $image)
    {
        if ($image->alternative_image !== '')
        {
            $styles .= '
.item-' . $module_id . '-' . $k . ' {
    background-image:url(' . JUri::base() . $image->alternative_image . ');
}';
        }

        $alt = $image->title;
        if ($alt === '')
        {
            $parts = explode('/', $image->main_image);
            $alt = array_pop($parts);
        }

        $link = modB3CarouselHelper::getUrl($image);

        $publish_start = !empty($image->publish_start) ? $image->publish_start : $now;
        $publish_end   = !empty($image->publish_end) ? $image->publish_end : $now;
        if ($now >= $publish_start && $now <= $publish_end)
        {
        ?>
        <figure class="<?php echo $item; ?>item item-<?php echo $module_id . '-' . $k . ($k === 0 ? ' active' : ''); ?>">
            <?php if ($link !== '') { ?>
            <a href="<?php echo JRoute::_($link); ?>"<?php echo $image->target == 0 ? ' target="_blank"' : ''; ?>>
                <img src="<?php echo JUri::base() . $image->main_image; ?>" alt="<?php echo $alt; ?>" />
            </a>
            <?php } else { ?>
            <img src="<?php echo JUri::base() . $image->main_image; ?>" alt="<?php echo $alt; ?>" />
            <?php } // Endif ?>

            <?php if ($image->caption) { ?>
            <figcaption class="carousel-caption">
                <?php echo $image->caption; ?>
            </figcaption>
            <?php } // Endif ?>
        </figure>
    <?php $k++;
        }
    } ?>
    </div>

    <?php if ($controls === 1) { ?>
    <!-- Controls -->
    <a class="<?php echo $ctrlPrev; ?>" href="#b3Carousel-<?php echo $module_id; ?>" role="button" data-slide="prev">
        <span class="<?php echo $spanPrev; ?>" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="<?php echo $ctrlNext; ?>" href="#b3Carousel-<?php echo $module_id; ?>" role="button" data-slide="next">
        <span class="<?php echo $spanNext; ?>" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php } // Endif ?>

</div>

    <?php
    if ($styles !== '')
    {
        $doc->addStyleDeclaration($styles);
    }
} else {
?>
<div class="alert alert-warning" role="alert">
    <strong>Atenção: </strong>Não existe nehuma imagem cadastrada.
</div>
<?php } ?>
