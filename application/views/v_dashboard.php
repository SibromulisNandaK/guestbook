
<div class="main-content-inner">
    <div class="row row-centered">
        <div class="col-lg-12 mt-5">
            <div class="card dashboard-card">
            <br>
            <h1 class="card-title dashboard-title text-center">Selamat datang, <?php echo $this->session->userdata('nama')?></h1>
            <br>
            <div class="row text-center">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <a href="<?php echo (base_url('index.php/Event/'))?>">
                <div class="card dashboard-cards">

                <img class="card-img-top" src="<?php echo(base_url('assets/images/Acara.png'))?>" alt="Acara">
                    <div class="card-body">

                        <button class="btn btn-primary btn-dashboard" >Acara</button>

                    </div>
                 </div>
                 </a>
                 
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <a href="<?php echo(base_url('index.php/Kunjungan')) ?>">
                <div class="card dashboard-cards">

                <img class="card-img-top" src="<?php echo(base_url('assets/images/Kunjungan.png'))?>" alt="Kunjungan">
                    <div class="card-body">

                    <button class="btn btn-primary btn-dashboard" >Kunjungan</button>

                    </div>
                 </div>
                 </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <a href="<?php echo(base_url('index.php/Undangan/custom_event/'.$id_fs.'/'.'v_tabel_fun_science')) ?>">
                <div class="card dashboard-cards">

                <img class="card-img-top" src="<?php echo(base_url('assets/images/Fun_Science.png'))?>" alt="Fun Science">
                    <div class="card-body">

                    <button class="btn btn-primary btn-dashboard" >Fun Science</button>

                    </div>
                 </div>
                 </a>
            </div>
            </div>            
            </div>
        </div>
    </div>
</div>
