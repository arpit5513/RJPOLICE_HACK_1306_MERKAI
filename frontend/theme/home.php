<?php require_once('../../config.php');?>
<?php include('../inc/navbar.php');?>
<!-- connecting with backend  -->
  
     
 <?php if($_settings->chk_flashdata('success')): ?>
  <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
  </script>
  <?php endif;?>    
 
<div class="container pt-4 mt-5">
        <div class="row justify-content-between">
            <?php if(!isset($_GET['q'])): ?>
                <h1>Welcome to <?php echo $_settings->info('name') ?></h1>
                <?php else: ?>
                    <h1>Search Result for <b>"<?= $_GET['q'] ?>"</b> keyword.</h1>
                    <?php endif; ?>
                    
       
        <div class="col-lg-7">
                    <?php 
                $search = "";
                if(isset($_GET['q'])){
                    $search = " and (title LIKE '%{$_GET['q']}%' OR description LIKE '%{$_GET['q']}%' or (category_id in (SELECT id FROM `category_list` where name LIKE '%{$_GET['q']}%' or  description LIKE '%{$_GET['q']}%' and `status` = 1 )) or (user_id in (SELECT id FROM `users` where CONCAT(firstname,' ',middlename, ' ',lastname) LIKE '%{$_GET['q']}%' or  username LIKE '%{$_GET['q']}%' and `status` = 1 ))) ";
                }
                
                $users_qry = $conn->query("SELECT id,username FROM `users` where id in (SELECT user_id from `magazine_list` where `status` = 1 {$search}) ");
                $user_res = $users_qry->fetch_all(MYSQLI_ASSOC);
                $user_arr = array_column($user_res,'username','id');
                
                $category= $conn->query("SELECT * FROM `category_list` where id in (SELECT category_id from `magazine_list` where `status` = 1 {$search})");
                $category_res = $category->fetch_all(MYSQLI_ASSOC);
                $category_arr = array_column($category_res,'name','id');
                $magazines = $conn->query("SELECT * FROM `magazine_list` where `status` = 1 {$search} order by `id` desc");
                while($row = $magazines->fetch_assoc()):
                    $row['description'] = strip_tags(html_entity_decode($row['description']));
                    $row['banner_path'] = html_entity_decode($row['banner_path']);
            ?>
            
                
                    <div class="card post-item bg-transparent border-0 mb-5">
                        <a href="./?page=view_magazine&id=<?= $row['id'] ?>">
                        <img src="<?= validate_image($row['banner_path']) ?>"  style="width:500px; height: 300px;" alt="Image">
                        </a>
                        <div class="card-body px-0">
                            <h2 class="card-title">
                                <a class="text-white opacity-75-onHover" href="post-details.html"><?= $row['title'] ?></a>
                            </h2>
                            <ul class="post-meta mt-3">
                                <li class="d-inline-block mr-3">
                                    <span class="fas fa-clock text-primary"></span>
                                    <a class="ml-1" href="#"><?= date('Y-m-d H:i',strtotime($row['date_created'])) ?></a>
                                </li>
                                <li class="d-inline-block">
                                    <span class="fas fa-list-alt text-primary"></span>
                                    <a class="ml-1" href="#"><?= ucwords(isset($category_arr[$row['category_id']]) ? $category_arr[$row['category_id']] : "") ?></a>
                                </li>
                                <li class="d-inline-block">
                                    <span class="fas fa-user-alt text-primary"></span>
                                    <a class="ml-1" href="#"><?= isset($user_arr[$row['user_id']]) ? $user_arr[$row['user_id']] : 'N/A' ?></a>
                                </li>
                            </ul>
                            <p class="card-text my-4"><?= substr($row['description'],0,500) ?></p>
                            <a href="./?page=view_magazine&id=<?= $row['id'] ?>" class="btn btn-primary">Read More <img src="images/arrow-right.png" alt=""></a>
                        </div>
                        </div>
                        <?php endwhile; ?>
                <?php if($magazines->num_rows < 1): ?>
                    <center><span class="text-muted">No Magazine Listed Yet.</span></center>
                <?php endif; ?>
                    
                    <!-- end of post-item -->
                    
                
                    <!-- end of post-item -->
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="widget text-center">
                        <img class="author-thumb-sm rounded-circle d-block mx-auto" src="images/author-sm.png" alt="">
                        <h2 class="widget-title text-white d-inline-block mt-4">About us</h2>
                        <p class="mt-4">Lorem ipsum dolor sit coectetur adiing elit. Tincidunfywjt leo mi, viearra urna. Arcu ve isus, condimentum ut vulpate cursus por turpis.</p>
                        <ul class="list-inline mt-3">
                            <li class="list-inline-item">
                                <a href="#!" class="text-white text-primary-onHover p-2">
                                    <span class="fab fa-twitter"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!" class="text-white text-primary-onHover p-2">
                                    <span class="fab fa-facebook-f"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!" class="text-white text-primary-onHover p-2">
                                    <span class="fab fa-instagram"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!" class="text-white text-primary-onHover p-2">
                                    <span class="fab fa-linkedin-in"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end of author-widget -->

                    <div class="widget bg-dark p-4 text-center">
                        <h2 class="widget-title text-white d-inline-block mt-4">Subscribe Blog</h2>
                        <p class="mt-4">For new and daily  Journal .</p>
                        <form action="#">
                            <div class="form-group">
                                <input type="email" class="form-control bg-transparent rounded-0 my-4" placeholder="Your Email Address">
                                <button class="btn btn-primary">Subscribe Now <img src="images/arrow-right.png" alt=""></button>
                            </div>
                        </form>
                    </div>
                    <!-- end of subscription-widget -->

                    <div class="widget">
                    <div class="mb-5 text-center">
                            <h2 class="widget-title text-white d-inline-block">Index</h2>
                        </div>
                    <?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `indexing`order by `id` desc ");
						while($row = $qry->fetch_assoc()):
						
					?>
                        
                        
                        <div class="card post-item bg-transparent border-0 mb-5">
                        
                            <a href="post-details.html">
                                <img class="card-img-top rounded-0"  src="<?= validate_image($row['banner_path']) ?>" alt="">
                            </a>
                            
                            <?php endwhile;?>
                        </div>
                        </div>
                        <!-- end of widget-post-item -->
                        <div class="card post-item bg-transparent border-0 mb-5">
                            <a href="post-details.html">
                                <img class="card-img-top rounded-0" src="images/post/post-sm/02.png" alt="">
                            </a>
                            <div class="card-body px-0">
                                <h2 class="card-title">
                                    <a class="text-white opacity-75-onHover" href="post-details.html">Excepteur ado Do minimal duis laborum Fugiat ea</a>
                                </h2>
                                <ul class="post-meta mt-3 mb-4">
                                    <li class="d-inline-block mr-3">
                                        <span class="fas fa-clock text-primary"></span>
                                        <a class="ml-1" href="#">24 April, 2016</a>
                                    </li>
                                    <li class="d-inline-block">
                                        <span class="fas fa-list-alt text-primary"></span>
                                        <a class="ml-1" href="#">Photography</a>
                                    </li>
                                </ul>
                                <a href="post-details.html" class="btn btn-primary">Read More <img src="images/arrow-right.png" alt=""></a>
                            </div>
                        </div>
                        <!-- end of widget-post-item -->
                    </div>
                    <!-- end of post-items widget -->
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
