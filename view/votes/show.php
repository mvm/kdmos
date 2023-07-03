<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Show Votation");
$votes = $view->getVariable("votes");
$survey = $view->getVariable("survey");
$errors = $view->getVariable("errors");
?>

<?= isset($errors["general"])?$errors["general"]:"" ?>

		<div class="container mt-3" id="main">
			
				<div class="row">
					<div class="col">
						<div class="container-fluid mt-3 mb-3">
							<div align="center">						
								<h4 class="header" ><?php echo $survey->getTitle(); ?></h4>
							</div>
							<div align="left">
								<p><?php echo $survey->getDescription(); ?></p>
							</div>
							
							<div class="container" align="center">	
							
							<p><div class="divTable Tabla">

								<div class="divTableRow">
									<div class="divTableCell corner"></div>
									<?php $opcion_inicial = $votes[0]->getOptionId()->getId();									
									foreach($votes as $vote){
									if(($vote->getOptionId()->getId())==$opcion_inicial){?>
										<div class="divTableCell d-none d-sm-table-cell"><?php echo $vote->getUserId()->getName()." ".$vote->getUserId()->getSurname();?></div>
										<?php }} ?>
										<div class="divTableCell">Total</div>
								</div>
								<div class="divTableRow">
								<div class="divTableCell"><?php echo $votes[0]->getOptionId()->getDay()->format("Y-m-d")." ".$votes[0]->getOptionId()->getStart()->format("H:i:s")."-".$votes[0]->getOptionId()->getEnd()->format("H:i:s");?></div>
									<?php $total = 0;
										foreach($votes as $vote){
											if(($vote->getOptionId()->getId())==$opcion_inicial){?>
												<div class="divTableCell d-none d-sm-table-cell">
												<?php $valor = $vote->getVote();
													switch ($valor){
														case "Y":?>
															<i class="fas fa-2x fa-check option"></i><?php
															$total+=1;
															break;
														case "N":?>
															<i class="fas fa-2x fa-times option"></i><?php
															break;
														default:?>
															<i class="fas fa-2x fa-question option"></i><?php		
													}
												?></div>
											<?php }
											else{?>
												<div class="divTableCell"><?php echo $total?></div></div>
												<?php $opcion_inicial = $vote->getOptionId()->getId();
												$total = 0;?>
											<div class="divTableRow">
												<div class="divTableCell">
													<?php echo $vote->getOptionId()->getDay()->format("Y-m-d")." ".$vote->getOptionId()->getStart()->format("H:i:s")."-".$vote->getOptionId()->getEnd()->format("H:i:s");?></div>
												<div class="divTableCell d-none d-sm-table-cell">
													<?php $valor = $vote->getVote();
													switch ($valor){
														case "Y":?>
															<i class="fas fa-2x fa-check option"></i><?php
															$total+=1;
															break;
														case "N":?>
															<i class="fas fa-2x fa-times option"></i><?php
															break;
														default:?>
															<i class="fas fa-2x fa-question option"></i><?php		
													}
												?></div>
											<?php }
									} ?><div class="divTableCell"><?php echo $total?></div>							
								</div>
							</div></p>
							<button onclick="location.href='index.php?controller=votes&action=add&survey_id=<?php echo $survey->getId();  ?>'" type="button" class="btn btn-light"><?=i18n("Vote")?></button>
							<button onclick="goBack()"class="btn btn-light"><?=i18n("Go Back")?></button>
							<script>
									function goBack() {
										window.history.back();
									}
							</script>
							<div><?= i18n("Link: ");  echo $_SERVER["HTTP_HOST"];echo $_SERVER["REQUEST_URI"];?></div>
						</div>
					</div>
				</div>
			</div>
		</div>