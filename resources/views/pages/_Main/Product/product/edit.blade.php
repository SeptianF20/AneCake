@extends('layouts.master')

@section('title')
  @lang('translation.Dashboards')
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Products
    @endslot
    @slot('title')
      add
    @endslot
  @endcomponent
  <form class="needs-validation" novalidate>

    <div class="wrapper">
      <p class="h3 mb-3">Edit Produk</p>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Nama Produk</h5>
                  <p class="text-muted mb-2">Nama produk min. 40 karakter dengan memasukkan merek, jenis
                    produk, warna, bahan, atau tipe.</p>
                  <p class="text-muted mb-2">Disarankan untuk tidak menggunakan huruf kapital berlebih,
                    memasukkan lebih dari 1 merek, dan kata-kata promosi.</p>
                  <p class="text-muted mb-2">Nama tidak bisa diubah setelah produk terjual, ya.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <label class="form-label" for="productName">
                    Nama Produk <span class="text-danger">*</span>
                  </label>
                  <input class="form-control" id="productName" type="text" value="{{ $product->name }}" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Foto/Thumbnail Produk</h5>
                  <p class="text-muted mb-2">
                    Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran
                    minimum
                    700 x 700 px).
                  </p>
                  <p class="text-muted mb-2">
                    Foto/Thumbnail produk akan menjadi gambar utama produkmu di halaman produk.
                  </p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productThumnail">
                      Foto/Thumbnail Produk <span class="text-danger">*</span>
                    </label>
                    <input id="pathThumbnail" name="path" type="text" value="{{ $product->thumbnail }}">
                    <input class="filepond" id="thumbnail-pond" name="media" type="file" />
                  </div>
                </div>
              </div>
            </div>

            <hr class="divider">

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5 class="mb-0">Harga Jual Produk</h5>
                  <p class="text-muted mb-2">
                    Tambahkan harga jual produk untuk memudahkan pembeli memilih produk yang sesuai dengan kebutuhannya.
                  </p>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productPrice">
                      Harga Jual Produk <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                      <div class="input-group-text">Rp</div>
                      <input class="form-control" id="productPrice" type="number" value="{{ $product->price }}" required>
                    </div>
                    <div class="d-flex mt-3">
                      <s>
                        <h5 class="text-danger" id="coretPrice"></h5>
                      </s>
                      &nbsp;
                      &nbsp;
                      <h5 id="actualPrice"></h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label for="productDiscount">Diskon Harga</label>
                    <div class="input-group">
                      <input class="form-control" id="productDiscount" type="number" value="{{ $product->discount }}"
                        required>
                      <div class="input-group-text">%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-4 col-md-12">
                <div class="card-body">
                  <h5>Kategori Produk</h5>
                  <p class="text-muted mb-2">Pilih kategori produk sesuai dengan produk yang kamu jual.</p>
                </div>
              </div>
              <div class="col-xl-8 col-md-12">
                <div class="card-body">
                  <div class="form-group mb-0">
                    <label>
                      Kategori Produk <span class="text-danger">*</span>
                    </label>
                    <select class="form-select select2" id="productCategory" required>
                      @foreach ($categories as $category)
                        @if ($category->id == $product->category_id)
                          <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                          @continue
                        @endif
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <span class="text-danger">*</span>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="text-center">
                  <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">
                    <i class="mdi mdi-arrow-left"></i>
                    Kembali
                  </a>
                  <button class="btn btn-primary" id="submitProduct" type="submit">
                    <i class="mdi mdi-content-save"></i>
                    Simpan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
    rel="stylesheet" />

  <style>
    .item-type-variant {
      border: 1px solid #556ee6;
      color: #556ee6;
      border-radius: 0.5rem;
      padding: 0.3rem;
      margin-bottom: 0.5rem;
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .btn-type-variant-item {
      border: 1px solid #556ee6;
      color: #556ee6;
      border-radius: 20px;
      padding: 0.1rem 0.3rem;
      font-size: 0.8rem;
      background-color: transparent;
    }

    .btn-type-variant-item:hover {
      background-color: #556ee6;
      color: #fff;
    }

    .card-variant-items {
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      padding: 0.5rem;
      margin-bottom: 0.5rem;
    }

    .card-variant-items hr {
      margin-top: 0.5rem;
    }

    .item-variant {
      border: 1px solid #ced4da;
      border-radius: 0.5rem;
      padding: 0.3rem;
      margin-bottom: 0.5rem;
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .title-variant-item {
      font-size: 1rem;
      font-weight: 600;
      margin-top: 0.5rem;
    }

    .add-variant-item {
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      color: #556ee6;
    }

    .add-variant-item:hover {
      color: #485ec4;
    }

    .btn-variant-item {
      border: 1px solid #ced4da;
      border-radius: 20px;
      padding: 0.1rem 0.3rem;
      font-size: 0.8rem;
      background-color: transparent;
    }

    .btn-variant-item:hover {
      background-color: #ced4da;
    }

    .select2-container {
      z-index: 999 !important;
    }

    .wrapper {
      padding: 0 5%;
    }

    /* if media query is mobile or smartphone, then padding = 0 */
    @media only screen and (max-width: 600px) {
      .wrapper {
        padding: 0;
      }
    }
  </style>
@endsection

@section('script')
  <!-- form tinymce -->
  <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
  <!-- include FilePond library -->
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js">
  </script>
  <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
  <script src="{{ URL::asset('js/script.js') }}"></script>
  <script>
    FilePond.registerPlugin(
      FilePondPluginImagePreview,
      FilePondPluginFileValidateType
    );

    const thumbnail = document.querySelector('#thumbnail-pond');

    const thumbnailPond = FilePond.create(thumbnail, {
      acceptedFileTypes: "image/*",
      allowImagePreview: true,
      imagePreviewHeight: 300,
      acceptedFileTypes: ['image/*'],
      server: {
        process: {
          url: "{{ route('filepond.upload') }}",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
        },
        revert: {
          url: "{{ route('filepond.revert') }}",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
        },
      },
    });

    thumbnailPond.on("processfile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      document.getElementById("pathThumbnail").value = data.path;
    });

    thumbnailPond.on("removefile", (error, file) => {
      if (error) {
        console.log("Oh no");
        return;
      }

      const data = JSON.parse(file.serverId);
      console.log(data);
      document.getElementById("pathThumbnail").value = "";
    });

    // set path thumbnail
    var pathThumbnail = document.getElementById("pathThumbnail").value;
    if (pathThumbnail) {
      thumbnailPond.addFile(pathThumbnail);
    }

  </script>

  <script>
    // #productDiscount input on keyup then write to #discountPrice and actualPrice / discountPrice * 100
    $('#productPrice').keyup(function() {
      if ($('#productDiscount').val() == '' || $('#productDiscount').val() == 0) {
        $('#actualPrice').html('Rp ' + $(this).val());
        $('#coretPrice').hide();
      } else {
        $('#coretPrice').show();
        $('#coretPrice').html('Rp ' + $(this).val());
        $('#actualPrice').html('Rp ' + ($(this).val() - $('#productDiscount').val() / 100 * $(this).val()));
      }
    });

    $('#productDiscount').keyup(async function() {
      if ($(this).val() == '' || $(this).val() == 0) {
        $('#coretPrice').hide();
        $('#actualPrice').html('Rp ' + $('#productPrice').val());
      } else {
        $('#coretPrice').show();
        $('#coretPrice').html('Rp ' + $('#productPrice').val());
        $('#actualPrice').html('Rp ' + ($('#productPrice').val() - $(this).val() / 100 * $('#productPrice').val()));
      }
    });
  </script>

  <script>
    // if submit button is clicked then console
    $("#submitProduct").click(function(e) {
      e.preventDefault();
      console.log('submit clicked');
      var data = {}
      data['product_category_id'] = $('#productCategory').val();
      data['name'] = $('#productName').val();
      data['slug'] = $('#productName').val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
      data['thumbnail'] = $('#pathThumbnail').val();
      data['price'] = $('#productPrice').val();
      data['discount'] = $('#productDiscount').val();

      $.ajax({
        url: "{{ route('admin.products.update', $product->id) }}",
        type: "PUT",
        data: data,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.success) {
            var message = response.message;
            document.cookie = "successMessage=" + message;
            window.location.replace("{{ route('admin.products.index') }}");
          }
        },
        error: function(response) {
          if (response.responseJSON.errors) {
            var errors = response.responseJSON.message;
            toastError(errors);
          } else {
            toastError('Terjadi kesalahan');
          }
        }
      })
    });
  </script>
@endsection

@section('script-bottom')
@endsection
