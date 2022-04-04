
    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category : </h5>
                    <button type="button" id="addCategory-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('dashboardMasterCategory.store') }}" method="POST">
                        @csrf
                        
                        <select class="custom-select mt-3" style="width: 100%;" id="add-store" name="id_store" required>
                          <option>-- Silahkan Pilih Store --</option>
                              @foreach ($stores as $store)
                                  <option value={{ $store->menu_store }}>{{ $store->nama_store }}</option>
                              @endforeach
                        </select>
                        
                        <select class="custom-select mt-3" style="width: 100%;" id="add-jenis" name="jenis_kategori" required>
                          <option >-- Silahkan Pilih Jenis Kategori--</option>
                          <option value="1"> Makanan </option>
                          <option value="2"> Minuman </option>
                          <option value="3"> Non-Konsumsi </option>
                        </select>

                        <label class="mt-3">ID Kategori :</label>
                        <input class="form-control" type="text" id="id_kategori" name="id_kategori" placeholder="ID Kategori" readonly>
                        <label class="mt-3">Nama Kategori :</label>
                        <input class="form-control" type="text" id="nama_kategori" name="nama_kategori" placeholder="Nama Kategori">
                        
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
  $(document).ready(function(){

   fetch_add();

   function fetch_add(id_store = $('#add-store').val(), jenis_kategori = $('#add-jenis').val())
   {
    $.ajax({
     url:"dashboardMasterCategory-search-add",
     method:'GET',
     data:{id_store:id_store, jenis_kategori:jenis_kategori},
     dataType:'json',
     success:function(data)
     {
        $('#id_kategori').val() = data[id_kategori];
     }
    })
   }

   $(document).on('change', '#add-store', function(){
    var id_store = $('#add-store').val();
    var jenis_kategori = $('#add-jenis').val();
    fetch_add(id_store, jenis_kategori);
   });
   $(document).on('change', '#add-jenis', function(){
    var id_store = $('#add-store').val();
    var jenis_kategori = $('#add-jenis').val();
    fetch_add(id_store, jenis_kategori);
   });
  });
</script>