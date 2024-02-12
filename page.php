<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="main-container">
		<section><h1><?php the_title(); ?></h1></section>
		

		<?php the_content(); ?>

<?php endwhile; endif; ?>
</div>
		
<?php get_footer(); ?>