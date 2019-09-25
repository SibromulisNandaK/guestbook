<script>
  $( function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#nama" );
      $( "#nama" ).scrollTop( 0 );
    }
 
    $( "#nama" ).autocomplete({
      source: "<?php echo base_url('index.php/Kunjungan/get_autocomplete/')?>",
      minLength: 1,
      select: function( event, ui ) {
        //alert( "Selected: " + ui.item.value + " aka " + ui.item.id );
        console.log(ui);
        document.getElementById('id_tamu').value=ui.item.attribut.id_tamu;
        document.getElementById('email').value=ui.item.attribut.email;
        document.getElementById('no_telepon').value=ui.item.attribut.no_telepon;
        document.getElementById('jenis_kelamin').value=ui.item.attribut.jenis_kelamin;
        document.getElementById('keterangan').value=ui.item.attribut.keterangan;

      }
    });
  } );
</script>
<!-- autofill -->
<!-- select2 -->

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script> -->
<script>
    $(document).ready(function() { $("#tujuan").select2(); });
</script>
<!-- TABEL -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-area">
                        <h2 class="header text-center" >Buku Tamu</h2>
                        <p class="text-muted font-14 mb-4 text-center">Harap melakukan pengisian form dengan benar</p>
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
                    </div><br>
                        
                                <form action="<?=base_url('index.php/Kunjungan/simpan_kunjungan')?>" method="POST" >
                                    <input type="hidden" name="id_tamu" id="id_tamu">
                                    <div class="form-group ui-widget"> 
                                        <!-- <label for="example-text-input" class="col-form-label">Nama</label> -->
                                        <input class="js-example-basic-single form-control" type="text" placeholder="Nama Pengunjung" id="nama" name="nama">
                                        <!-- <input id="nama" type="text" class="form-control" onchange="autofill(this.value)" class="daftar_tamu" placeholder="Nama tamu" name="nama" style="width: 100%;"> -->
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                                        <input class="form-control" type="email" placeholder="Alamat Email" id="email" name="email">
                                    </div>
                                    <div class="form-group" >
                                        <!-- <label for="example-email-input" class="col-form-label">Email</label> -->
                                        <input class="form-control" type="number" placeholder="No Telepon" id="no_telepon" name="no_telepon">
                                    </div>
                                    <div class="form-group">
                                        <!-- <label class="col-form-label">Select</label> -->
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="" disabled selected>Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="example-tel-input" class="col-form-label">Telephone</label> -->
                                        <input class="form-control" type="text" placeholder="Asal Instansi" id="keterangan" name="keterangan">
                                    </div> 
                                    <div class="form-group">
                                        <select class="form-control js-example-basic-single tujuh" name="id_karyawan" id="tujuan" style="width:100%; " >
                                            <option value="" disabled selected>Tujuan</option>
                                            <?php foreach ($get_karya as $row) {  
		                                    echo "<option value='".$row->id_karyawan."'>".$row->nama."</option>";
		                                    }
                                        echo"</select>"?>
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="inputPassword" class="">Password</label> -->
                                        <input type="text" class="form-control" id="keperluan" placeholder="Keperluan" name="keperluan">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                    </div>                            
                            </form>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>