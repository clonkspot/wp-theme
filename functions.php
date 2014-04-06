<?php

// Get both site header and footer from the frontend app.
$layout = json_decode(file_get_contents('https://clonkspot.org/_layout'));

// Include our site header.

function clonkspot_header() {
  global $layout;
  echo $layout->header;
}
add_action('thematic_before', 'clonkspot_header');

function clonkspot_remove_actions() {
  remove_all_actions('thematic_header');
  remove_all_actions('thematic_footer');
}
add_action('init', 'clonkspot_remove_actions');

function clonkspot_remove() {
  return '';
}
// Remove unused header and footer elements.
add_filter('thematic_open_header', 'clonkspot_remove');
add_filter('thematic_close_header', 'clonkspot_remove');
add_filter('thematic_open_footer', 'clonkspot_remove');
add_filter('thematic_close_footer', 'clonkspot_remove');

// No categories.
add_filter('thematic_postfooter_postcategory','clonkspot_remove');

function clonkspot_postfooter_posttags() {
  $tagtext = 'Getagged ';
  if (is_single()) {
    $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span>. ');
  } elseif ( is_tag() && $tag_ur_it = thematic_tag_ur_it(', ') ) { /* Returns tags other than the one queried */
    $posttags = '<span class="tag-links">' . $tagtext . $tag_ur_it . '</span> <span class="meta-sep meta-sep-comments-link">| </span>';
  } else {
    $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span> <span class="meta-sep meta-sep-comments-link">| </span>');
  }

  return $posttags;
}
add_filter('thematic_postfooter_posttags','clonkspot_postfooter_posttags');

function clonkspot_comment_tree() { ?>
  <b>Bitte die Baumstruktur beachten!</b>
<?php }
add_filter('thematic_belowcommentsform', 'clonkspot_comment_tree');

function clonkspot_footer() {
  global $layout;
  echo $layout->footer;
}
add_action('thematic_after', 'clonkspot_footer');

