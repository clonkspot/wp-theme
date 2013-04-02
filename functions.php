<?php

//
//  Custom Child Theme Functions
//

// I've included a "commented out" sample function below that'll add a home link to your menu
// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
//function childtheme_menu_args($args) {
//    $args = array(
//        'show_home' => 'Home',
//        'sort_column' => 'menu_order',
//        'menu_class' => 'menu',
//        'echo' => true
//    );
//	return $args;
//}
//add_filter('wp_page_menu_args','childtheme_menu_args');


function clonkspot_postheader() { ?>
<div id="blog-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><img src="/blog/header/<?php echo mt_rand(1, 2); ?>.jpg" alt="clonkspot" /></a></span></div>
<?php }

function clonkspot_widthJS() { ?>
<script type='text/javascript'>
// Größe des Headerbilds
var max = 1170;
// Breite des Inhalts
var main = document.getElementById('main');
var width = main.offsetWidth;
// Breite festsetzen, damit beim Zoomen nichts verschiebt
main.style.width = width + 'px';
if(max > width) {
	var logo = document.getElementById('branding');
	logo.style.width = width + 'px';
	logo.firstElementChild.firstElementChild.firstElementChild.firstElementChild.style.left = (width - max) + 'px';
}
// Breite des Contents anpassen, sodass die Sidebox hinpasst (230px)
document.getElementById('container').style.width = width - 230 - 30 + 'px';
</script>
<?php }

add_filter('wp_footer', 'clonkspot_widthJS');

// Removes thematic_blogtitle from the thematic_header phase
function remove_thematic_actions() {
    remove_action('thematic_header','thematic_blogtitle',3);
	remove_action('thematic_header','thematic_blogdescription',5);
}
// Call 'remove_thematic_actions' during WP initialization
add_action('init','remove_thematic_actions');

// Add our custom function to the 'thematic_header' phase
add_filter('thematic_header','clonkspot_postheader',3);


function clonkspot_comment_tree() { ?>
	<b>Bitte die Baumstruktur beachten!</b>
<?php }

add_filter('thematic_belowcommentsform','clonkspot_comment_tree');

function clonkspot_categorys() {
	return; // keine Kategorien!
}

add_filter('thematic_postfooter_postcategory','clonkspot_categorys');

function clonkspot_postfooter_posttags() {
	if (is_single()) {
        $tagtext = 'Getagged ';
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span>');
    } elseif ( is_tag() && $tag_ur_it = thematic_tag_ur_it(', ') ) { /* Returns tags other than the one queried */
        $posttags = '<span class="tag-links">' . 'Getagged ' . $tag_ur_it . '</span> <span class="meta-sep meta-sep-comments-link">|</span>';
    } else {
        $tagtext = 'Getagged ';
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span> <span class="meta-sep meta-sep-comments-link">|</span>');
    }
	
	return $posttags;
}

add_filter('thematic_postfooter_posttags','clonkspot_postfooter_posttags');

?>
