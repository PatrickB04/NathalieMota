<?php
get_header(); ?>

<div class="main-container">

	<?php
	$args = array(
		'name' => get_post_field('post_name', get_post()),
		'post_type' => 'photo',
		'post_status' => 'publish',
		'numberposts' => 1
	);
	$my_posts = get_posts($args);

	if ($my_posts) {
		$id = $my_posts[0]->ID;

		// Afficher les informations plus photo de la première partie
		echo '<main class="single-container"><section class="single-principal"><div class="format-single"><h2>' . get_the_title($id) . '</h2>';
		echo '<p>Référence: ' . get_field('reference', $id) . '</p>';
		echo '<p>Catégories: ' . implode(', ', wp_get_post_terms($id, 'categorie', array('fields' => 'names'))) . '</p>';
		echo '<p>Formats: ' . implode(', ', wp_get_post_terms($id, 'format', array('fields' => 'names'))) . '</p>';
		echo '<p>Type: ' . get_field('type', $id) . '</p>';
		echo '<p>Année: ' . get_the_date('Y', $id) . '</p></div>';
		echo '<div class="format-photo-single">' . '<img class="image-single" src="' . get_the_post_thumbnail_url($id) . '" alt="' . get_the_title($id) . '"></div></section>';
	} else {
		echo 'Aucun post trouvé avec le nom "' . get_the_title($id) . '".';
	}
	?>
	<!-- Partie CTA plus miniature et navigation entre single -->
	<section class="single-commande">
		<div class="cta-container">
			<p>Cette photo vous intéresse ?</p>
			<div id="cta-contact" class="cta-contact" data-reference="<?php $reference = get_field('reference');
																		echo esc_attr($reference); ?>">Contact</div> <!-- Partie PHP pour passer la référence au mail -->
		</div>
		<div class="single-commande-nav-container">
			<div class="single-commande-nav-miniature" id="post-thumbnail">
				<!-- La miniature du post sera chargée ici avec AJAX -->
			</div>
			<div class="single-commande-nav">
				<img class="single-commande-fleche" id="previous-post" src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/arrow-left-long-solid.svg" alt="Flèche gauche">
				<img class="single-commande-fleche" id="next-post" src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/arrow-right-long-solid.svg" alt="Flèche droite">
			</div>
		</div>
	</section>
	<!-- Partie recommandation d'autres photos -->
	<section class="single-recommande-container">
		<h3 class="single-recommande-titre">vous aimerez aussi</h3>
		<div class="single-recommande-container-photos">
		<?php
			$related_posts = get_related_posts($id);
			foreach ($related_posts as $post) : setup_postdata($post); 
				$reference = get_post_meta($post->ID, 'reference', true);
				$categories = get_the_terms($post->ID, 'categorie'); // Récupère les catégories du post
				$categorie = !empty($categories) ? array_shift($categories)->name : ''; // Prend le nom de la première catégorie
				$lien = get_permalink($post->ID); // Récupère le lien du post
				$post_thumbnail_id = get_post_thumbnail_id(); // Récupérer l'ID de l'image mise en avant
				$image_url = wp_get_attachment_url($post_thumbnail_id); // Récupérer l'URL de l'image originale
		?>
				<div class="single-recommande-container-one-photo">
					<div class="portfolio-item2">
						<img class="single-recommande-photo" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
						<div class="overlay">
							<div class="symbol"><a href="<?php echo $lien; ?>"><img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/Icon_eye.svg" alt="Icon_eye"></a></div>
							<div class="reference"><?php echo $reference; ?></div>
							<div class="category"><?php echo $categorie; ?></div>
							<div class="icon"><a class="example-image-link" href="<?php echo $image_url ?>" data-lightbox="NathalieMota" data-title="<div><?php echo strtoupper($reference) ?></div><div><?php echo strtoupper($categorie) ?></div></div>"><img src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/Icon_fullscreen.svg" alt="Full_screen"></a></div>
						</div>
					</div>
				</div>

		<?php endforeach;
		wp_reset_postdata(); ?>
				</div>
	</section>

	</main>
</div>

<?php
get_footer();
