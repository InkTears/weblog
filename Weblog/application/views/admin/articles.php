<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>


<div class="container">
	<div class="row">

		<?php include_once(dirname(__FILE__)."/../base/menu-left.php"); ?>


		<div class="col-md-8">

			<?php echo \system\Session::getFlash(); ?>

			<div class="well" id="addpost">
				<h4>Nouveau billet:</h4>

				<form action="<?php echo $base_url ?>admin/add_articles" role="form" method="post" id="formadmin">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Titre*:</label>
						<div class="col-sm-10">
							<input type="text" name="title" placeholder="100 charactères maximum" id="title" required>
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Chapô*:</label>
						<div class="col-sm-10">
							<input type="text" name="chapo" placeholder="500 charactères maximum" id="chapo" required >
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Image:</label>
						<div class="col-sm-10">
							<input type="text" id="image" name="image" placeholder="URL de votre image">
						</div>
					</div>
					<div class="form-group">
						<label for="select" class="col-sm-2 control-label">Catégorie:</label>
						<div class="col-sm-10">
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox1" name="php" value="1"> Arts
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox2" name="html" value="2"> Voyages
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox3" name="css" value="3"> Animaux
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox4" name="sql" value="4"> Nature
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox5" name="javascript" value="5"> Nourriture
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="inlineCheckbox6" name="autres" value="6"> Développement
							</label>
						</div>
					</div>
					<div class="btn-group" id="bbcode_bb_bar">
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="b">
							Gras
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="i">
							Italique
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="u">
							Sous-ligné
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="img">
							Image
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="url">
							Lien
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="code">
							Code
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="youtube">
							Youtube
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="p">
							P
						</button>
						<button type="button" class="btn btn-default" data-toggle="tooltip" title="" id="br">
							BR
						</button>
					</div>
					<div class="form-group">
						<label for="select" class="col-sm-2 control-label">Contenu*:</label>
						<textarea id="editor" class="form-control" rows="3" name="content" placeholder="Entrez le contenu de votre billet..." required></textarea>
					</div>
					<input type="hidden" id="action" name="action" value="add" >
					<input type="hidden" id="id_billet" name="id_billet" value="0" >
					<button type="submit" class="btn btn-primary">Envoyer</button>
				</form>
				<p>* Champs obligatoire</p>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Liste des billets
						<a href="#" id="addpostform"><span class="glyphicon glyphicon-plus pull-right"></span></a>
					</h4>
				</div>

				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Auteur</th>
							<th>Titre</th>
							<th>Chapo</th>
							<th></th>
							<th>Contenu</th>
							<th>Catégorie</th>
							<th>Date de publication<th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($allBillet as $value): ?>
							<tr class="billet">
								<td><?php echo $value->id_billet ?></td>
								<td><?php echo $value->login ?></td>
								<td><?php echo $value->title ?></td>
								<td><?php echo $value->chapo ?><td>
								<td><?php echo \system\helper\String::truncate(\system\helper\String::stripBBCode($value->content), 0, 100, "#", "") ?></td>
								<td><?php echo $value->categorie ?></td>
								<td><?php echo $value->created ?></td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editbillet" title="Edit" data-id="<?php echo $value->id_billet ?>">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
									<button type="button" class="btn btn-danger btn-xs deletebillet" title="Delete" data-id="<?php echo $value->id_billet ?>">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>

				<div class="text-center">
					<?php echo $pagination ?>
				</div>

			</div>


		</div>
	</div>
</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>