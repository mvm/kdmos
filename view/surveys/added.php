<?php
require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../core/I18n.php");
$view = ViewManager::getInstance();

$survey = $view->getVariable("survey");
$view->setVariable("title", "Survey added");
?>

<div class="container mt-4" id="main">
  <h1><?= i18n("Survey added successfully") ?></h1>

    <p><?php printf(i18n("You can now access your survey %s."),
    "<a href='/index.php?id=" . $survey->getId() . "'>here</a>"); ?></p>
</div>