<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">Create Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="productoForm">
                    <input type="hidden" id="productoId">
                    <div class="form-group">
                        <label for="nombre">Name</label>
                        <input type="text" class="form-control" id="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Description</label>
                        <textarea class="form-control" id="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Price</label>
                        <input type="number" class="form-control" id="precio" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Category</label>
                        <select class="form-control select2" id="categoria" required style="width: 100%;">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Status</label>
                        <select class="form-control" id="estado" required>
                            <option value="1">Active</option>
                            <option value="0">Offline</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnGuardarProducto">Save</button>
            </div>
        </div>
    </div>
</div>