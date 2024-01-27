<div class="card card-flush py-4">
    <div class="card-header">
        <div class="card-title">
            <h2>{{ __('question.plural')}} {{  $questions }}</h2>
        </div>
    </div>
    <div class="card-body pt-0">      
        @if($questions < 1 )
        <span class="badge py-3 px-4 fs-7 badge-light-primary">No Questions Added Yet</span>
        @endif
       <div class="card-body d-flex flex-column flex-center">
            <div class="mb-2">
                <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                    Add Questions For this games?                    
                <div class="py-10 text-center">
                <img src="{{ asset('assets/backend/media/svg/illustrations/easy/1.svg') }}" class="theme-light-show w-200px" alt="" />
                <img src="{{ asset('assets/backend/media/svg/illustrations/easy/1-dark.svg') }}" class="theme-dark-show w-200px" alt="" />
                </div>
            </div>
            <div class="text-center mb-1">
                <a href="{{ route('admin.games.create') }}" class="btn btn-sm btn-primary me-2">Add</a>
            </div>
        </div>
    </div>
</div>