<?php

require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../core/I18n.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

			<div class="container mt-4" id="main">
				<form action="index.php?controller=users&amp;action=register" method="POST">
					<div class="row">
                            <div class="col">
								<div class="container mt-3 mb-3">
								<h1><?= i18n("Register")?></h1>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder=<?= i18n("Name")?>></input>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="surname" class="form-control" placeholder=<?= i18n("Surname")?>></input>
                                    </div>
									<div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder=<?= i18n("Email")?>></input>
                                    </div>
									<div class="form-group">
                                        <input type="password" name="pass" class="form-control" placeholder=<?= i18n("Password")?>></input>
                                    </div>
                                    <button type="submit" class="btn btn-light"><?= i18n("Sign up")?></button>
								</div>
							</div>	
					</div>
				</form>
			</div>