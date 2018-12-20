    <div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Richard, Egor, Estelle Samsung Campus 2017</p>
                </div>
            </div>
        </footer>

    </div>

    <?php if($environment == 'development'): ?>
        <pre>debug:</pre>
        <pre><?php print_r($this); ?></pre>
    <?php endif; ?>
    <!-- /.container -->

    <!-- JavaScript -->
    <script>$base_url = "<?php echo $base_url ?>";</script>
    <script src="<?php echo $base_url.$assets ?>js/jquery.min.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/bootstrap.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/main.js"></script>
</body>

</html>
