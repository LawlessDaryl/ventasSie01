<!-- Fonts and icons -->
<script src="assets/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {"families":["Lato:300,400,700,900"]},
        custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>


<link rel="icon" href="{{ asset('assets/img/fav08.png') }}" type="image/x-icon"/>
<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">





<style>


    /* ESTILOS PARA LAS TABLAS */




    /* Tabla Pequeña */
    .table-1 {
    width: 100%;/* Anchura de ejemplo */
    height: 300px;  /*Altura de ejemplo*/
    overflow: auto;
    }

    .table-1 table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #02b1ce;
        border-bottom: 0.3px solid #02b1ce;
        width: 100%;
    }
    .table-1 table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-1 table thead tr {
    background: #02b1ce;
    color: white;
    }
    .table-1 table tbody tr:hover {
        background-color: #bbf7ffa4;
    }
    .table-1 table td {
        border-top: 0.3px solid #02b1ce;
        padding-left: 8px;
        padding-right: 8px;
        border-right: 0.3px solid #02b1ce;
    }

</style>

@livewireStyles
