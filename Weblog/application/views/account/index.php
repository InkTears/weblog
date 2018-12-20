<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>


<div class="container">
	<div class="row">

		<?php include_once(dirname(__FILE__)."/../base/menu-left.php"); ?>


		<div class="col-md-8">

			<?php echo \system\Session::getFlash(); ?>

			<div class="jumbotron jumbotron-sm">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-lg-12">
							<h1>Profil <a href="https://fr.gravatar.com/" target="_bank"><img src="http://www.gravatar.com/avatar/<?php echo md5($member->getEmail()); ?>" class="pull-right" alt="avatar"></a></h1>
							<span class="text-muted">Utilisez un mail <a href="https://fr.gravatar.com/" target="_bank">gravatar</a> pour changer d'avatar.</span>
						</div>
					</div>
				</div>
			</div>

			  <!-- edit form column -->
			  <div class="personal-info">

				<?php echo \system\Session::getFlash(); ?>

				<form class="form-horizontal" role="form" method="POST" action="#">
					<div class="form-group">
						<label class="col-lg-3 control-label">Nom:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="nom" value="<?php echo $member->getNom() ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Prénom:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="prenom" value="<?php echo $member->getPrenom() ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Adresse mail:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="email" value="<?php echo $member->getEmail() ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mot de passe:</label>
						<div class="col-md-8">
							<input class="form-control" type="password" name="epassword1" value="" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Confirmer le mot de passe:</label>
						<div class="col-md-8">
							<input class="form-control" type="password" name="epassword2" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-8">
							<input type="submit" class="btn btn-primary" value="Save Changes">
							<input type="reset" class="btn btn-default" value="Cancel">
						</div>
					</div>
				</form>
			</div>



		</div>
	</div>
</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>