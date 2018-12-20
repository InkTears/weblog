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
	                            <h1>401 Page Restricted</h1>
	                      		<a href="<?php echo $base_url ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Accueil</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
			</div>

        </div>
    </div>
</div>


<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>