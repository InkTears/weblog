<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>


<div class="container">
    <div class="row">

        <?php include_once(dirname(__FILE__)."/../base/menu-left.php"); ?>


        <div class="col-md-8">

            <?php echo \system\Session::getFlash(); ?>

            <h1>Messages:</h1>
            <hr>
            	<?php if(empty($allContact))
            			echo "<h3>Il n'y a pas de message.</h3>";
            	?>

				<?php foreach ($allContact as $value): ?>
					<div class="message" data-toggle="collapse" data-target="#m<?php echo $value->id_contact ?>">
						<div class="btn-toolbar well well-sm m0">
							<div class="btn-group col-md-3"><a href="#"><?php echo $value->email ?></a></div>
							<div class="btn-group col-md-8">
								<b><a href="#"><?php echo $value->sujet ?></a></b>
								<div class="pull-right">
									<i class="glyphicon glyphicon-time"></i> <?php echo strftime('%d/%m/%Y à %H:%M', strtotime($value->created));?>
									<a href="mailto:<?php echo $value->email ?>" class="btn btn-primary btn-xs">Répondre</a>
									<a href="#" data-id="<?php echo $value->id_contact ?>" class="btn btn-danger btn-xs deletecontact">Supprimer</a>
								</div>
							</div>
						</div>
					</div>
					<div id="m<?php echo $value->id_contact ?>" class="collapse out well well-sm well-transparent"><?php echo $value->message ?></div>
				<?php endforeach ?>


        </div>
    </div>
</div>

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>