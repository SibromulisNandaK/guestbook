<?php if($this->session->userdata('logged_in') == TRUE){?>
<!doctype html>
<html class="no-js" lang="en">

<head>
<meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $this->uri->segment(1); ?> | Buku Tamu Republika</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/images/title.png">
    <!-- <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/images/icon/favicon.ico"> -->
    <script src="<?php echo base_url() ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
    <script src="<?php echo base_url()?>assets/js/instascan.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="<?php echo base_url()?>assets/fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/DataTables/datatables.css"/>
    <script type="text/javascript" src="<?php echo base_url()?>assets/DataTables/datatables.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
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
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <img style="" src="<?php echo base_url() ?>assets/images/logodark.png" alt="logo">
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                        <?php $menu = $this->M_login->menu();
                        
					 foreach($menu as $sidenav)
					 {
						echo '<li><a href="'.site_url($sidenav['link_relasi']).'">'. $sidenav['nama_menu'].'</a></li>';
					 }
					  ?>
                            <!-- <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Acara</span></a>
                                <ul class="collapse">
                                    <li><a href="index.html">Left Sidebar</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <!-- header area end -->
            <!-- <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div> -->
            <!-- page title area start -->
            <div class="page-title-area">
                    <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                    </div>
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Guest Book</h4>

                        </div>
                    
                        <div class="user-profile float-right">
                            <img class="avatar user-thumb" src="<?php echo base_url() ?>assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><span class="nama"><?php echo$this->session->userdata('nama')?></span> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url()?>index.php/login/logout">Log Out</a>
                            </div>
                        </div>
            </div>
            <!-- page title area end -->
            <?php $this->load->view($content);?>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    
    <!-- offset area end -->
    <!-- jquery latest version -->

    
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.slicknav.min.js"></script>
    <!-- others plugins -->
    <script src="<?php echo base_url() ?>assets/js/plugins.js"></script>
    <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
    
    

</body>

</html>
<?php } 
 else {
    { redirect(base_url('index.php/Login'), 'refresh');}
}
?>