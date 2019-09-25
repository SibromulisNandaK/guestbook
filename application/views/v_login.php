<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Buku Tamu | Republika</title>
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/title.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/metisMenu.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/typography.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/default-css.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?= base_url() ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="<?= base_url('index.php/login/cek_login')?>" method="post">
                    <div class="login-form-head">
                        <!-- <h4>Sign In</h4> -->
                        <img src="<?= base_url() ?>assets/images/REPUBLIKA.png" alt="" style="height: 40px;">
                        <p class="" style="color: white;">Hi! Selamat datang.</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Alamat Email</label>
                            <input type="email" name="email" id="email">
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                            <i class="ti-lock"></i>
                        </div><br>
                        <?php if($this->session->flashdata('pesan')!=null): ?>
                        <div class= "alert alert-success alert-dismissible fade show" role="alert"><?= $this->session->flashdata('pesan');?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif?>
                        <?php if($this->session->flashdata('gagal')!=null): ?>
                        <div class= "alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('gagal');?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif?>
                        <div class="submit-btn-area">
                            <button type="submit">Submit</i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p>Guest Book | Republika </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?= base_url() ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>assets/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?= base_url() ?>assets/js/plugins.js"></script>
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
</body>

</html>