<?php include_once(dirname(__FILE__)."/../base/header.php"); ?>

        <div class="container">

        <div class="row">


            <?php include_once(dirname(__FILE__)."/../base/menu-left.php"); ?>


            <div class="col-md-9">

                <?php echo \system\Session::getFlash(); ?>

                <div class="jumbotron jumbotron-sm">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <h1>Derniers articles</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <?php foreach (isset($allBillet)? $allBillet : array() as $value): ?>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="<?php echo $value->image ?>" alt="<?php echo $value->title ?>">
                                <div class="caption">
                                    <h4><a href="<?php echo $base_url.'blog/article/'.$value->id_billet ?>"><?php echo $value->title ?></a></h4>
                                    <p><?php echo \system\helper\String::truncate(\system\helper\String::stripBBCode($value->content), 0, 100, $base_url."blog/article/".$value->id_billet) ?></p>
                                </div>
                                <div class="ratings">
                                    <p class="pull-right"><?php echo $value->count ?> Commentaires</p>
                                    <p><?php echo \system\helper\String::tagUrl($value->categorie, ',', $base_url.'blog/categorie/') ?></p>
                                </div>
                            </div>
                        </div>
                    <?php  endforeach; ?>

                </div>

                <div class="text-center">
                        <?php echo $pagination ?>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>