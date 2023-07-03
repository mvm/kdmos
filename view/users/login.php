<?php

require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../core/I18n.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Kdamos?");
$errors = $view->getVariable("errors");
?>

<?= isset($errors["general"])?$errors["general"]:"" ?>

 <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-sm-6">
          <div class="card h-100">
            <a href="?controller=surveys&action=add"><i class="card-img-top fas fa-plus fa-10x" alt="Card image"></i></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="?controller=surveys&action=add"><?= i18n("Create Survey:")?></a>
              </h4>
              <p class="card-text"><?= i18n("Create a new survey and send a link for voting to any registered friend.")?></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6">
          <div class="card h-100">
            <a href="?controller=surveys&action=list_participated"><i class="card-img-top fas fa-search fa-10x" alt="Card image"></i></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="?controller=surveys&action=list_participated"><?= i18n("Search for surveys:")?></a>
              </h4>
              <p class="card-text"><?= i18n("Search for surveys where you have voted for consulting its status and, if you want, update your vote")?></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6">
          <div class="card h-100">
            <a href="?controller=surveys&action=list_created"><i class="card-img-top fas fa-search-plus fa-10x" alt="Card image"></i></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="?controller=surveys&action=list_created"><?= i18n("Search for your surveys:")?></a>
              </h4>
              <p class="card-text"><?= i18n("Searh for the surveys that you created for consulting its status and, if you want, modify the options.")?></p>
            </div>
          </div>
        </div>
      </div>
      </div>








