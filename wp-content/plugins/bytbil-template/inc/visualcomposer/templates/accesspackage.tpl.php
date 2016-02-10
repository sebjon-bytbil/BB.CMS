<?php
if (function_exists('bytbil_init_assortment')) {
    bytbil_init_assortment($assortment_alias, $assortment_string, $assortment_page, false, $assortment_id);
    bytbil_show_assortment($assortment_id);
}
?>