<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $site_name ?></title>

	<link href="<?php echo $base_url.$assets ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo $base_url.$assets ?>css/homepage.css" rel="stylesheet">

</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigationbar">
					<span class="sr-only">Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo $base_url ?>">My Weblog</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navigationbar">
				<ul class="nav navbar-nav navbar-right">
					<?php if($loged): ?>
					<li class="dropdown">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bonjour <?php echo $member->getPseudoName() ?><b class="caret"></b></a>
			          <ul class="dropdown-menu">
			            <li>
			                <div class="row">
			                	<div class="col-md-6 col-md-offset-3">
				                	<div class="form-group">
					                	<img class="img-responsive" src="http://www.gravatar.com/avatar/<?php echo md5($member->getEmail()); ?>" alt="avatar" >
					                </div>
									<div class="form-group">
			                			<a href="<?php echo $base_url ?>account" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-lock"></span> Profil</a>
			               				<a href="<?php echo $base_url ?>account/logout" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a>
			               			</div>
			                	</div>
			                </div>
			            </li>
			           </ul>
			        </li>
					<?php else: ?>

					<li class="dropdown">
						<a href="#register" class="dropdown-toggle" data-toggle="dropdown">Inscription <b class="caret"></b></a>
						<ul class="dropdown-menu" >
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" method="post" action="<?php echo $base_url ?>account/register">
											<div class="form-group">
												<label class="sr-only" for="username">Pseudo</label>
												<input type="text" class="form-control" id="username" name="username" placeholder="Login" required>
											</div>
											<div class="form-group">
												<label class="sr-only" for="email">Adresse mail</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
											</div>
											<div class="form-group">
												<label class="sr-only" for="password">Mot de passe</label>
												<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
											</div>
											<div class="form-group">
												<label class="sr-only" for="password2">Confirmation du mot de passe</label>
												<input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmation du password" required>
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-success btn-block">S'inscrire</button>
											</div>
										</form>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#login" class="dropdown-toggle" data-toggle="dropdown">Connexion <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" method="post" action="<?php echo $base_url ?>account/login">
											<div class="form-group">
												<label class="sr-only" for="username">Pseudo</label>
												<input type="text" class="form-control" id="username2" name="username" placeholder="Pseudo" required>
											</div>
											<div class="form-group">
												<label class="sr-only" for="password">Mot de passe</label>
												<input type="password" class="form-control" id="passwordc" name="password" placeholder="Mot de passe" required>
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-success btn-block">Se connecter</button>
											</div>
										</form>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>