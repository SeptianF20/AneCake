@extends('layouts.master')

@section('title')
  @lang('translation.Dashboards')
@endsection

@section('css')
  <style>
    [data-href] {
      cursor: pointer;
    }
  </style>
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('li_1')
      Dashboards
    @endslot
    @slot('title')
      Dashboard
    @endslot
  @endcomponent

  <div class="row">
    <div class="col-xl-4">
      <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
          <div class="row">
            <div class="col-8">
              <div class="text-primary p-3">
                <h5 class="text-primary">Selamat Datang!</h5>
                <p>Anecake</p>
              </div>
            </div>
            <div class="col-4 align-self-end">
              <img class="img-fluid" src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="">
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="row">
            <div class="col-sm-4">
              <div class="avatar-md profile-user-wid mb-4">
                <img class="img-thumbnail rounded-circle"
                  src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                  alt="">
              </div>
            </div>

            <div class="col-sm-8">
              <div class="pt-4">

                <div class="row">
                  <h5 class="font-size-15 text-truncate">{{ Str::ucfirst(Auth::user()->name) }}</h5>
                  <p class="text-muted text-truncate mb-0">{{ Str::ucfirst(Auth::user()->getRoleNames()->first()) }}</p>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card mini-stats-wid">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="text-muted fw-medium">Jumlah Produk</p>
              <h4 class="mb-0">{{ $products }}</h4>
            </div>

            <div class="align-self-center flex-shrink-0">
              <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                <span class="avatar-title">
                  <i class="bx bx-copy-alt font-size-24"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card mini-stats-wid">
        <div class="card-body">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="text-muted fw-medium">Jumlah Pelanggan</p>
              <h4 class="mb-0">{{ $customers }}</h4>
            </div>

            <div class="align-self-center flex-shrink-0">
              <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                <span class="avatar-title">
                  <i class="bx bxs-user-rectangle font-size-24"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Produk Terlaris</h4>
          @foreach ($topProducts as $item)
            <div class="item bg-primary bg-soft mt-2 rounded p-2">
              <div class="d-flex">
                <div class="product-img me-2 rounded bg-white">
                  <img class="avatar-md rounded" src="{{ $item->thumbnail }}" alt="">
                </div>
                <div class="desc">
                  <p class="product-name font-size-15 fw-medium m-0">{{ $item->name }}</p>
                  <p class="product-category text-mute m-0">{{ $item->category }}</p>
                  <p class="product-sales text-mute m-0">Terjual <span class="fw-medium">{{ $item->total }}</span></p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
@endsection
@section('script')
  <!-- apexcharts -->
  <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  {{-- #forecast_chart script  --}}

  <script>
    var options = {
      chart: {
        height: 250,
        type: 'line',
        stacked: false,
        zoom: {
          enabled: false
        },
        stroke: {
          width: [0, 2, 4],
          curve: 'smooth'
        },
        toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: [3, 3, 4],
        curve: 'straight',
        dashArray: [0, 8, 5]
      },
      series: [{
        name: "Penjualan",
        type: "area",
        data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
      }],
      fill: {
        type: 'gradient',
        opacity: [0.85, 0.25, 1],
        gradient: {
          inverseColors: false,
          shade: 'light',
          type: "vertical",
          opacityFrom: 0.85,
          opacityTo: 0.55,
          stops: [0, 100, 100, 100]
        }
      },
      markers: {
        size: 0,
        hover: {
          sizeOffset: 6
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      },
      tooltip: {
        y: [{
          title: {
            formatter: function(val) {
              return val
            }
          }
        }]
      },
      grid: {
        borderColor: '#f1f1f1',
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#sales-chart"),
      options
    );

    chart.render();
  </script>

  <!-- dashboard init -->
  <script src="{{ URL::asset('assets/js/pages/dashboard.init.js') }}"></script>

  <script>
    jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
        window.location = $(this).data("href");
      });
    });
  </script>
@endsection
