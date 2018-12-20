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
                            <h1>Contactez nous</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="well well-sm">
                <form action="#" method="POST" name="contact">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <p>Nous vous rappelons que si vous ne mettez pas d'adresse mail valide, nous ne pourrons pas vous répondre.</p>
                            <label for="emailc">Addresse mail</label><br>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input type="email" class="form-control" id="emailc" name="emailc" placeholder="Entrer votre adresse mail" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Sujet</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Entrer un sujet" required="required" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="5" cols="25" required="required" placeholder="Entrer votre message"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">Envoyer le message</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once(dirname(__FILE__)."/../base/footer.php"); ?>