
    <div class="modal fade" id="addProdukStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stock Item : </h5>
                    <button type="button" id="addProdukStock-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('dashboardStockManagement.store') }}" method="POST">
                        @csrf
                        <select class="custom-select mt-3" style="width: 49.85%;" id="add-store" name="id_store" required>
                          <option>-- Silahkan Pilih Store --</option>
                          @foreach ($stores as $store)
                              <option value={{ $store->id_store }}>{{ $store->nama_store }}</option>
                          @endforeach
                        </select>
                        
                        <select class="custom-select kategori-select mt-3" style="width: 49.85%;" id="add-product" name="id_item" required>
                          <option>-- Silahkan Pilih Produk --</option>
                          <optgroup id="opt-group-addStock"></optgroup>
                            {{--@foreach ($kategori as $value)
                              <option value={{ $value->id_kategori }}>{{ $value->nama_kategori }}</option>
                            @endforeach--}}
                        </select>
                        
                        <input class="form-control" type="text" id="id_item_add" name="nama_item" placeholder="nama item" hidden>
                        <label class="mt-3">Kuantitas :</label>
                        <input class="form-control" type="number" id="qty" name="qty" placeholder="qty">
                        <label class="mt-3">Minimal Kuantitas :</label>
                        <input class="form-control" type="number" id="min_qty" name="min_qty" placeholder="min. qty">
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
