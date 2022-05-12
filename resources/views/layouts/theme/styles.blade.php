<script src="{{ asset('assets/js/loader.js') }}"></script>
<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/print.css') }}" media="print">
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/apps/scrumboard.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('assets/css/apps/notes.css') }}">










<style>
    aside {
        display: none !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #ffffff;
        background-color: #3b3f5c;
        border-color: #3b3f5c;
    }

    

.widget-chart-one .widget-heading .tabs a{
        background: #3b3f5c;
    }

    @media (max-width:480px) {
        .mtmobile {
            margin-bottom: 20px !important;
        }

        .mbmobile {
            margin-bottom: 10px !important;
        }

        .hideonm {
            display: none !important;
        }

        .indblock {
            display: block;
        }



    }

    .table>thead>tr>th {
        color: #ff7600 !important;
        font-weight: 500;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .table>thead>tr {
        background: #383838 !important;
    }
    
    .sidebar-theme #compactSidebar {
        background: #343434 !important;
    }
    
    .my-custom-scrollbar {
position: relative;
height: 200px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
.disabled {
    cursor: not-allowed;
    pointer-events: none;
}
.navbar .navbar-item .nav-item .form-inline.search .search-form-control {
    width: 100%;
    width: 255px;
    height: 40px;
    background-color: #fbfbfb;
}


</style>

<link type="text/css" rel="stylesheet" href="{{ asset('plugins/flatpickr/flatpickr.dark.css') }}">

<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_custom.css">

@livewireStyles
