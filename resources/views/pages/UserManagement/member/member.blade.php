<!-- Verify Modal content -->
<div class="modal fade" id="addMemberModal" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true"
    tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalContent_title">Tambah Data Pelanggan Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="addMemberForm" novalidate>
                    <div class="form-group mb-2">
                        <label for="norfid">Nomor Kartu</label>
                        <small class="text-danger">*</small>
                        <input class="form-control" id="norfid" name="norfid" type="text"
                            placeholder="Tempelkan Kartu" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="name">Nama</label>
                        <small class="text-danger">*</small>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="e.g. Ahmad Yusuf" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <small class="text-danger">* (default password : <b>password</b>)</small>
                        <input class="form-control" id="email" name="email" type="email"
                            placeholder="e.g example@email.com" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone">Phone</label>
                        <small class="text-danger">*</small>
                        <input class="form-control" id="phone" name="phone" type="number"
                            placeholder="1234567890" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="alamat">Alamat</label>
                        <small class="text-danger">*</small>
                        <input class="form-control" id="alamat" name="alamat" type="text"
                            placeholder="e.g Kediri" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary addMember mt-2" type="submit">
                            <i class="bx bx-save font-size-16 me-2 align-middle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
