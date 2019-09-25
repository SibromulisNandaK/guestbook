<?php
    $function_cont = $this->uri->segment(2);
    $url = $this->uri->segment(3);
?>
<!-- select2 -->
<script>
    $(document).ready(function() { $("#unama_karyawan").select2(); });
</script>
<!-- isi tabel -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
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
                <div class="card-body">
                    <h3 class="card-title">Data Kunjungan</h3>
                    <hr class="style1 garis">
                    <a href="<?php echo(base_url('index.php/Kunjungan/index')) ?>"  class="btn btn-primary" style="margin-bottom:20px;"><i class="fas fa-plus"></i><span style="margin-left:3px;">Tambah Kunjungan</a>
                    
                    <?php
                        $function_cont = $this->uri->segment(2);
                        $url = $this->uri->segment(3);
                    ?>
                    <!-- <div class="data-tables datatable-dark"> -->
                        <table class="table table-hover" id="TabelKunjungan" style="width:100%;">
                        <thead class="thead-light">
					<tr> 
                        <th style="width:10px">No</th>
                        <th>Nama Tamu</th>
                        <th>Asal</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Tujuan</th>
                        <th>Keperluan</th>
                        <th>Waktu</th>

                        <!-- <th>Kode QR</th> -->
                        <th>Aksi</th>
					</tr>
				</thead>
				<tbody>
                    <?php $no=1; ?>
                    <?php 
                    foreach ($data_kunjungan as $isi) : ?>
                    <?php $url = $this->uri->segment(3); ?>
                    <tr>
				        <td>
        		            <?= $no++ ?>
		        		</td>
                        <td>
                            <?php echo ($isi->nama_tamu)? $isi->nama_tamu: $isi->nama_karyawan ?>
                        </td>
                        <td>
                            <?php echo ($isi->keterangan) ?>
                        </td>
                        <td>
                            <?php echo ($isi->no_telepon) ?>
                        </td>
                        <td>
                            <?php echo ($isi->email) ?>
                        </td>
                        <td>
                            <?php echo ($isi->jenis_kelamin) ?>
                        </td>
                        <td>
                            <?php echo ($isi->nama_karyawan) ?>
                        </td>
                        <td>
                            <?php echo ($isi->keperluan) ?>
                        </td>
                        <td>
                            <?php echo ($isi->waktu) ?>
                        </td>
                        <td>
                            <div class="btn-group"  role="group" aria-label="Basic example">
                            <a href="#update" data-toggle="modal" data-dismiss="modal" onclick="tm_detail('<?php echo ($isi->id_kunjungan)?>')" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                            <a id=""href="<?php echo base_url().'index.php/Kunjungan/delete_kunjungan/'.$isi->id_kunjungan ?> " onclick="return confirm('Anda yakin akan menghapus data kunjungan ini?');"class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
	        	</tbody>
	            	    </table>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- update -->
<div class="modal fade" id="update" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Edit Data Kunjungan</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url().'index.php/Kunjungan/update_kunjungan/'.$function_cont.'/'.$url?>" method="post">
                    <input type="hidden" id="id_kunjungan" name="id_kunjungan">
                    <input id="unama_tamu" type="text" name="nama_tamu" class="form-control"><br>
                    <input id="uketerangan" type="text" name="keterangan" class="form-control"><br>
                    <input type="number" class="form-control" name="no_telepon" id="no"><br>
                    <input class="form-control" type="email" name="email" id="uemail"><br>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select><br>
                    <!-- <select class="form-control js-example-basic-single tujuh" name="nama_karyawan" id="unama_karyawan" style="width:100%; " >
                        <?php foreach ($get_karya as $row) {  
		                echo "<option value='".$row->id_karyawan."'>".$row->nama_karyawan."</option>";
	                    }
                    echo"</select>"?> -->
                    <!-- <input class="form-control js-example-basic-single" type="text" name="nama_karyawan" id="unama_karyawan"><br> -->
                    <input class="form-control" type="text" id="ukeperluan" name="keperluan"><br>
                    <input type="text" name="waktu" id="uwaktu" class="form-control"><br>
                    <div class="modal-footer">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- update -->
<script>
    function tm_detail(id_kunjungan) {
    $.getJSON("<?=base_url()?>index.php/Kunjungan/get_detail_user/"+id_kunjungan,function(data){
    console.log(data);
    $("#id_kunjungan").val(data['id_kunjungan']);
    $("#unama_tamu").val(data['nama_tamu']);
    $("#uketerangan").val(data['keterangan']);
    $("#no").val(data['no_telepon']);
    $("#uemail").val(data['email']);
    $("#ujenis_kelamin").val(data['jenis_kelamin']);
    $("#unama_karyawan").val(data['nama_karyawan']);
    $("#ukeperluan").val(data['keperluan']);
    $("#uwaktu").val(data['waktu']);
  });
    };
</script>
<!-- datatable -->
<script>
    $(document).ready( function () {
    $('#TabelKunjungan').DataTable({
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