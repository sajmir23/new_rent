
<div class="d-flex flex-shrink-0">
    @if(auth()->user()->hasPermission('company_admin.view_any'))
        <a target="_blank" href="{{route('admin.company_admin.show', $id)}}">
            <span class="btn btn-bg-light btn-active-color-primary btn-sm me-1" >
                <i class="ki-outline ki-eye fs-2"></i>
            </span>
        </a>
    @endif

    @if(auth()->user()->hasPermission('company_admin.update'))
        <a href="{{route('admin.company_admin.edit',['id' => $id])}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
            <i class="ki-outline ki-pencil fs-2"></i>
        </a>
    @endif

        @if(auth()->user()->hasPermission('impersonation.can_impersonate'))
            @if($id != auth()->id())
                <a href="{{route('admin.users.impersonate',$id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <i class="ki-outline ki-user fs-2"></i>
                </a>
            @endif
        @endif
</div>




