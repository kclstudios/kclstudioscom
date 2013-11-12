<?php
// load drupal
chdir('../../../..');
require_once './includes/bootstrap.inc';
require_once './includes/common.inc';
require_once './includes/module.inc';
require_once './includes/theme.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$offset=$_GET["offset"];

// query for pages published to the frontpage
$result = db_query_range('SELECT n.nid FROM {node} n WHERE n.promote = 1', $offset, 1);

// load node ($nid is the id of the node you wanna load)
$node = node_load(4);

// theme the node and output the generated HTML
print node_view($node);
//print_r($node);
?>