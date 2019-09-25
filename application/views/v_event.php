<!-- Card Acara   -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card">
            
                <div class="card-body">
                    
            <h2 class="header"  style="">Daftar Acara</h2>
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
            <a href="#tambah" class="btn btn-dark" data-toggle="modal"> <i class="fas fa-plus"></i> <span style="margin-left:3px;"> Tambah Acara</span></a>
                <div class="row">
                <?php foreach ($dt as $dte) : ?>
                
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="card card-event">
                        <div class="card-body">
                        <div class="card-title title-event text-wrap"> <?= $dte->nama_event ?>  </div>
                            <h6 class="card-subtitle mb-2 text-muted subtitle-event"><?= $dte->jenis?></h6>
                            <p class="card-text"> <?= $dte->detail? $dte->detail:"<i>Tidak ada keterangan</i>";?> </p>
                                <p class="card-text">
                                    Detail <?= $dte->jenis?> : <br>    
                                    <i class="far fa-calendar-alt keterangan-event"></i> <?= $dte->waktu?> <br>
                                    <i class="fas fa-map-marker-alt keterangan-event"></i> <?= $dte->lokasi?> <br>
                                    <i class="far fa-clock keterangan-event"></i> <?= $dte->jam?> <br>
                                </p>
                                <?php
                                    $fs = "Fun Science";
                                    $akm = "Akuntansi Masjid";
                                    $mystring = $dte->nama_event;
                                    
                                    // Test if string contains the word 
                                    if(strpos($mystring, $fs) !== false){?>
                                    <a href="<?php echo base_url().'index.php/Undangan/tabel_fun_science/'.$dte->id_event?>"class="card-link">Lihat daftar tamu disini</a>
                                        <?php } else if(strpos($mystring, $akm) !== false){?>
                                    <a href="<?php echo base_url().'index.php/Undangan/akuntansi_masjid/'.$dte->id_event?>"class="card-link">Lihat daftar tamu disini</a>
                                <?php } else {?>
                                <a href="<?php echo base_url().'index.php/Undangan/index/'.$dte->id_event?>" class="card-link">Lihat daftar tamu disini</a>
                                <?php } ?>
                        </div>
                        <div class="card-footer">
                        <div class="btn-event">
                        <a href="#edit"  onclick="tm_detail('<?php echo ($dte->id_event)?>')" data-toggle="modal"> <i class="fas fa-edit"></i></a> 
                        <a href="<?php echo base_url().'index.php/Event/hapus_event/'.$dte->id_event ?>" onclick="return confirm('Anda yakin akan menghapus acara ini?');"> <i class="fas fa-trash-alt"></i> </a>
                        </div>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tambah Acara -->
<div class="modal fade" id="tambah" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Event Baru</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('index.php/Event/simpan_event')?>" method="post">
                    Nama Acara
                    <input type="text" name="nama_event" class="form-control" autofocus="autofocus"><br>
                    Waktu
                    <input type="datetime-local" name="waktu" class="form-control" min="2019-01-01" max="2030-12-31"><br>
                    Lokasi
                    <input type="text" name="lokasi" class="form-control"><br>
                    Detail  <br>
                    <textarea name="detail" id="" cols="30" rows="3" class="form-control"></textarea><br>
                    Jenis Acara
                    <select name="jenis" id="" class="form-control">
                        <option value="" disabled selected>Pilih Jenis Acara</option>
                        <option value="Event">Event</option>
                        <option value="Meeting">Meeting</option>
                    </select>
                    <div class="modal-footer">
                        <a href=""><input type="submit" name="simpan" value="Simpan" class="btn btn-primary"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- update -->
<div class="modal fade" id="edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('index.php/Event/update_event')?>" method="post">
                    <input type="hidden" id="id_event" name="id_event"> 
                    Nama Acara
                    <input type="text" id="nama_event" name="nama_event" class="form-control"><br>
                    Waktu
                    <input type="datetime" id="waktu" name="waktu" class="form-control"><br>
                    Lokasi
                    <input type="text" id="lokasi" name="lokasi" class="form-control"><br>
                    Detail  <br>
                    <textarea name="detail" id="detail" cols="30" rows="3" class="form-control"></textarea><br>
                    Jenis Acara
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="" disabled selected>Pilih Jenis Acara</option>
                        <option value="Event">Event</option>
                        <option value="Meeting">Meeting</option>
                    </select>
                    <div class="modal-footer">
                        <a href=""><input type="submit" name="simpan" value="Simpan" class="btn btn-primary"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- update -->
<script>
    function tm_detail(id_event) {
        $.getJSON("<?=base_url()?>index.php/Event/get_detail_event/"+id_event,function(data){
        console.log(data);
        $("#id_event").val(data['id_event']);
        $("#nama_event").val(data['nama_event']);
        $("#waktu").val(data['waktu']);
        $("#lokasi").val(data['lokasi']);
        $("#detail").val(data['detail']);
        $("#jenis").val(data['jenis']);
        });
    }
</script>