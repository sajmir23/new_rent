
<div class="d-flex flex-shrink-0">

    @if(auth()->user()->hasPermission('models.view_any'))
        <a target="_blank" href="{{route('admin.vehicle_model.show', $id)}}">
            <span class="btn btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('models.update'))
    <a href="{{route('admin.vehicle_model.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <i class="ki-outline ki-pencil fs-2"></i>
    </a>
    @endif

    @if(auth()->user()->hasPermission('vehicle_model.delete'))
    <a onclick="showDeleteModal({{$id}})" data-id="{{$id}}"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
        <i class="ki-outline ki-trash fs-2"></i>
    </a>
    @endif
</div>




