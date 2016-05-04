<?php
/**
 * @version     1.2.2
 * @package     mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2016 Hugo Fittipaldi. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

//No Direct Access
defined('_JEXEC') or die;

if ($images !== null) :
?>
<div id="carousel-<?php echo $module_id; ?>" class="carousel slide" data-ride="carousel"<?php echo $interval . $pause . $wrap . $keyboard; ?>>
    <?php if ($indicators === 1) : ?>
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($images as $k => $image) : ?>
        <li data-target="#carousel-<?php echo $module_id; ?>" data-slide-to="<?php echo $k; ?>"<?php echo $k==0 ? ' class="active"': ''; ?>></li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

        <?php
        $styles = '';
        foreach ($images as $k => $image)
        {
            if ($image['background_image'] != '')
            {
                $styles .= '
    .item-' . $module_id . '-' . $k . ' {
        background-image:url(' . JUri::base() . $image['alternative_image'] .');
    }';
            }
        ?>

        <figure class="item-<?php echo $module_id . '-' . $k; ?> item<?php echo $k==0 ? ' active' : ''; ?>">
            <?php if ($image['link'] !== '') : ?>
            <a href="<?php echo $image['link']; ?>"<?php echo $image['target']==1 ? ' target="_blank"' : ''; ?>>
                <img src="<?php echo JUri::base() . $image['main_image']; ?>" alt="<?php echo $image['title']; ?>" />
            </a>
            <?php else : ?>
            <img src="<?php echo JUri::base() . $image['main_image']; ?>" alt="<?php echo $image['title']; ?>" />
            <?php endif; ?>

            <?php if ($image['description']) : ?>
            <figcaption class="carousel-caption">
                <?php echo $image['description']; ?>
            </figcaption>
            <?php endif; ?>
        </figure>
        <?php } ?>
    </div>

    <?php if ($controls === 1) : ?>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-<?php echo $module_id; ?>" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-<?php echo $module_id; ?>" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php endif; ?>
</div>
<?php if ($styles !== '') $doc->addStyleDeclaration($styles); ?>
<?php else : ?>
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Erro</h4>
    <div class="alert-message">Não existe nehuma imagem cadastrada.</div>
</div>
<?php endif; ?>
