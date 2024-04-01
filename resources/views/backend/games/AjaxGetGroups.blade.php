<div class="d-flex flex-column gap-5">
    <div class="card card-custom">

        <div class="fv-row fl">
            <label class="required form-label" for="group">{{ __('group.select') }}</label>
            <div class="row mb-8">
                <div class="col-xl-12">
                    <div class="row g-12" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">

                        @forelse ($groups as $group)
                            <div class="col-md-4 col-lg-12 col-xxl-4">
                                <label
                                    class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6"
                                    data-kt-button="true">
                                    <span
                                        class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                        <input class="form-check-input" type="radio" name="group_id" value="{{ $group->id}}"/>
                                    </span>
                                    <span class="ms-5">
                                        <span class="fs-4 fw-bold mb-1 d-block">{{ $group->title }}</span>
                                        <span class="fw-semibold fs-7 text-gray-600">Questions ({{ $group->questions_count }}) </span>
                                    </span>
                                </label>
                            </div>
                        @empty
                        <div class="col-md-4 col-lg-12 col-xxl-4">       
                        no groups
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
