<?php
/**
 * hjplace icon view
 *
 * @uses $vars['entity']     The entity the icon represents - uses getIconURL() method
 * @uses $vars['size']       topbar, tiny, small, medium (default), large, master
 * @uses $vars['href']       Optional override for link
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class added to link
 */
namespace hypeJunction\Places;
$entity = elgg_extract('entity', $vars);

$requested_size = $size = elgg_extract('size', $vars);
$places_config = get_icon_sizes($entity);
if (array_key_exists($requested_size, $places_config)) {
	$values = elgg_extract($requested_size, $places_config);
	$requested_w = $values['w'];
} else {
	list($requested_w, $requested_h) = explode('x', $requested_size);
}
//$class = elgg_extract('img_class', $vars, 'places-icon centered');
$size = elgg_extract('size', $vars, 'medium');
$url = elgg_extract('href', $vars, $entity->getURL());
$class = [];

$title = htmlspecialchars($entity->title, ENT_QUOTES, 'UTF-8', false);

if (isset($vars['img_class'])) {
	$class[] = $vars['img_class'];
}
if ($entity->hasIcon($size)) {
	$class[] = 'elgg-photo';
}
$img = elgg_view('output/img', [
	'class' => $class,
	'alt' => $entity->getDisplayName(),
	'src' => $entity->getIconURL($size),
]);
if (!$url) {
	echo $img;
	return;
}

echo elgg_view('output/url', [
	'href' => $url,
	'text' => $img,
	'is_trusted' => true,
	'class' => elgg_extract('link_class', $vars),
]);
