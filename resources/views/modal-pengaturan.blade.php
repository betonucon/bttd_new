<div class="modal fade" id="modalfoto" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Foto Profil </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_simpan_foto"></div>
                <form method="post" id="mysimpan_foto" enctype="multipart/form-data">
                    @csrf
                        
                        <div class="form-group">
                            <label>Foto Profil</label>
                            <input type="file"  name="foto"  class="form-control">
                        </div>
                </form>
                <div style="width:100%;display:flex;">
                     <span id="simpan_foto" style="margin-right:2%" onclick="simpan_foto()" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_simpan_foto" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_simpan_foto">
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('simpan')
    <script>
        function simpan_foto(){
            var form=document.getElementById('mysimpan_foto');
            var a="{{$id}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/pengaturan/simpan_foto')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('#simpan_foto').hide();
                        $('#tutup_simpan_foto').hide();
                        $('#proses_loading_simpan_foto').html('Proses Data ....................');
                    },
                    success: function(msg){
                        
                        if(msg=='ok'){
                            location.reload();
                        }else{
                            $('#simpan_foto').show();
                            $('#tutup_simpan_foto').show();
                            $('#proses_loading_simpan_foto').html('');
                            $('#notifikasi_simpan_foto').html(msg);
                        }
                        
                        
                    }
                });

        } 
    </script>
@endpush