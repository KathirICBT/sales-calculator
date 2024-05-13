<div class="mb-3">
    {{-- <h4>Owner Expense Report</h4> --}}
</div>
<div class="row">
    <div class="col-12 col-md-6 d-flex">
        <div class="card flex-fill border-0 illustration">
            <div class="card-body p-0 d-flex flex-fill">
                <div class="row g-0 w-100">
                    {{-- <div class="col-6">
                        <div class="p-3 m-1">
                            <h3>Welcome, {{ session('username') }}</h3>
                            <h6 class="mb-0">{{ $title }}</h6>
                        </div>
                    </div> --}}
                    @if(session()->has('username'))
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h3>Welcome, {{ session('username') }}</h3>
                                <h6 class="mb-0">{{ $title }}</h6>
                            </div>
                        </div>
                    @elseif(session()->has('adminusername'))
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h3>Welcome, {{ session('adminusername') }}</h3>
                                <h6 class="mb-0">{{ $title }}</h6>
                            </div>
                        </div>
                    @else
                        {{-- THIS CONSEPT NEED TO CHANGE --}}
                        <script>
                            window.location = "{{ route('auth.login') }}";
                        </script>
                        {{-- THIS CONSEPT NEED TO CHANGE END --}}
                    @endif
                    <div class="col-6 align-self-end text-end">
                        <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 d-flex">
        <div class="card flex-fill border-0">
            <div class="card-body py-4">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <p class="mb-2">Staff Name: </p>
                        <h4 class="mb-2">Total Sales: </h4>
                        <div class="mb-0">
                            <span class="text-muted">Owner:</span>
                            <span class="mb-2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>