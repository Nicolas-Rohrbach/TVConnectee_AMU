<?php
?>

<div id="footer-left">
    <?php if(is_user_logged_in()) { ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer gauche') ) : endif; ?>
    <?php } ?>
</div>
<div id="footer-right">
    <?php if(is_user_logged_in()) { ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer droite') ) : endif; ?>
    <?php } ?>
</div>

<div id="footer">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php if(is_user_logged_in()) { ?>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : endif; ?>
<?php } ?>
<?php wp_footer(); ?>
</div>