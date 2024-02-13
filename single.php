<?php
get_header(); ?>

<div class="main-container">

	<?php
	$args = array(
		'name' => 'team-mariee',
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
		echo 'Aucun post trouvé avec le nom "team-mariee".';
	}
	?>
	<!-- Partie CTA plus miniature et navigation entre single -->
	<section class="single-commande">
		<div class="cta-container">
			<p>Cette photo vous intéresse ?</p>
			<form class="cta-contact" action="submit">Contact</form>
		</div>
			<div class="single-commande-nav-container">
				<div class="single-commande-nav-miniature">
					<img src="http://localhost:8888/NathalieMota/wp-content/uploads/2024/02/nathalie-5-scaled.jpg" alt="tutu">
				</div>
				<div class="single-commande-nav">
					<img class="single-commande-fleche" src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/arrow-left-long-solid.svg" alt="Flèche gauche">
					<img class="single-commande-fleche" src="http://localhost:8888/NathalieMota/wp-content/themes/NathalieMota/assets/images/arrow-right-long-solid.svg" alt="Flèche droite">
				</div>
			</div>
	</section>
	<!-- Partie recommandation d'autres photos -->
	<section class="single-recommande-container">
		<h3 class="single-recommande-titre">vous aimerez aussi</h3>
		<div class="single-recommande-container-photos">
			<div class="single-recommande-container-one-photo"><img class="single-recommande-photo" src="http://localhost:8888/NathalieMota/wp-content/uploads/2024/02/nathalie-3-scaled.jpg" alt="toto"></div>
			<div class="spacer"></div>
			<div class="single-recommande-container-one-photo"><img class="single-recommande-photo" src="http://localhost:8888/NathalieMota/wp-content/uploads/2024/02/nathalie-2-scaled.jpg" alt="titi"></div>
		</div>
	</section>

	</main>
</div>

<?php
get_footer();
