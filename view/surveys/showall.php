<?php

require_once(__DIR__."/../../core/ViewManager.php");

$view = ViewManager::getInstance();

$surveys = $view->getVariable("results");
$edit = $view->getVariable("edit");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Surveys");

?>

	<div class="container" id="main">
    <h1 class="header" ><?=i18n("Surveys")?></h1>
		<div class="container" align="center">			
			<div class="divTable Tabla " >
			<div class="divTableRow">
				<div class="divTableCell"><?= i18n("Title")?></div>
				<div class="divTableCell"><?= i18n("Description")?></div>
				<div class="divTableCell"><?= i18n("Status/Update")?></div>
			</div>
			<?php foreach($surveys as $survey){ ?>
			<div class="divTableRow">
				<div class="divTableCell"><?php echo $survey->getTitle();?></div>
				<div class="divTableCell"><?php echo $survey->getDescription();?></div>
				<div class="divTableCell"><a href="index.php?controller=votes&amp;action=show&amp;survey_id=<?php echo $survey->getId();  ?>"><i class="whiteicon fa fa-id-card" aria-hidden="true"></i></a>
<?php
                 if($edit == true) {
?>
				<a href="index.php?controller=surveys&amp;action=edit&amp;id=<?php echo $survey->getId();  ?>"><i class="fa fa-pen whiteicon" aria-hidden="true"></i></a>
<?php
                     }
?>
				</div>
			</div>
<?php
                 }
?>
		</div>
	</div>