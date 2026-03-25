<div class="d-flex flex-shrink-0">
    @if(auth()->user()->hasPermission('vehicles.view_any'))
        <a target="_blank" href="{{route('company.vehicles.show', $id)}}">
            <span class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('vehicles.update'))
        <a href="{{route('company.vehicles.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <i class="ki-outline ki-pencil fs-2"></i>
        </a>
    @endif

    @if(auth()->user()->hasPermission('vehicles.delete'))
        <a onclick="showDeleteModal({{$id}})" data-id="{{$id}}"  class="btn btn-icon btn-light-danger btn-active-color-white btn-sm">
            <i class="ki-outline ki-trash fs-2"></i>
        </a>
    @endif
</div>



