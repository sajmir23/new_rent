<div class="d-flex flex-shrink-0">

    @if(auth()->user()->hasPermission('fuel_types.view_any'))
        <a target="_blank" href="{{route('admin.fuel_types.show',$id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <i class="ki-outline ki-eye fs-2"></i>
        </a>

    @endif

    @if(auth()->user()->hasPermission('fuel_types.update'))
        <a href="{{route('admin.fuel_types.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <i class="ki-outline ki-pencil fs-2"></i>
        </a>
    @endif

    @if(auth()->user()->hasPermission('fuel_types.delete'))
        <a onclick="showDeleteModal({{$id}})" data-id="{{$id}}"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
            <i class="ki-outline ki-trash fs-2"></i>
        </a>
    @endif
</div>




