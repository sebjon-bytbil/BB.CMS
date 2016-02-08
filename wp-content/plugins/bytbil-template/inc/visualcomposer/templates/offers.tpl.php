<?php if (!empty($items)) : ?>

<div id="offers" class="container">

<?php foreach ($items as $key => $item) : ?>

    <div class="col-xs-12 col-sm-<?php echo $columns; ?>">
        <img src="<?php echo $item['image']; ?>" alt="" title="" class="img-responsive">
        <span class="offer">
            <h3><?php echo $item['headline']; ?></h3>
            <p><?php echo $item['ingress']; ?></p>
            <span class="date">Gäller t.o.m. <?php echo $item['date_stop']; ?></span>
            <a href="<?php echo $item['permalink']; ?>" class="read-more">Läs mer</a>
        </span>
    </div>

<?php endforeach; ?>

<?php if ($link_all_offers) : ?>
    <div class="container">
        <a href="#" class="button default">Se alla erbjudanden</a>
    </div>
<?php endif; ?>

</div>

<?php endif; ?>
