			<div class="col-md-3">
				<div class="list-group">
					<a href="<?php echo $base_url ?>blog" class="list-group-item">Accueil</a>
					<a href="<?php echo $base_url ?>blog/contact" class="list-group-item">Contact</a>
					<?php if($loged && $member->getAdmin() > 0): ?>
					<ul class="list-unstyled list-group-item">
						<li>
							<a href="#" data-toggle="collapse" data-target="#userMenu">Administration <i class="glyphicon glyphicon-chevron-down"></i></a>
							<ul class="list-unstyled collapse" id="userMenu">
								<li><a href="<?php echo $base_url ?>admin/messages"><i class="glyphicon glyphicon-envelope"></i> Messages <span class="badge badge-info"><?php echo \application\models\Contact::counts(); ?></span></a></li>
								<li><a href="<?php echo $base_url ?>admin/users"><i class="glyphicon glyphicon-user"></i> Liste des utilisateurs</a></li>
								<li><a href="<?php echo $base_url ?>admin/articles"><i class="glyphicon glyphicon glyphicon-list-alt"></i> Liste des billets</a></li>
							</ul>
						</li>
					</ul>
				    <?php endif; ?>
				</div>



				<div class="well">
					<h4>Rechercher sur le blog</h4>
					<div class="input-group">
						<input type="text" class="form-control" id="searchbillet">
						<input type="hidden" class="form-control" id="baseurl" value="<?php echo $base_url ?>blog/search/">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="search">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
					<!-- /input-group -->
				</div>

				<div class="well">
					<h4>Categories</h4>
					<div class="row">
						<div class="col-lg-6">
							<ul class="list-unstyled">
								<li><a href="<?php echo $base_url ?>blog/tag/php">Art</a></li>
								<li><a href="<?php echo $base_url ?>blog/tag/html">Voyages</a></li>
								<li><a href="<?php echo $base_url ?>blog/tag/css">Animaux</a></li>
							</ul>
						</div>
						<div class="col-lg-6">
							<ul class="list-unstyled">
								<li><a href="<?php echo $base_url ?>blog/tag/sql">Nature</a></li>
								<li><a href="<?php echo $base_url ?>blog/tag/javascript">Nourriture</a></li>
								<li><a href="<?php echo $base_url ?>blog/tag/autres">Développement</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>