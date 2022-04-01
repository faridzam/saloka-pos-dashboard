
    <div class="modal fade" id="addStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Store : </h5>
                    <button type="button" id="addStore-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-form" action="{{ route('dashboardMasterStore.store') }}" method="POST">
                        @csrf

                        <label class="mt-3">Kode Store :</label>
                        <input class="form-control" type="text" id="kode_store" name="kode_store" placeholder="Kode Store">
                        <label class="mt-3">Nama Store :</label>
                        <input class="form-control" type="text" id="nama_store" name="nama_store" placeholder="Nama Store">
                        <label class="mt-3">Printer :</label>
                        <input class="form-control" type="text" id="ip_kasir" name="ip_kasir" placeholder="Printer Kasir">
                        <label class="mt-3">IP Kitchen :</label>
                        <input class="form-control" type="text" id="ip_kitchen" name="ip_kitchen" placeholder="IP Kitchen">
                        <label class="mt-3">IP Bar :</label>
                        <input class="form-control" type="text" id="ip_bar" name="ip_bar" placeholder="IP Bar">
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
