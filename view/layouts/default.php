<?php
//file: view/layouts/default.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<!-- Link to fonts-->
	<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru|Roboto" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />      

	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
	</script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>
<body>
	<nav class="navbar navbar-expand-sm" id="navbar">
		<div class="container-fluid">
			<a href="index.php"><span class="navbar-brand" id="logo">Kdamos?</span></a>
			<ul class="navbar-nav justify-content-center">
				<li class="nav-item">
					<div class="btn-group" role="group">
						<a href="?controller=surveys&action=add" class="btn btn-light"><i class="blackicon fas fa-plus"></i></a>
						<a href="?controller=surveys&action=list_participated" class="btn btn-light"><i class="blackicon fas fa-search"></i></a>
						<a href="?controller=surveys&action=list_created" class="btn btn-light"><i class="blackicon fas fa-search-plus"></i></a>
					</div>
				</li>
			</ul>
				<?php if (isset($currentuser)): ?>
				<ul class="navbar-nav justify-content-end">	
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="collapsibleNavbar">				
					<li class="nav-item">
						<i class="fas fa-user"></i><a href="?controller=surveys&action=list_created"><?= sprintf(i18n("%s"), $currentuser) ?></a>
					</li>
					<li class="nav-item">
						<i class="fas fa-sign-out-alt"></i><a href="index.php?controller=users&amp;action=logout"><?= i18n("Logout ") ?></a>
					</li>
				</div>
				</ul>

				<?php else: ?>
				<div class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" role="button" id="loginDrop" data-toggle="dropdown"><?= i18n("Login") ?>
                                <span class="caret"></span></a>
                                <div class="dropdown-menu" role="menu" aria-labelledby="loginDrop">
                                    <form class="px-3 py-2" action="index.php?controller=users&amp;action=login" method="POST" role="menuitem" tabindex="-1">
                                        <div class="form-group">
                                            <label for="email"><?= i18n("Email")?></label>
                                            <input type="text" class="form-control" name="email" placeholder=<?= i18n("Email")?>><br>
                                        </div>
                                        <div class="form-group">
                                            <label for="pass"><?= i18n("Password")?></label>
                                            <input type="password" name="pass" class="form-control" placeholder=<?= i18n("Password")?>><br>
                                        </div>
                                        <input class="btn" type="submit" value=<?= i18n("Login")?>>
                                    </form>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.php?controller=users&amp;action=register"><?= i18n("New?")?><br><?= i18n("Sign up")?></a>
                                </div>
				</div>
				<?php endif ?>
			</div>
		</nav>

	<main>
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>

		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

	<footer class="fixed-bottom py-3">
		<p class="m-0 text-center text-white">Copyright &copy; Kdamos? 2018	</p>
		<p class="m-0 text-center text-white">
			<?php
				include(__DIR__."/language_select_element.php");
			?>
		</p>
	</footer>

</body>
</html>
