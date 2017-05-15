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

if ($images !== null) :

    if ($full_width === 0) : ?>
<div class="container">
    <div class="row">
    <?php endif; ?>

<div id="b3Carousel-<?php echo $module_id; ?>" class="b3Carousel carousel slide<?php echo $transition . $size; ?>" data-ride="carousel"<?php echo $interval . $pause . $wrap . $keyboard; ?>>
    <?php if ($indicators === 1) : ?>
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($images as $k => $image) : ?>
        <li data-target="#b3Carousel-<?php echo $module_id; ?>" data-slide-to="<?php echo $k; ?>"<?php echo $k==0 ? ' class="active"': ''; ?>></li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

        <?php
        $styles = '';
        $k = 0;
        foreach ($images as $image) :
            if ($image->alternative_image !== '')
            {
                $styles .= '
    .item-' . $module_id . '-' . $k . ' {
        background-image:url(' . JUri::base() . $image->alternative_image .');
    }';
            }

            $link = modB3CarouselHelper::getUrl($image);
        ?>
        <figure class="item-<?php echo $module_id . '-' . $k; ?> item<?php echo $k==0 ? ' active' : ''; ?>">
            <?php if ($link !== '') : ?>
            <a href="<?php echo JRoute::_($link); ?>"<?php echo $image->target==0 ? ' target="_blank"' : ''; ?>>
                <img src="<?php echo JUri::base() . $image->main_image; ?>" alt="<?php echo $image->title; ?>" />
            </a>
            <?php else : ?>
            <img src="<?php echo JUri::base() . $image->main_image; ?>" alt="<?php echo $image->title; ?>" />
            <?php endif; ?>

            <?php if ($image->caption) : ?>
            <figcaption class="carousel-caption">
                <?php echo $image->caption; ?>
            </figcaption>
            <?php endif; ?>
        </figure>
        <?php ++$k;
        endforeach; ?>
    </div>

    <?php if ($controls === 1) : ?>
    <!-- Controls -->
    <a class="left carousel-control" href="#b3Carousel-<?php echo $module_id; ?>" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#b3Carousel-<?php echo $module_id; ?>" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php endif; ?>

</div>

    <?php if ($full_width === 0) : ?>
    </div>
</div>
    <?php endif; ?>

    <?php if ($styles !== '') $doc->addStyleDeclaration($styles); ?>

<?php else : ?>
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Erro</h4>
    <div class="alert-message">Não existe nehuma imagem cadastrada.</div>
</div>

<?php endif; ?>
