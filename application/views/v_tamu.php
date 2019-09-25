<!-- isi tabel -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
             <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Data Tamu</h3>
                    <hr class="style1 garis">
                    <div class="data-tables datatable-dark">
                        <table class="table table-hover" id="TabelTamu" style="width:100%;">
                            <thead class="text-capitalize thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tamu</th>
                                    <th>Alamat Email</th>
                                    <th>No Telepon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($table as $data):?>
                                <tr>
                                    <td>
                                        <?php echo $no; $no++;?>
                                    </td>
                                    <td>
                                        <?php echo $data->nama ?>
                                    </td>
                                    <td>
                                        <?php echo $data->email ?>
                                    </td>
                                    <td>
                                        <?php echo $data->no_telepon ?>
                                    </td>
                                    <td>
                                        <?php echo $data->jenis_kelamin ?>
                                    </td>
                                    <td>
                                        <?php echo $data->keterangan ?>
                                    </td>
                                    <td>
                                        <a id=""href="<?php echo base_url().'index.php/Tamu/delete/'.$data->id_tamu ?>" onclick="return confirm('Anda yakin akan menghapus data tamu ini?');" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        <a href="#update" data-toggle="modal" data-dismiss="modal" onclick="tm_detail('<?php echo ($data->id_tamu)?>')" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
	            	    </table>
                    </div>
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
            <h4 class="modal-title" id="myModalLabel">Edit Tamu</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('index.php/Tamu/update')?>" method="post">
                    <input type="hidden" id="id_tamu" name="id_tamu">
                        <!-- Nama U -->
                    <input id="nama" type="text" name="nama" class="form-control"><br>
                               <!-- Alamat Email -->
                    <input id="email" type="email" name="email" class="form-control"><br>
                    <input type="number" class="form-control" name="no_telepon" id="no_telepon"><br>
                                <!-- Password -->
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select><br>
                    <input id="keterangan" type="text" name="keterangan" class="form-control"><br>

                    <div class="modal-footer">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Table -->
<script>
    $(document).ready( function () {
    $('#TabelTamu').DataTable({
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
        { "orderable": false, "targets": [6] },
        { "searchable": false, "targets":[6] }
    ]
    });
    } );
</script>
<!-- edit -->
<script>
    function tm_detail(id_tamu) {
        $.getJSON("<?=base_url()?>index.php/Tamu/get_detail_user/"+id_tamu,function(data){
            console.log(data);
            $("#id_tamu").val(data['id_tamu']);
            $("#nama").val(data['nama']);
            $("#email").val(data['email']);
            $("#no_telepon").val(data['no_telepon']);
            $("#jenis_kelamin").val(data['jenis_kelamin']);
            $("#keterangan").val(data['keterangan']);
        });
    };
</script>