<?php ?>

<div class="sidebar" id="sidebar-left">
    <ul>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Colonne Gauche') ) : endif; ?>
    </ul>
</div>