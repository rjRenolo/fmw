<?php
/**
 * Block Name: FMW cover block
 *
 */

// create id attribute for specific styling
$id = 'fmwover-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];


?>
<div class="block-usp  <?=$class?>" id="<?=$id?>">
    <div class="container">
	   <?php
        $icDescs = get_field('icon_description');
        if( $icDescs ) {?>
            <div class="row">

                <?php foreach($icDescs as $row){ ?>
                    <div class="usp-icon">
                        <a href="<?=$row['link']?>">
                            <img src="<?=$row['icon']?>" alt="">
                            <h4 class="textcenter"><?=$row['description']?></h4>
                        </a>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>
    </div>
</div>

	