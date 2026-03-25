<div class="symbol symbol-50px me-5">
    @if($company->logo)
        <img src="{{ Storage::url($company->logo) }}" alt="Company Logo" class="img-fluid rounded" />
    @else
        <span class="badge bg-light-warning text-dark">No Logo</span>
    @endif
</div>
