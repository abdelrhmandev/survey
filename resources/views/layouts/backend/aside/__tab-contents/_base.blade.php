<div class="aside-menu flex-column-fluid" id="kt_aside_menu">
<div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
    <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
        
        @if(request()->routeIs('admin.dashboard'))
        <div class="menu-item here show py-2">
            <span class="menu-link menu-center">
                <span class="menu-icon me-0">
                    <i class="ki-outline ki-home-2 fs-2x"></i>
                </span>
                <span class="menu-title"><a href="{{ route('admin.dashboard')}}">{{ __('site.home') }}</a></span>
            </span>
        </div>
        @else
        <div class="menu-item py-2">
            <span class="menu-link menu-center">
                <span class="menu-icon me-0">
                    <i class="ki-outline ki-home-2 fs-2x"></i>
                </span>
                <a href="{{ route('admin.dashboard')}}">
                    <span class="menu-title">{{ __('site.home') }}</span>
                </a>
            </span>            
        </div>
        @endif
        
      
        @include('layouts.backend.aside.__tab-contents.includes.user')

        {{-- @include('layouts.backend.aside.__tab-contents.includes.type') --}}

         @include('layouts.backend.aside.__tab-contents.includes.brand') 


        {{-- @include('layouts.backend.aside.__tab-contents.includes.event') --}}

        @include('layouts.backend.aside.__tab-contents.includes.game')
        
         @include('layouts.backend.aside.__tab-contents.includes.question') 

       



    </div>
</div>
</div>
