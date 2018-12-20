<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>


<div class="container">
	<div class="row">

		<?php include_once(dirname(__FILE__)."/../base/menu-left.php"); ?>


		<div class="col-md-8">

			<?php echo \system\Session::getFlash(); ?>

			<form class="form-horizontal well" role="form" method="POST" action="<?php echo $base_url ?>admin/add_user" id="adduser">
					<h4>Nouveau utilisateur:</h4>
					<div class="form-group">
						<label class="col-lg-3 control-label">Pseudo:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="username" id="username">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Nom:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="nom" id="nom">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Prénom:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="prenom" id="prenom">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">Adresse mail:</label>
						<div class="col-lg-8">
							<input class="form-control" type="text" name="email" id="email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Rang:</label>
						<div class="col-md-8">
						<select name="level" id="level" class="form-control">
							<option value="0">Membre</option>
							<option value="1">Auteur</option>
							<?php if($member->getAdmin() > 1): ?>
								<option value="99">Administrateur</option>
							<?php endif; ?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mot de passe:</label>
						<div class="col-md-8">
							<input class="form-control" id="password" type="password" name="password" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"></label>
						<div class="col-md-8">
							<input type="submit" class="btn btn-primary" value="Save Changes">
							<input type="hidden" id="action" name="action" value="add" >
							<input type="hidden" id="id_user" name="id_user" value="0" >
							<input type="hidden" id="password2" name="password2" value="0" >
						</div>
					</div>
				</form>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Liste des membres
						<a href="#" id="adduserbutton"><span class="glyphicon glyphicon-plus pull-right"></span></a>
					</h4>
				</div>

				<ul class="list-group" id="contact-list">
					<?php foreach ($allMembre as $value): ?>
						<li class="list-group-item user">
							<div class="col-xs-12 col-sm-2">
								<img src="http://www.gravatar.com/avatar/<?php echo md5($value->email); ?>" alt="Rosemary Porter" class="img-responsive img-circle">
							</div>
							<div class="col-xs-12 col-sm-10">
								<span class="text-danger pull-right" title="level"><?php echo $value->admin ?></span>
								<span class="name"><?php echo $value->username ?></span><br>
								<span class="text-muted"><?php echo $value->email ?></span><br>
								<span class="text-muted"><?php echo $value->nom ?></span><br>
								<span class="text-muted"><?php echo $value->prenom ?></span>
							</div>
							<div class="pull-right">
								<button type="button" class="btn btn-primary btn-xs editmembre" title="Edit" data-level="<?php echo $value->admin ?>" data-id="<?php echo $value->id_user ?>">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>
								<button type="button" class="btn btn-danger btn-xs deletemembre" title="Delete" data-level="<?php echo $value->admin ?>" data-id="<?php echo $value->id_user ?>">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</div>
							<div class="clearfix"></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="text-center">
					<?php echo $pagination ?>
				</div>
			</div>


		</div>
	</div>
</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>