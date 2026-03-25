<div class="d-flex flex-shrink-0">

    @if(auth()->user()->hasPermission('cancellation_reasons.view_any'))
        <a target="_blank" href="{{route('admin.cancellation_reasons.show', $id)}}">
            <span class="btn btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('cancellation_reasons.update'))
        <a href="{{route('admin.cancellation_reasons.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <i class="ki-outline ki-pencil fs-2"></i>
        </a>
    @endif

    @if(auth()->user()->hasPermission('cancellation_reasons.delete'))
        <a onclick="showDeleteModal({{$id}})" data-id="{{$id}}"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
            <i class="ki-outline ki-trash fs-2"></i>
        </a>
    @endif
</div>




