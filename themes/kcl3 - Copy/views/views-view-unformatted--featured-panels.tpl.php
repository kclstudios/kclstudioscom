<?php
// $Id: views-view-unformatted--frontpage-panels.tpl.php,v 1.6 20011/01/10 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted--frontpage-panels-toc.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>


<?php foreach ($rows as $id => $row): ?>
<?php print $row; ?>
<?php endforeach; ?>
