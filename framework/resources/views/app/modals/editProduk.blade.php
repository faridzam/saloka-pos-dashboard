
    <div class="modal fade" id="editProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="{{ route('masterMenu.update') }}" method="POST">
                        @csrf
                        <input class="form-control mt-2" type="text" id="id" name="id">
                        <input class="form-control mt-2" type="text" id="id_item" name="id_item" placeholder="id item">
                        <input class="form-control mt-2" type="text" id="nama_item" name="nama_item" placeholder="nama item">
                        <input class="form-control mt-2" type="text" id="id_kategori" name="id_kategori" placeholder="id kategori">
                        <input class="form-control mt-2" type="text" id="id_store" name="id_store" placeholder="id store">
                        <input class="form-control mt-2" type="number" id="harga" name="harga" placeholder="hpp">
                        <input class="form-control mt-2" type="number" id="pajak" name="pajak" placeholder="pajak">
                        <input class="form-control mt-2" type="number" id="harga_jual" name="harga_jual" placeholder="harga jual">
                        <input class="form-control mt-2" type="number" id="isDell" name="isDell" value="0" hidden>
                        <button type="submit" class="btn btn-primary mt-2" id="submit-update-item">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
