
<div class="d-flex flex-shrink-0">

    @if(auth()->user()->hasPermission('brands.view_any'))
        <a target="_blank" href="{{route('admin.brands.show', $id)}}">
            <span class="btn btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('brands.update'))
    <a href="{{route('admin.brands.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <i class="ki-outline ki-pencil fs-2"></i>
    </a>
    @endif

    @if(auth()->user()->hasPermission('brands.delete'))
    <a onclick="showDeleteModal({{$id}})" data-id="{{$id}}"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
        <i class="ki-outline ki-trash fs-2"></i>
    </a>
    @endif
</div>




