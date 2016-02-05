<?php $dir = get_template_directory_uri(); ?>

<?php if($id) { ?>

    <div class="bb-news">
        <h4><?php echo $title; ?></h4>
    </div>

<?php } else { ?>

    <div class="bb-news">
        <div class="row">

            <?php foreach($items as $key => $item) { ?>

                <div class="col-xs-12 col-sm-<?php echo $columns; ?>">
                    <h4><?php echo $item['headline']; ?></h4>
                    <?php echo $item['article_excerpt']; ?><br>
                    <a href="<?php echo $item['article_link']; ?>">Läs mer</a>
                </div>

            <?php } ?>

        </div>

        <?php if($pagination == "1" && $pagination_next != null) { ?>
            <div class="pagination">
                <strong><?php echo $pagination_prev; ?></strong><?php echo $pagination_separator; ?><strong><?php echo $pagination_next; ?></strong>
            </div>
        <?php } ?>
    </div>

<?php } ?>