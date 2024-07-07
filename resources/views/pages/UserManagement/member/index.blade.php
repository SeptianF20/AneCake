@extends('layouts.master')

@section('title')
Member
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
Member
@endslot
@endcomponent

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <div class="card-title">
          <h4>Member</h4>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
              data-bs-target="#addMemberModal" type="button">
              <i class="bx bx-plus font-size-16 me-2 align-middle"></i> Tambah Member
            </button>
          </div>
        </div>

        <div id="table">
          <table class="table-bordered dt-responsive nowrap w-100 table" id="tbl-member">
            <thead>
              <tr>
                <th>#</th>
                <th>ID Kartu</th>
                <th>Nama Member</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Saldo</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($members as $member)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member->card_id }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->address }}</td>
                <td>{{ moneyFormat($member->saldo) }}</td>
                <td>
                  <button class="btn btn-warning waves-effect waves-light btn-sm editMember" data-bs-toggle="modal"
                    data-bs-target="#editMemberModal" type="button" onclick="editMember('{{ $member->id }}')">
                    <i class="bx bx-edit"></i> Edit
                  </button>

                  <button class="btn btn-danger waves-effect waves-light btn-sm deleteMember" data-bs-toggle="modal"
                    data-bs-target="#deleteMemberModal" type="button" onclick="deleteMember('{{ $member->id }}')">
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
<div class="modal fade" id="deleteMemberModal" role="dialog" aria-labelledby="deleteMemberModal" aria-hidden="true"
  tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h4 class="mt-4">Are you sure want to delete this Member?</h4>
        <input id="deleteId" type="hidden">
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-sm btn-danger deleteMemberConfirmBtn" type="button">Delete</button>
          <button class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

@include('pages.UserManagement.Member.add')
@include('pages.UserManagement.Member.edit')
@endsection

@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>

<script src="{{ URL::asset('js/script.js') }}"></script>
<!-- Datatable init -->
<script>
  dataTableInit('#tbl-member');
  $('.select2').select2();

</script>

<script>
  //add member
  $('.addMember').click(function (e) {
    loadBtn($(this));

    $.ajax({
      url: "{{ route('admin.member.store') }}",
      type: "POST",
      data: $('#addMemberForm').serialize(),
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      dataType: "json",
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#addMemberModal').modal('hide');
          $('.addMember').html(
              `<i class="bx bx-save font-size-16 align-middle me-2"></i> Save`
            )
            .removeClass('disabled');
          $('#addMemberForm')[0].reset();

          $('#tbl-member').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-member', function () {
            dataTableInit('#tbl-member');
          });
        }
      },
      error: function (error) {
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


  //edit member
  const editMember = (id) => {
    $.ajax({
      url: `{{ route('admin.member.edit', ':id') }}`.replace(':id', id),
      type: 'GET',
      success: (response) => {
        let data = response.data
        if (response) {
          $('#editName').val(data.name)
          $('#editEmail').val(data.email)
          $('#editPhone').val(data.phone)
          $('#editAddress').val(data.address)
          $('#editId').val(data.id)
        }
      },
      error: (error) => {
        $('#editMemberModal').modal('dispose')
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
          s
        }
      }
    })
  }

  // update member
  $('.updateMember').click(function (e) {
    loadBtn($(this));
    const name = $('#editName').val();
    const email = $('#editEmail').val();
    const phone = $('#editPhone').val();
    const address = $('#editAddress').val();
    const id = $('#editId').val();
    const _token = '{{ csrf_token() }}';
    $.ajax({
      url: `{{ route('admin.member.update', ':id') }}`.replace(':id', id),
      type: "PUT",
      data: {
        name: name,
        email: email,
        phone: phone,
        address: address,
        _token: _token
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#editMemberModal').modal('hide');
          $(".updateMember").html('Save').removeClass('disabled');
          $('#editMemberForm')[0].reset();

          $('#tbl-member').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-member', function () {
            dataTableInit('#tbl-member');
          });

        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $(".updateMember").html('Save').removeClass('disabled');
      },
    });
    return false;
  });

  const deleteMember = (id) => {
    $('#deleteId').val(id);
  }

  $('.deleteMemberConfirmBtn').on('click', function (e) {
    loadBtn($(this));
    const id = $('#deleteId').val();
    $.ajax({
      url: `{{ route('admin.member.destroy', ':id') }}`.replace(':id', id),
      type: "DELETE",
      data: {
        "_token": "{{ csrf_token() }}",
      },
      success: function (response) {
        if (response) {
          toastSuccess(response.message);
          $('#deleteMemberModal').modal('hide');
          $('#deleteId').val('');
          $('.deleteMemberConfirmBtn').html(
              `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
            )
            .removeClass('disabled');
          $('#tbl-member').html(
            `@include('components.table-loader')`
          );

          $('#table').load(location.href + ' #tbl-member', function () {
            dataTableInit('#tbl-member');
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.message) {
          toastWarning(error.responseJSON.message);
        } else {
          toastError(error.message);
        }
        $('.deleteMemberConfirmBtn').html(
            `<i class="bx bx-trash font-size-16 align-middle me-2"></i> Delete`
          )
          .removeClass('disabled');
      }
    });
  });

</script>
<script>
  $(document).ready(function () {
    var continuePolling = true; // Flag to control polling
    var lastDisplayedId = 0; // Variable to keep track of the last displayed ID

    // Function to fetch the latest card ID
    function fetchLatestCardId() {
      $.ajax({
        url: "{{ route('get.rfid.data') }}",
        method: "GET",
        success: function (response) {
          if (response) {
            if (response.id > lastDisplayedId) {
              console.log('New Card ID:', response);
              $('#card_id').val(response.card_id); // Assuming card_id is the field you want to display
              lastDisplayedId = response.id; // Update the last displayed ID
            }
          } else {
            console.log('No data found in the database.');
          }
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
          if (response.success) {
            console.log('Card ID deleted successfully');
          } else {
            console.log('Failed to delete Card ID');
          }
        },
        error: function (xhr, status, error) {
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
    $('#addMemberModal').on('show.bs.modal', function (event) {
      continuePolling = true; // Reset flag when the modal is shown
      pollLatestCardId();
    });

    // Stop polling and delete data when the modal is hidden
    $('#addMemberModal').on('hide.bs.modal', function (event) {
      continuePolling = false; // Stop polling when the modal is hidden
      deleteLatestCardId(); // Delete the latest card ID
    });

    // Delete data when the save button is clicked
    $('.addMember').on('click', function (event) {
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
