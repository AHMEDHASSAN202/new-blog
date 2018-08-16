        <!-- Footer -->
        <footer>
            <strong class="d-inline-block mt-1">Copyright <span class="fa fa-copyright"></span> 2018 <a class="color" href="#">Ahmed HaSSan</a> </strong><small>. All Right Reserved</small>
        </footer>
        <!-- #END# footer -->
        </div>
        <!-- #END# content wrapper -->
        </div>
        <!-- #END# wrapper -->
        <script src="<?php echo pluginsAssets('jquery-3.2.1/jquery-3.2.1.min.js') ?>"></script>
        <script src="<?php echo pluginsAssets('popper/popper.js') ?>"></script>
        <script src="<?php echo pluginsAssets('bootstrap-4.0.0/dist/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo adminAssets('js/main.js'); ?>"></script>
        <?php if(!empty($js)) : ?>
          <?php foreach ($js as $jsFile) : ?>
            <script src="<?php echo $jsFile; ?>"></script>
          <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>