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
                                <h4 class="n_h2_style rounded">All Shift Notes</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Shift Note..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="shiftNoteTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>                                               
                                                
                                                <th scope="col">Shift End Date</th>
                                                <th scope="col">Staff Name</th>
                                                <th scope="col">Shop Name</th>
                                                <th scope="col">Note</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shiftNotes as $shiftNote)
                                            <tr>
                                                <td>{{ $shiftNote->shift->end_date }}</td>
                                                <td>{{ $shiftNote->shift->staff->staff_name }}</td>
                                                <td>{{ $shiftNote->shift->shop->name }}</td>
                                                <td>{{ $shiftNote->note }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

<script>    
    document.addEventListener('DOMContentLoaded', function() {
        // SEARCH   
        const searchInput = document.getElementById('searchInput');
        const billImageTable = document.getElementById('shiftNoteTable');
        const tableRows = billImageTable.getElementsByTagName('tr');
    
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const endDateColumn = row.cells[0];
                const staffColumn = row.cells[1];
                const shopColumn = row.cells[2];
                const noteColumn = row.cells[3];
                if (endDateColumn && staffColumn && shopColumn && noteColumn) {
                    const endDateText = endDateColumn.textContent.toLowerCase();
                    const staffText = staffColumn.textContent.toLowerCase();
                    const shopText = shopColumn.textContent.toLowerCase();
                    const noteText = noteColumn.textContent.toLowerCase();
                    if (endDateText.includes(query) || staffText.includes(query) || shopText.includes(query) || noteText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
    </script>








