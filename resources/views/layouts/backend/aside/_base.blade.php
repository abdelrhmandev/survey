				<!--begin::Aside-->
				<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Brand-->
					<div class="aside-logo py-8" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center">
							<img alt="Logo" src="{{ asset('assets/backend/media/logos/logo.svg')}}" class="h-45px logo" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					@include('layouts.backend.aside.__tab-contents._base')
					<!--end::Aside menu-->
					<!--begin::Footer-->
					 
					<!--end::Footer-->
				</div>
				<!--end::Aside-->
