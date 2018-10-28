<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Add Vote");
$options = $view->getVariable("options");
$survey = $view->getVariable("survey");
$errors = $view->getVariable("errors");
?>

<?= isset($errors["general"])?$errors["general"]:"" ?>

		<div class="container mt-3" id="main">
			
				<div class="row">
					<div class="col">
						<div class="container-fluid mt-3 mb-3">
							<div align="center">						
								<h4 class="header"><?php echo $survey->getTitle(); ?></h4>
							</div>
							<div align="left">
								<p><?php echo $survey->getDescription(); ?></p>
							</div>
							
							<div class="container" align="center">	
							<form action="index.php?controller=votes&amp;action=add&amp;survey_id=<?php echo $survey->getId();?>" id="votar" method="POST">
							<p><div class="divTable Tabla">								
								<?php foreach($options as $option){ ?>
									<div class="divTableRow">
                                         <div class="divTableCell"><?php echo $option->getDay()->format("Y-m-d")." ".$option->getStart()->format("H:i:s")."-".$option->getEnd()->format("H:i:s");?></div>
										<div class="divTableCell">
												<select class="custom-select" name="all_votes[]">
													<option selected value="NS">Elige</option>
													<option value="Y">Sí</option>
													<option value="N">No</option>
													<option value="NS">Podría ser</option>
												</select>
										</div>
								</div><?php } ?>
							</div></p>
							</form>
								<button type="submit" class="btn btn-light" name="submit" form="votar"><?=i18n("Vote")?></button>
								<button onclick="goBack()"class="btn btn-light"><?=i18n("Go Back")?></button>
								<script>
									function goBack() {
										window.history.back();
									}
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
