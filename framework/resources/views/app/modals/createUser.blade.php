
    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item : </h5>
                    <button type="button" id="createUser-close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-form" action="{{ route('dashboardUsers.store') }}" method="POST"
                    oninput='password_confirmation.setCustomValidity(password_confirmation.value != password.value ? "Passwords do not match." : "")'>
                        @csrf
                        
                        <select class="custom-select mt-3" id="tipe_user" name="tipe_user" required>
                          <option selected="">-- Silahkan Pilih Tipe User --</option>
                          <option value="1">Kasir</option>
                          <option value="2">Admin Dashboard</option>
                        </select>
                        
                        <label class="mt-3">Nama User :</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="username" required>
                        <label class="mt-3">Email User :</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="email" required>
                        <label class="mt-3">Password :</label>
                        <input class="form-control" type="password" id="password" name="password" placeholder="password" required>
                        <label class="mt-3">Ulangi Password :</label>
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="password confirmation" required>
                        <button type="submit" class="btn btn-lg btn-primary mt-5" id="submit-update-item">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
