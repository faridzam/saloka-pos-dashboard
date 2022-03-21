
    <div class="modal fade" id="addSpecialPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Special Price : </h5>
                    <button type="button" id="addSpecialPrice-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('dashboardSpecialPrice.store') }}" method="POST">
                        @csrf
                        <input class="form-control" type="text" id="add_discount_id" name="id" readonly hidden>
                        <input class="form-control" type="text" id="add_discount_store" name="id_store" readonly hidden>
                        <input class="form-control" type="text" id="add_discount_id_item" name="id_item" readonly hidden>
                        <input class="form-control" type="text" id="add_discount_id_kategori" name="id_kategori" readonly hidden>
                        <label class="mt-3">Nama Item :</label>
                        <input class="form-control" type="text" id="add_discount_nama_item" name="nama_item" readonly>
                        <label class="mt-3">Special Price :</label>
                        <input class="form-control" type="number" id="add_discount_discount" name="sp_price">
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Add Special Price</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
