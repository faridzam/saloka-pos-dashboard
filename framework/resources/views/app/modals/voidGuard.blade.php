
    <div class="modal fade" id="invoiceGuard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Password: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/authenticateVoid" method="POST">
                        @csrf
                        <input class="form-control mt-2" type="text" id="no_invoice" name="no_invoice" hidden>
                        <input class="form-control mt-2" type="password" id="password" name="password" placeholder="password...">
                        <button type="submit" class="btn btn-primary mt-2">login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
