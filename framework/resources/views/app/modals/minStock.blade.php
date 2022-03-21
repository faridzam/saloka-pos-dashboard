
    <div class="modal fade" id="minStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Min Stock : </h5>
                    <button type="button"id="minStock-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="min-form" action="{{ route('stockManagement.minStock') }}" method="Get">
                        @csrf
                        <input class="form-control mt-2" type="text" id="id_min" name="id" placeholder="id" hidden>
                        <input class="form-control mt-2" type="text" id="id_item_min" name="id_item" placeholder="id item" readonly>
                        <input class="form-control mt-2" type="text" id="nama_item_min" name="nama_item" placeholder="nama item" readonly>
                        <input class="form-control mt-2" type="number" id="qty_min" name="qty_min" placeholder="kuantitas">
                        <input class="form-control mt-2" type="text" id="keterangan_min" name="keterangan_min" placeholder="Keterangan">
                        <button type="submit" class="btn btn-primary mt-2" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
