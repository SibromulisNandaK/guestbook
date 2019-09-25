<!-- SCRIPT AUTOCOMPLETE -->
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
<!-- ISI TABLE -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Peserta Fun Science</h3>
                    <hr class="style1 garis">
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
                    <a href="#tambah" data-toggle="modal" class="btn btn-primary" style="margin-bottom:20px;"><i class="fas fa-plus"></i><span style="margin-left:3px;">Tambah Peserta</a>
                    <a href="#scan_qr" data-toggle="modal" class="btn btn-dark" style="margin-bottom:20px;"><i class="fas fa-qrcode"></i><span style="margin-left:3px;">Scan QR Code</a>

                    <?php
                        $function_cont = $this->uri->segment(2);
                        $url = $this->uri->segment(3);
                    ?>
                    <!-- <div class="data-tables datatable-dark"> -->
                        <table class="table table-hover" id="TabelFunScience" style="width:100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                    <th>Asal Sekolah</th>
                                    <th>Nama Orang Tua</th>
                                    <th>Email</th>
                                    <th>No Telepon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Status Kehadiran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($isi_tabel as $isi):?>
                                <tr id="<?php echo $isi->id_undangan?>">

                                    <td><?php echo $no; $no++;?></td>
                                    <td><?= $isi->nama?></td>
                                    <td><?= $isi->keterangan?></td>
                                    <td><?= $isi->opsi1?></td>  
                                    <td><?= $isi->email ?></td>
                                    <td><?= $isi->no_telepon?></td>
                                    <td><?= $isi->jenis_kelamin?></td>
                                    <td><?= $isi->opsi2?></td>
                                    <td>
                                    <?php if($isi->status_kehadiran =="Belum Hadir"){ 
                                        ?>
                                    <a href="<?php echo base_url().'index.php/Undangan/sudah_hadir/'.$isi->id_undangan.'/'.$function_cont.'/'.$url?>" class="btn btn-warning btn-undangan">  <?= $isi->status_kehadiran?> </a>
                                    <?php } ?>
                                    <?php if($isi->status_kehadiran =="Sudah Hadir"){?>
                                    <a href="<?php echo base_url().'index.php/Undangan/belum_hadir/'.$isi->id_undangan.'/'.$function_cont.'/'.$url?>" class="btn btn-success btn-undangan"><?= $isi->status_kehadiran ?></a>
                                    <?php }?>
                                    </td>
                                    <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="<?php echo base_url().'index.php/Undangan/hapus_undangan/'.$isi->id_undangan.'/'.$function_cont.'/'.$url?>" onclick="return confirm('Anda yakin akan menghapus undangan ini?');" class="btn btn-danger" title="Hapus Peserta"><i class="fas fa-trash-alt"></i></a>
                                        <a href="#update" data-toggle="modal" data-dismiss="modal" onclick="tm_detail('<?php echo ($isi->id_undangan)?>')" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <?php if($isi->status_kehadiran =="Sudah Hadir"){?>
                                        <a href="<?php echo base_url().'index.php/Undangan/cetak_sertifikat/'.$isi->id_undangan?>"  class="btn btn-dark" title="Download Sertifikat"><i class="fas fa-download"></i></a>
                                        <?php } else {?>
                                            <a href="<?php echo base_url('index.php/Undangan/undangan_email/'.$isi->id_undangan.'/'.$function_cont.'/'.$url) ?>" class="btn btn-dark"><i class="fas fa-envelope"></i><span style="margin-left:3px;"></a>
                                        <?php } ?>
                                    </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
	            	    </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- scanqr -->
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
 <!-- opsi1 = nama ortu  -->
 <!-- opsi2 = alamat -->
<div class="modal fade" id="tambah" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah undangan</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <?php $url = $this->uri->segment(3); 
                        $function_cont = $this->uri->segment(2);?>
                <form action="<?=base_url('index.php/Undangan/tambah_peserta_khusus/'.$url.'/'.$function_cont)?>" method="POST">
                    <input type="hidden" name="id_tamu" id="id_tamu">
                    <input type="hidden" name="id_undangan" id="id_undangan">
                    <div class="form-group ui-widget"> 
                                        <!-- <label for="example-text-input" class="col-form-label">Nama</label> -->
                        <input class="js-example-basic-single form-control ac" type="text" placeholder="Nama peserta" id="nama" name="nama">
                                        <!-- <input id="nama" type="text" class="form-control" onchange="autofill(this.value)" class="daftar_tamu" placeholder="Nama tamu" name="nama" style="width: 100%;"> -->
                    </div>
                    <div class="form-group">
                                       <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                        <input class="form-control" type="text" placeholder="Asal sekolah" id="keterangan" name="keterangan">
                    </div>
                    <div class="form-group">
                                       <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                        <input class="form-control" type="email" placeholder="Alamat Email" id="email" name="email">
                    </div>
                    
                    <div class="form-group">
                                       <!-- <label for="example-search-input" class="col-form-label">Search</label> -->
                        <input class="form-control" type="text" placeholder="Nama orang tua" id="nama_ortu" name="opsi1">
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
                        <input class="form-control" type="text" placeholder="Alamat" id="opsi2" name="opsi2">
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
<!-- update -->
<div class="modal fade" id="update" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Edit Peserta Fun Science</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url().'index.php/Undangan/update_peserta/'.$function_cont.'/'.$url?>" method="post">
                    <input type="hidden" id="id_undang" name="id_undangan">
                        <!-- Nama peserta -->
                    <input id="unama" type="text" name="nama" class="form-control"><br>
                               <!-- Asal sekolah -->
                    <input id="uket" type="text" name="keterangan" class="form-control"><br>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select><br>
                    <!-- Nama Ortu -->
                    <input id="opsi1" type="text" name="opsi1" class="form-control"><br>
                    <input id="uemail" type="email" name="email" class="form-control"><br>
                    <input type="number" class="form-control" name="no_telepon" id="uno_telepon"><br>
                    <!-- alamat -->
                    <input type="text" name="opsi2" id="opsi" class="form-control"><br>
                    <select id="status_kehadiran" name="status_kehadiran" class="form-control">
                        <option value="Belum Hadir">Belum Hadir</option>
                        <option value="Sudah Hadir">Sudah Hadir</option>
                    </select><br>

                    <div class="modal-footer">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- DATATABLE -->
<script>
    $(document).ready( function () {
    $('#TabelFunScience').DataTable({
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
        { "orderable": false, "targets": [9] },
        { "searchable": false, "targets":[9] }
    ]
    });
    } );
</script>
<!-- update -->
<script>
    function tm_detail(id_undangan) {
    $.getJSON("<?=base_url()?>index.php/Undangan/get_detail_user/"+id_undangan,function(data){
    console.log(data);
    $("#id_undang").val(data['id_undangan']);
    $("#unama").val(data['nama']);
    $("#uket").val(data['keterangan']);
    $("#uemail").val(data['email']);
    $("#jenis_kelamin").val(data['jenis_kelamin']);
    $("#opsi").val(data['opsi2']);
    $("#uno_telepon").val(data['no_telepon']);
    $("#status_kehadiran").val(data['status_kehadiran']);
    $("#opsi1").val(data['opsi1']);
  });
    };
</script>
