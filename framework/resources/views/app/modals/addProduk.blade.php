
    <div class="modal fade" id="addProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item : </h5>
                    <button type="button" id="addProduk-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('dashboardMasterMenu.store') }}" method="POST">
                        @csrf

                        <select class="custom-select mt-3" style="width: 49.85%;" id="add-store" name="id_store" required>
                          <option>-- Silahkan Pilih Store --</option>
                          @foreach ($stores as $store)
                              <option value={{ $store->menu_store }}>{{ $store->nama_store }}</option>
                          @endforeach
                        </select>

                        <select class="custom-select kategori-select mt-3" style="width: 49.85%;" id="add-kategori" name="id_kategori" required>
                          <option>-- Silahkan Pilih Kategori --</option>
                          <optgroup id="add-group-category"></optgroup>
                        </select>

                        <label class="mt-3">ID Item :</label>
                        <input class="form-control" type="text" id="id_item" name="id_item" placeholder="id item">
                        <label class="mt-3">Nama Item :</label>
                        <input class="form-control" type="text" id="nama_item" name="nama_item" placeholder="nama item">
                        <label class="mt-3">HPP :</label>
                        <input class="form-control" type="number" id="harga" name="harga" placeholder="hpp">
                        <label class="mt-3">Pajak :</label>
                        <input class="form-control" type="number" id="pajak" name="pajak" placeholder="pajak">
                        <label class="mt-3">Harga Jual :</label>
                        <input class="form-control" type="number" id="harga_jual" name="harga_jual" placeholder="harga jual">
                        <input class="form-control" type="number" id="isDell" name="isDell" value="0" hidden>
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
