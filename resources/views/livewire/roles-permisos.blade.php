
            
        <div class="modal-content">
          <div class="modal-card card">
            <div class="card-header">
    
              <!-- Title -->
              <h4 class="card-header-title" id="ModalTitle">
                Administrar roles
              </h4>
    
              <!-- Close -->
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select id="rol" wire:model="idrol" name="rol" class="form-control">
                                    <option value="0">Nuevo rol</option> 
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" data-rolname="{{ $rol->name }}" data-profile="{{ $rol->profile }}" data-guard="{{ $rol->guard_name }}">{{ $rol->name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rolname">Nombre del rol</label>
                                <input type="text" class="form-control" name="rolname" id="rolname" wire:model="rol.name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="permission">Permisos</label>
                            <div class="form-check" id="permisos-check">
                                <input type="checkbox" wire:model="permission" name="permission[]" value="usuarios" id="usuarios" class="form-check-input"> <label for="usuarios">Usuarios</label><br>
                                <input type="checkbox" wire:model="permission" name="permission[]" value="roles" id="roles" class="form-check-input"> <label for="roles">Roles</label><br>
                                <input type="checkbox" wire:model="permission" name="permission[]" value="modificacion" id="modificacion" class="form-check-input"> <label for="ingresos">Modificación</label><br>
                                <input type="checkbox" wire:model="permission" name="permission[]" value="reportes" id="reportes" class="form-check-input"> <label for="noticias">Reportes</label><br>
                                <input type="checkbox" wire:model="permission" name="permission[]" value="precios" id="precios" class="form-check-input"> <label for="noticias">Precios</label><br>
                                <input type="checkbox" wire:model="permission" name="permission[]" value="catalogo" id="catalogo" class="form-check-input"> <label for="noticias">Catalogos</label><br>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-round btn-primary" wire:click="role" wire:loading.attr="disabled">Guardar cambios</button>
                <div wire:loading wire:target="role">
                    Procesando...
                </div>
            </div>
            
      </div>
    </div>