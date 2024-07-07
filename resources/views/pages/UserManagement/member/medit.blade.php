<div class="modal fade" id="editMemberModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifyModalContent_title">Edit Pelanggan</h5>
        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="editCustomerForm" novalidate>
          @csrf
          <input id="editId" type="text" hidden>
          <div class="form-group mb-2">
            <label for="name">Nomor Kartu</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="norfid" name="norfid" type="text"
                placeholder="Tempelkan Kartu" required>
        </div>
          <div class="form-group mb-2">
            <label for="editName">Nama</label>
            <small class="text-danger">*</small>
            <input class="form-control" id="editName" type="text" placeholder="e.g Ahmad Yusuf" required>
          </div>
          <div class="form-group mb-2">
            <label for="editEmail">Email</label>
            <small class="text-danger">* (default password : <b>password</b>)</small>
            <input class="form-control" id="editEmail" type="email" placeholder="e.g example@email.com" required>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn btn-warning updateCustomer mt-2" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
