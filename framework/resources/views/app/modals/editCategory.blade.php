
    <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category : </h5>
                    <button id="editCategory-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="{{ route('masterCategory.update') }}" method="POST">
                        @csrf
                        <input class="form-control mt-2" type="text" id="id" name="id" hidden>
                        <label class="mt-3">ID Category :</label>
                        <input class="form-control" type="text" id="id_kategori" name="id_kategori" placeholder="id kategori" readonly>
                        <label class="mt-3">ID Store :</label>
                        <input class="form-control" type="text" id="id_store" name="id_store" placeholder="id store" readonly>
                        <label class="mt-3">Nama Kategori :</label>
                        <input class="form-control" type="text" id="nama_kategori" name="nama_kategori" placeholder="nama_kategori">
                        <button type="submit" class="btn btn-primary mt-2" id="submit-update-item">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
