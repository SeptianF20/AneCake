@extends('layouts.master')

@section('title')
    Tambah Kartu
@endsection

@section('css')
    <link type="text/css" href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Tambah Member
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <h4>Tambah Kartu Member</h4>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#addMemberModal" type="button">
                                <i class="bx bx-user-plus font-size-16 me-2 align-middle"></i> Tambah Member
                            </button>
                        </div>
                    </div>
                    <div id="table">
                        <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-customers">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>idKartu</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->nama }}</td>
                                        <td>{{ $member->nama }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>
                                            <button class="btn btn-warning waves-effect waves-light btn-sm editCustomer"
                                                data-bs-toggle="modal" data-bs-target="#editMemberModal" type="button"
                                                onclick="editMember('{{ $member->id }}')">
                                                <i class="bx bx-edit"></i> Edit
                                            </button>

                                            <button class="btn btn-danger waves-effect waves-light btn-sm deleteMember"
                                                data-bs-toggle="modal" data-bs-target="#deleteMemberModal" type="button"
                                                onclick="deleteMember('{{ $member->id }}')">
                                                <i class="bx bx-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteMemberModal" role="dialog" aria-labelledby="deleteMemberModalLabel"
        aria-hidden="true" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 class="mt-4">Anda yakin akan menghapus data pelanggan ini?</h4>
                    <input id="deleteId" type="hidden">
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-sm btn-danger deleteMemberConfirmBtn" type="button">Hapus</button>
                        <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages._Main.Cashier.member')
    @include('pages._Main.Cashier.medit')
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

    <script src="{{ URL::asset('js/script.js') }}"></script>
    <!-- Datatable init -->
    <script>
        dataTableInit('#tbl-Cashiers');
    </script>

    <script>
        $('.addCustomer').click(function(e) {
            loadBtn($(this));

            $.ajax({
                url: "{{ route('admin.customers.store') }}",
                type: "POST",
                data: $('#addMemberForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response) {
                    if (response) {
                        toastSuccess(response.message);
                        $('#addMemberModal').modal('hide');
                        $('.addMember').html(
                                `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
                            )
                            .removeClass('disabled');
                        $('#addMemebrForm')[0].reset();

                        $('#tbl-customers').html(
                            `@include('components.table-loader')`
                        );

                        $('#table').load(location.href + ' #tbl-customers', function() {
                            dataTableInit('#tbl-customers');
                        });
                    }
                },
                error: function(error) {
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                    $(".addMember").html('Save').removeClass('disabled');
                },
            });
            return false;
        });

        const editMember = (id) => {
            $.ajax({
                url: `{{ route('admin.card.edit', ':id') }}`.replace(':id', id),
                type: 'GET',
                success: (response) => {
                    let data = response.data
                    if (response) {
                        $('#editName').val(data.name)
                        $('#editEmail').val(data.email)
                        $('#editId').val(data.id)
                    }
                },
                error: (error) => {
                    $('#editMemberModal').modal('dispose')
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                }
            })
        }

        // update customer
        $('.updateCustomer').click(function(e) {
            loadBtn($(this));
            const name = $('#editName').val();
            const email = $('#editEmail').val();
            const id = $('#editId').val();
            const _token = '{{ csrf_token() }}';
            $.ajax({
                url: `{{ route('admin.card.update', ':id') }}`.replace(':id', id),
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    _token: _token
                },
                success: function(response) {
                    if (response) {
                        toastSuccess(response.message);
                        $('#editCustomerModal').modal('hide');
                        $(".updateCustomer").html('Save').removeClass('disabled');
                        $('#editCustomerForm')[0].reset();

                        $('#tbl-customers').html(
                            `@include('components.table-loader')`
                        );

                        $('#table').load(location.href + ' #tbl-customers', function() {
                            dataTableInit('#tbl-customers');
                        });

                    }
                },
                error: function(error) {
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                    $(".updateCustomer").html('Save').removeClass('disabled');
                },
            });
            return false;
        });

        const deleteCustomer = (id) => {
            $('#deleteId').val(id);
        }

        $('.deleteCustomerConfirmBtn').on('click', function(e) {
            loadBtn($(this));
            const id = $('#deleteId').val();
            $.ajax({
                type: "DELETE",
                url: `{{ route('admin.customers.destroy', ':id') }}`.replace(':id', id),
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response) {
                        toastSuccess(response.message);
                        $('#deleteCustomerModal').modal('hide');
                        $('#deleteId').val('');
                        $('.deleteCustomerConfirmBtn').html(
                                `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
                            )
                            .removeClass('disabled');
                        $('#tbl-customers').html(
                            `@include('components.table-loader')`
                        );

                        $('#table').load(location.href + ' #tbl-customers', function() {
                            dataTableInit('#tbl-customers');
                        });
                    }
                },
                error: function(error) {
                    if (error.responseJSON.message) {
                        toastWarning(error.responseJSON.message);
                    } else {
                        toastError(error.message);
                    }
                    $('.deleteCustomerConfirmBtn').html(
                            `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
                        )
                        .removeClass('disabled');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
    var continuePolling = true; // Flag to control polling
    var lastDisplayedId = 0; // Variable to keep track of the last displayed ID

    // Function to fetch the latest card ID
    function fetchLatestCardId() {
        $.ajax({
            url: "{{ route('get.rfid.data') }}",
            method: "GET",
            success: function(response) {
                if (response) {
                    if (response.id > lastDisplayedId) {
                        console.log('New Card ID:', response);
                        $('#norfid').val(response.card_id); // Assuming card_id is the field you want to display
                        lastDisplayedId = response.id; // Update the last displayed ID
                    }
                } else {
                    console.log('No data found in the database.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest RFID data:', error);
            }
        });
    }

    // Function to delete the latest card ID
    function deleteLatestCardId() {
        $.ajax({
            url: "{{ route('delete.rfid.data') }}",
            method: "POST",
            data: {
                id: lastDisplayedId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    console.log('Card ID deleted successfully');
                } else {
                    console.log('Failed to delete Card ID');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting RFID data:', error);
            }
        });
    }

    // Recursive function to periodically fetch the latest card ID
    function pollLatestCardId() {
        if (continuePolling) {
            fetchLatestCardId();
            // Repeat every 5 seconds (adjust as needed)
            setTimeout(pollLatestCardId, 5000);
        }
    }

    // Start polling when the modal is shown
    $('#addMemberModal').on('show.bs.modal', function(event) {
        continuePolling = true; // Reset flag when the modal is shown
        pollLatestCardId();
    });

    // Stop polling and delete data when the modal is hidden
    $('#addMemberModal').on('hide.bs.modal', function(event) {
        continuePolling = false; // Stop polling when the modal is hidden
        deleteLatestCardId(); // Delete the latest card ID
    });

    // Delete data when the save button is clicked
    $('.addMember').on('click', function(event) {
        event.preventDefault();
        // Add your form submission code here
        // ...

        // Delete the latest card ID
        deleteLatestCardId();

        // Hide the modal
        $('#addMemberModal').modal('hide');
    });
});
    </script>
@endsection
