
    <div class="modal fade" id="plusStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Plus Stock : </h5>
                    <button type="button"id="plusStock-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="plus-form" action="{{ route('stockManagement.plusStock') }}" method="Get">
                        @csrf
                        <input class="form-control mt-2" type="text" id="id_plus" name="id" placeholder="id" hidden>
                        <input class="form-control mt-2" type="text" id="id_item_plus" name="id_item" placeholder="id item" readonly>
                        <input class="form-control mt-2" type="text" id="nama_item_plus" name="nama_item" placeholder="nama item" readonly>
                        <input class="form-control mt-2" type="number" id="qty_plus" name="qty_plus" placeholder="kuantitas">
                        <input class="form-control mt-2" type="text" id="keterangan_plus" name="keterangan_plus" placeholder="Keterangan">
                        <button type="submit" class="btn btn-primary mt-2" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
