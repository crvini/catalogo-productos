@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Catálogo de Productos</h2>
    <button id="btnAgregar" class="btn btn-primary mb-3">Agregar Producto</button>
    <div id="tablaProductosWrapper">
        @include('products.tabla')
    </div>
    <nav><ul class="pagination" id="paginacion"></ul></nav>
</div>

@include('products.modal')
<script type="module" src="/js/productos/app.js"></script>
@endsection
