@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Payment Method Management" />    
    {{-- <x-alert-message /> --}}
    
    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Shift Note</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('shiftNote.store') }}">                                
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="shift_note" class="form-label">Note:</label>
                                        <textarea class="form-control" id="shift_note" name="shift_note"></textarea>                                        
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" id="shift_id" name="shift_id" value="{{ $shift_id }}">
                                    </div>                                    
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%"><i class="fa-solid fa-floppy-disk me-1"></i> Save </button>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('shifts.index') }}" class="btn btn-secondary rounded-pill" style="width: 100%">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection








