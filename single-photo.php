<h3>toto</h3>
<h3 class="site__heading"><?php post_type_archive_title(); ?></h3>

<main class="site__portfolio">
	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    	<div class="project">
        	<h2 class="project__title">
                <a href="<?php the_permalink(); ?>">
                	<?php the_title(); ?>
                </a>
            </h2>
         	<?php the_post_thumbnail(); ?>
    	</div>
    <?php endwhile; endif; ?>
</main> 

<?php the_posts_pagination(); ?>