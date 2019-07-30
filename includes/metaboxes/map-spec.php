<?php

$map_metabox = new WPAlchemy_MetaBox(array
(
	'id' => '_map_metabox',
	'title' => 'Map',
	'template' => dirname(__FILE__) . '/map-meta.php',
	'include_template' => 'page-contact.php',
	'priority' => 'high',
	'context' => 'side'
));

/* eof */