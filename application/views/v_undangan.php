
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- autocomplete -->
<script>
  $( function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#nama" );
      $( "#nama" ).scrollTop( 0 );
    }
 
    $( "#nama" ).autocomplete({
      source: "<?php echo base_url('index.php/Undangan/get_autocomplete')?>",
      minLength: 2,
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
<!-- multiinsert -->
<script type="text/javascript">
    $(document).ready(function() {
        $(".add-more").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
      
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
         });
    });
</script>
<!-- tabel -->
<script>
    $(document).ready( function () {
    $('#TabelUndangan').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Detail '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
		"language": {
            "lengthMenu": "Menampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data",
            "info": "Halaman ke _PAGE_ dari _PAGES_",
			"search":         "Cari:",
			"thousands":	".",
            "infoEmpty": "Tidak ada data",
            "infoFiltered": "(ditemukan dari _MAX_ data)",
			"paginate": {
        "first":      "Pertama",
        "last":       "Terakhir",
        "next":       "Selanjutnya",
        "previous":   "Sebelumnya"
    }
        },
        "columnDefs": [
        { "orderable": false, "targets": [3] },
        { "searchable": false, "targets":[3] }
    ]
    });
    } );
</script>
<!-- tambah pts -->
<script type="text/javascript">
    function tambah_tps(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal-tps').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Undangan'); // Set Title to Bootstrap modal title
    }
</script>
<!-- select2 -->
<script>
    $(document).ready(function() { $("#id_karyawan").select2(); });
</script>
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card">
            <!-- <a href="#tambah" class="btn btn-dark" data-toggle="modal" onclick="tambah_tps()">Tambah Undangan</a> -->
                <div class="card-body">
                <h3 class="card-title">
                    Daftar Undangan
                    <?php foreach($judul_acara as $judul): ?>
                    <?= $judul->nama_event ?>
                    <?php endforeach;?></h3>
                <hr class="style1 garis">                
                <?php if($this->session->flashdata('pesan')!=null): ?>
                    <div class= "alert alert-success alert-dismissible fade show" role="alert"><?= $this->session->flashdata('pesan');?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
                <?php endif?>
                <?php if($this->session->flashdata('gagal')!=null): ?>
                    <div class= "alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('gagal');?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>
                <?php endif?>
                    <?php $function_cont = $this->uri->segment(2);?>
                    <?php $url = $this->uri->segment(3); ?>
                <a href="#scan_qr" data-toggle="modal" class="btn btn-dark" style="margin-bottom:20px;"><i class="fas fa-qrcode"></i><span style="margin-left:3px;">Scan QR Code</a>
                <a href="#tambah_internal" data-toggle="modal" class="btn btn-primary" style="margin-bottom:20px;"><i class="fas fa-plus"></i><span style="margin-left:3px;">Tambah Undangan Internal</a>
                <a href="#tambah_eksternal" data-toggle="modal" class="btn btn-warning" style="margin-bottom:20px;"><i class="fas fa-plus"></i><span style="margin-left:3px;">Tambah Undangan Eksternal</a>
                <table class="table table-hover" id="TabelUndangan" style="width:100%;">
			    <thead class="thead-light">
					<tr> 
                        <th style="width:10px">No</th>
                        <th>Nama Undangan</th>
                        <th>Jenis Tamu</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
					</tr>
				</thead>
				<tbody>
                    <?php $no=1; ?>
                    <?php 
                    foreach ($isi_tabel as $isi) : ?>
                    <?php $url = $this->uri->segment(3); ?>
                    <tr id="<?php echo $isi->id_undangan?>">
				        <td>
        		            <?= $no++ ?>
		        		</td>
                        <td>
                            <?php echo ($isi->nama_tamu)? $isi->nama_tamu: $isi->nama_karyawan ?>
                        </td>
                        <td>
                            <?php echo ($isi->jenis_tamu) ?>
                        </td>
                        <td>
                            <?php if($isi->status_kehadiran =="Belum Hadir"){?>
                                <a href="<?php echo base_url().'index.php/Undangan/sudah_hadir/'.$isi->id_undangan.'/'.$function_cont.'/'.$url?>" class="btn btn-warning btn-undangan">  <?= $isi->status_kehadiran?> </a>
                            <?php } ?>
                            <?php if($isi->status_kehadiran =="Sudah Hadir"){?>
                            <a href="<?php echo base_url().'index.php/Undangan/belum_hadir/'.$isi->id_undangan.'/'.$function_cont.'/'.$url?>" class="btn btn-success btn-undangan"><?= $isi->status_kehadiran ?></a>
                            <?php }?>
                        </td>
                        <!-- <td>-</td> -->
                        <td>
                            <div class="btn-group"  role="group" aria-label="Basic example">
                            <a id=""href="<?php echo base_url().'index.php/Undangan/hapus_undangan/'.$isi->id_undangan.'/'.$function_cont.'/'.$url ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                            <?php if($isi->status_kehadiran =="Belum Hadir"){?>
                            <a href="<?php echo base_url('index.php/Undangan/undangan_email/'.$isi->id_undangan.'/'.$function_cont.'/'.$url) ?>" class="btn btn-dark"><i class="fas fa-envelope"></i><span style="margin-left:3px;"></a>
                            <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
	        	</tbody>
		    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="scan_qr" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Scan QR</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body text-center">
                    
            <video id="webscan" style="width:100%;"></video>
            <script type="text/javascript">
            let scanner = new Instascan.Scanner({ video: document.getElementById('webscan') });
            scanner.addListener('scan', function (content) {
                var url = '<?php echo base_url().'index.php/Undangan/sudah_hadir/'?>'+content+'/<?php echo $function_cont."/".$url?>';
                window.location.replace(url);
            });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                scanner.start(cameras[0]);
                } else {
                alert('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
            </script>
            

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_eksternal" data-keyboard="false" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah undangan eksternal</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">

                <?php $url = $this->uri->segment(3); ?>
                <form action="<?=base_url('index.php/Undangan/tambah_undangan'.'/'.$url.'/'.$function_cont)?>" method="POST">
                    <input type="hidden" name="id_tamu" id="id_tamu">
                    <div class="form-group ui-widget"> 
                                        <!-- <label for="example-text-input" class="col-form-label">Nama</label> -->
                        <input class="form-control oi" type="text" placeholder="Nama lengkap" id="nama" name="nama">
                                        <!-- <input id="nama" type="text" class="form-control" onchange="autofill(this.value)" class="daftar_tamu" placeholder="Nama tamu" name="nama" style="width: 100%;"> -->
                    </div>
                    <div class="form-group">
                                       <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                        <input class="form-control" type="email" placeholder="Alamat email" id="email" name="email">
                    </div>
                    <div class="form-group" >
                        <input class="form-control" type="number" placeholder="No Telepon" id="no_telepon" name="no_telepon">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                                       <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                        <input class="form-control" type="text" placeholder="Keterangan" id="keterangan" name="keterangan">
                    </div>
                    
                    <div class="form-group">
                        <input class="" type="checkbox" name="kirim_eks" value="kirim_eks" id="kirim_eks"><span style="margin-left:8px;">Kirim undangan</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>                            
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_internal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah undangan internal</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <?php $url = $this->uri->segment(3); ?>
                <form action="<?=base_url('index.php/Undangan/tambah_undangan_internal'.'/'.$url.'/'.$function_cont)?>" method="POST">
                    <div class="form-group">
                    <select class="form-control js-example-basic-single style="margin-left:8px;" name="id_karyawan" id="id_karyawan" style="width:100%; " >
                                            <option value="" disabled selected>Nama karyawan</option>
                                            <?php foreach ($get_karya as $row) {  
		                                    echo "<option value='".$row->id_karyawan."'>".$row->nama."</option>";
		                                    }
                                        echo"</select>"?>
                    </div>
                    <div class="form-group">
                        <input class="" type="checkbox" name="kirim_in" value="kirim_in" id="kirim_in"><span style="margin-left:8px;">Kirim undangan</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>                            
                </form>
            </div>
        </div>
    </div>
</div>