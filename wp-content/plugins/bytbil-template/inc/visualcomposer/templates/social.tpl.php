<?php if (!empty($social_links)) : ?>
    <div class="bb-social">
    <?php foreach ($social_links as $link) : ?>
        <a href="<?php echo $link['link']; ?>" target="_blank">
            <i class="<?php echo $link['icon']; ?>"></i>
        </a>
    <?php endforeach; ?>
    </div>
<?php endif; ?>