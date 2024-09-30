@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
    <h1 class="mb-4">Product Management</h1>
    <button class="btn btn-primary mb-3" id="btnCrearProducto">Create Product</button>
    
    <table class="table table-bordered" id="productosTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

    @include('components.form')
    @include('components.confirm')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#productosTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'category.name', name: 'category.name'},
                {data: 'status', name: 'status', render: function(data) {
                    return data ? 'Active' : 'Offline';
                }},
                {data: 'created_at', name: 'created_at', render: function(data) {
                    return moment(data).format('MM/DD/YYYY');
                }},
                {data: 'updated_at', name: 'updated_at', render: function(data) {
                    return moment(data).format('MM/DD/YYYY');
                }},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            rowCallback: function(row, data) {
                if (data.status) {
                    $(row).css('background-color', '#d4edda'); // Green background for Active
                } else {
                    $(row).css('background-color', '#f8d7da'); // Red background for Offline
                }
            }
        });

        $('#categoria').select2({
            width: 'resolve',
            ajax: {
                url: '{{ route("categories.index") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#btnCrearProducto').click(function() {
            $('#productoForm')[0].reset();
            $('#productoId').val('');
            $('#productoModalLabel').text('Create Product');
            $('#productoModal').modal('show');
        });

        $('#btnGuardarProducto').click(function() {
            var id = $('#productoId').val();
            var url = id ? "{{ route('products.update', ':id') }}".replace(':id', id) : "{{ route('products.store') }}";
            var method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    name: $('#nombre').val(),
                    description: $('#descripcion').val(),
                    price: $('#precio').val(),
                    category_id: $('#categoria').val(),
                    status: $('#estado').val()
                },
                success: function(response) {
                    $('#productoModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#productosTable').on('click', '.btnEditar', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#productoId').val(data.id);
            $('#nombre').val(data.name);
            $('#descripcion').val(data.description);
            $('#precio').val(data.price);
            $('#estado').val(data.status ? '1' : '0');
            $('#productoModalLabel').text('Edit Product');

            // Set the category value in Select2
            var option = new Option(data.category.name, data.category_id, true, true);
            $('#categoria').append(option).trigger('change');

            $('#productoModal').modal('show');
        });

        $('#productosTable').on('click', '.btnEliminar', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#confirmarEliminarModal').data('id', data.id).modal('show');
        });

        $('#btnConfirmarEliminar').click(function() {
            var id = $('#confirmarEliminarModal').data('id');
            $.ajax({
                url: "{{ route('products.destroy', ':id') }}".replace(':id', id),
                method: 'DELETE',
                success: function(response) {
                    $('#confirmarEliminarModal').modal('hide');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection