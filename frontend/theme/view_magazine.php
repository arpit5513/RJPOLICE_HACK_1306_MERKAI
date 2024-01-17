<?php include('../inc/navbar.php');?>

<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `magazine_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
    $user_qry = $conn->query("SELECT username,id,avatar FROM `users` where id = '{$user_id}' ");
    if($user_qry->num_rows > 0){
        $user_arr  = $user_qry->fetch_array();
    }
}
?>
<!-- end of mobile-nav -->
        <div class="container py-4 my-5">
            <div class="row">
    <div class="col-lg-5 col-md-8">
        <form class="search-form" action="#">
            <div class="input-group">
                <input type="search" class="form-control bg-transparent shadow-none rounded-0" placeholder="Search here">
                <div class="input-group-append">
                    <button class="btn" type="submit">
                        <span class="fas fa-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
            <div class="row">
                <div class="col-md-9">
                    <img class="img-fluid" src="<?= validate_image(isset($banner_path) ? $banner_path : "") ?>" alt="img">
                    <h1 class="text-white add-letter-space my-4"><?= isset($title) ? $title : "" ?></h1>
                    <h2 class="text-white add-letter-space my-5"><?= isset($description) ? html_entity_decode($description) : "" ?></h2>
                    <iframe src="<?= isset($pdf_path) ? base_url.$pdf_path : '' ?>" frameborder="1" class="w-100 h-100 bg-dark"></iframe>
                    
                </div>
            </div>
        </div>

        <!-- start of footer -->
<footer class="bg-dark">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-sm-6 mb-5">
                <h5 class="font-primary text-white mb-4">Inspirations</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Privacy State</a></li>
                    <li><a href="#!">Privacy</a></li>
                    <li><a href="#!">State</a></li>
                    <li><a href="#!">Privacy</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6 mb-5">
                <h5 class="font-primary text-white mb-4">Templates</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Privacy State</a></li>
                    <li><a href="#!">Privacy</a></li>
                    <li><a href="#!">State</a></li>
                    <li><a href="#!">Privacy</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6 mb-5">
                <h5 class="font-primary text-white mb-4">Resource</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Privacy State</a></li>
                    <li><a href="#!">Privacy</a></li>
                    <li><a href="#!">State</a></li>
                    <li><a href="#!">Privacy</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6 mb-5">
                <h5 class="font-primary text-white mb-4">Company</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Privacy State</a></li>
                    <li><a href="#!">Privacy</a></li>
                    <li><a href="#!">State</a></li>
                    <li><a href="#!">Privacy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- end of footer -->
    </div>

    </section>
    <!-- END main-wrapper -->

    <!-- All JS Files -->
    <script src="plugins/jQuery/jquery.min.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>

    <!-- Main Script -->
    <script src="js/script.js"></script>
</body>
</html>
