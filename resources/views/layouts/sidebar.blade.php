<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

  <div class="h-100" data-simplebar>

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">@lang('translation.Main')</li>

        @can('view-dashboard')
          <li>
            <a class="waves-effect" href="{{ route('root') }}">
              <i class="bx bx-home-circle"></i>
              <span key="t-dashboards">@lang('translation.Dashboards')</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-product') ||
                auth()->user()->can('view-category'))
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-store"></i>
              <span key="t-products">@lang('translation.Products')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              @can('view-product')
                <li><a href="{{ route('admin.products.index') }}" key="t-products">@lang('translation.Products')</a></li>
              @endcan
              @can('view-category')
                <li><a href="{{ route('admin.categories.index') }}" key="t-product-category">@lang('translation.Product_Category')</a></li>
              @endcan
            </ul>
          </li>
        @endif

        @can('view-pembelian-barang')
          <li>
            <a class="waves-effect" href="{{ route('admin.purchases.index') }}">
              <i class="bx bx-box"></i>
              <span key="t-stock">Pembelian Barang</span>
            </a>
          </li>
        @endcan

        @can('view-supplier')
          <li>
            <a class="waves-effect" href="{{ route('admin.suppliers.index') }}">
              <i class="bx bx-package"></i>
              <span key="t-stock">Supplier</span>
            </a>
          </li>
        @endcan

        {{-- @can('view-member')
          <li>
            <a class="waves-effect" href="{{ route('admin.member.index') }}">
              <i class="bx bxs-user-circle"></i>
              <span key="t-stock">Member</span>
            </a>
          </li>
        @endcan --}}

        {{-- @can('view-sales')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-receipt"></i>
              <span key="t-sales">@lang('translation.Sales')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              <li><a href="#" key="t-invoice-list">@lang('translation.Invoice_List')</a></li>
              <li><a href="#" key="t-invoice-detail">@lang('translation.Invoice_Detail')</a>
              </li>
            </ul>
          </li>
        @endcan --}}

        @can('view-income-statement')
          <li>
            <a class="waves-effect" href="{{ route('admin.profit-loss.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-income-statement">Laba Rugi</span>
            </a>
          </li>
        @endcan

        {{-- @can('view-cash-flow')
          <li>
            <a class="waves-effect" href="{{ route('admin.cash.index') }}">
              <i class="bx bx-file"></i>
              <span key="t-cash-flow">Arus Kas</span>
            </a>
          </li>
        @endcan --}}

        @can('view-report')
          <li>
            <a class="waves-effect" href="{{ route('admin.report.index') }}">
              <i class="bx bx-chart"></i>
              <span key="t-report">Laporan Penjualan</span>
            </a>
          </li>
        @endcan

        @if (auth()->user()->can('view-cashier') ||
                auth()->user()->can('view-blog') ||
                auth()->user()->can('view-subscription') ||
                auth()->user()->can('view-chat'))
          <li class="menu-title" key="t-apps">@lang('translation.Apps')</li>
        @endif

        @can('view-cashier')
          <li>
            <a class="waves-effect" href="{{ route('admin.cashier.index') }}">
              <i class="bx bx-bx bx-server"></i>
              <span key="t-cashier">@lang('translation.Cashier')</span>
            </a>
          </li>
        @endcan

        @can('view-cashier')
        <li>
          <a class="waves-effect" href="{{ route('admin.member.index') }}">
            <i class="bx bxs-credit-card"></i>
            <span key="t-cashier">Tambah Member</span>
          </a>
        </li>
        @endcan

        {{-- @if (auth()->user()->can('view-profile') ||
                auth()->user()->can('view-settings'))
          <li class="menu-title" key="t-settings">@lang('translation.Settings')</li>
        @endif

        @can('view-profile')
          <li>
            <a class="waves-effect" href="javascript: void(0);">
              <i class="bx bx-user"></i>
              <span class="align-middle" key="t-profile">@lang('translation.Profile')</span>
            </a>
          </li>
        @endcan

        @can('view-settings')
          <li>
            <a class="waves-effect" href="javascript: void(0);">
              <i class="bx bx-wrench"></i>
              <span key="t-settings">@lang('translation.Settings')</span>
            </a>
          </li>
        @endcan --}}

        @if (auth()->user()->can('view-user') ||
                auth()->user()->can('view-role-permission') ||
                auth()->user()->can('view-user-management'))
          <li class="menu-title" key="t-user_management">@lang('translation.User_Management')</li>
        @endif

        @can('view-user')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bxs-user-detail"></i>
              <span key="t-Users">@lang('translation.Users')</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
              <li><a href="{{ route('admin.users.index') }}">@lang('translation.Users_List')</a></li>
              {{-- <li><a href="{{ route('admin.customers.index') }}" key="t-customers-list">@lang('translation.Customers')</a></li> --}}
            </ul>
          </li>
        @endcan

        {{-- @can('view-role-permission')
          <li>
            <a class="has-arrow waves-effect" href="javascript: void(0);">
              <i class="bx bx-share-alt"></i>
              <span key="t-role-permission">@lang('translation.Role_Permission')</span>
            </a>
            <ul class="sub-menu" aria-expanded="true">
              <li><a href="{{ route('admin.roles.index') }}" key="t-roles">@lang('translation.Roles')</a></li>
              <li><a href="{{ route('admin.permissions.index') }}" key="t-permissions">@lang('translation.Permissions')</a></li>
            </ul>
          </li>
        @endcan --}}

      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->
