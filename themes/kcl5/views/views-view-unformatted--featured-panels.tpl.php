<?php
// $Id: views-view-unformatted--frontpage-panels.tpl.php,v 1.6 20011/01/10 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted--frontpage-panels-toc.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>


<?php $rows_count = count($rows); $rows_num = 0;

foreach ($rows as $id => $row): 

	$nid = $view->result[$id]->nid;
	$current_node=node_load($nid); 
	//$panel_title = $view->$row['field_panel_name'];
	$panel_display_name = $current_node->field_panel_name['und'][0]['safe_value'];
	$current_path = drupal_lookup_path('alias',"node/". $nid);
	$rows_num++;

?>
<div id="mcs_container_<?php print $nid ?>" class="panel">
  
	<div class="trans"></div>

	<div class="op customScrollBox">
 
 		
		<div class="container">
		<div class="content">
			<div class="static">
			

<?php 

	$row_output = node_view($current_node, $view_mode='full');
	print drupal_render($row_output);
	
?>     
			
			</div>
			<div class="dynamic"></div>
 		</div><!--/end content -->   
      </div><!--/ end container -->   
      
      <div class="dragger_container">
        <div class="dragger"></div>
      </div>   
       <a href="#" title="scroll up" class="scrollUpBtn">u</a> <a href="#" class="scrollDownBtn">d</a>        
    

  </div><!--// end op -->
  <a class="panelControl ajax<?php if($rows_num == $rows_count) : print " main"; endif; ?>" href="/<?php print $current_path ?>" title="<?php print $panel_display_name; ?>"><div><span><?php print $panel_display_name ?></span></div></a>
  <div class="panelBorder"></div>
</div>





<?php endforeach; ?>
