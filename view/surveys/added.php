<?php
require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../core/I18n.php");
$view = ViewManager::getInstance();

$survey = $view->getVariable("survey");
$view->setVariable("title", "Survey added");
?>

<div class="container mt-4" id="main">
  <h1><?= i18n("Survey added successfully") ?></h1>

    <p><?= i18n("You can now access your survey ")?>
    <a href="?controller=votes&amp;action=add&amp;survey_id=<?php echo $survey->getId();?>">here</a></p>
</div>