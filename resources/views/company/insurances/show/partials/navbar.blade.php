<!--begin::Navbar-->
<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">

        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="{{asset('metronic/assets/media/svg/brand-logos/volicity-9.svg')}}" alt="image">
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">@lang('master.insurances.insurance') #{{$insurance->id}} </a>

                        </div>

                    </div>

                    <div class="d-flex mb-4">
                        <a href="{{route('company.insurances.index')}}" class="btn btn-sm btn-bg-light btn-active-color-primary me-3">@lang('master.insurances.all_insurances')</a>
                        <a href="{{route('company.insurances.create')}}" class="btn btn-sm btn-primary me-3">@lang('master.insurances.new_insurance')</a>
                    </div>
                </div>

                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">{{\Carbon\Carbon::parse($insurance->created_at)->format('d-m-Y')}}</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-500">@lang('master.insurances.created_date')</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
        </div>


        <div class="separator"></div>

        <!--begin::Nav-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link  @if(Route::currentRouteName() === 'company.insurances.show' ) active  @endif text-active-primary  py-5 me-6 " href="{{route('company.insurances.show',$insurance->id)}}">
                    @lang('master.navbar.show')

                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link  @if(Route::currentRouteName() === 'company.insurances.edit' ) active  @endif text-active-primary  py-5 me-6 " href="{{route('company.insurances.edit',$insurance->id)}}">
                    @lang('master.navbar.edit')

                </a>
            </li>
            <!--end::Nav item-->
        </ul>
        <!--end::Nav-->
    </div>
</div>
<!--end::Navbar-->
