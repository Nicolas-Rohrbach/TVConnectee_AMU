<?php /* Template Name: 3 colonnes */

get_header(); ?>
<link href="/wp-content/themes/TvConnecteeAmu/assets/css/threeColumns.css" rel="stylesheet">
</head>
<body>
<?php include_once 'inc/menu.php'?>
<div id="page">
    <?php get_sidebar(2); ?>
<div id="content-threecolumns">
    <?php if(have_posts()) :
        while(have_posts()) : the_post(); ?>
            <div class= "post" id="post-<?php the_ID(); ?>">
                <!--    <h2><a href="<?php //the_permalink(); ?>" title="<?php //the_title(); ?>"><?php //the_title(); ?></a></h2> -->
                <div class= "post_content"><?php the_content(); ?></div>
            </div>
        <?php endwhile; ?>
        <?php edit_post_link('Modifier cette page', '<p>', '</p>'); ?>
    <?php else : ?><h2>Oooopppsss...</h2> <p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici .</p> <?php include (TEMPLATEPATH . "/searchform.php"); ?>
    <?php endif; ?>
</div>
<?php get_sidebar();

get_footer(); ?>
</div>
</body>
</html>