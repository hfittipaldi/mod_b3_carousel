<?php
/**
 * @version     1.0.1
 * @package     mod_b3_carousel
 *
 * @author      Hugo Fittipaldi <hugo.fittipaldi@gmail.com>
 * @copyright   Copyright (C) 2016 Magic RM Comunicação. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

//No Direct Access
defined('_JEXEC') or die;

if ($images !== null) :
?>
<div id="carousel<?php echo $module_id; ?>" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
    <?php foreach ($images as $k => $image) : ?>
        <li data-target="#carousel<?php echo $module_id; ?>" data-slide-to="<?php echo $k; ?>"<?php echo $k==0 ? ' class="active"': ''; ?>></li>
    <?php endforeach; ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

    <?php foreach ($images as $k => $image) : ?>

        <div class="item<?php echo $k==0 ? ' active' : ''; ?>"<?php echo $image['background_image']!='' ? ' style="background-image:url(' . JUri::base() . '/' . $image['background_image'] . '");' : ''; ?>>
        <?php if ($image['link'] !== '') : ?>
            <a href="<?php echo $image['link']; ?>"<?php echo $image['target']==1 ? ' target="_blank"' : ''; ?>>
                <img src="<?php echo JUri::base(true) . '/' . $image['main_image']; ?>" alt="<?php echo $image['title']; ?>">
            </a>
        <?php else : ?>
            <img src="<?php echo JUri::base(true) . '/' . $image['main_image']; ?>" alt="<?php echo $image['title']; ?>">
        <?php endif; ?>

            <div class="carousel-caption">
                <?php echo $image['description']; ?>
            </div>
        </div>
    <?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel<?php echo $module_id; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel<?php echo $module_id; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<?php else : ?>
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Erro</h4>
    <div class="alert-message">Não existe nehuma imagem cadastrada.</div>
</div>
<?php endif; ?>