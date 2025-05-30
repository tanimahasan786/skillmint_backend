@extends('backend.app')

@section('title', 'Courses List')

@push('style')
<style>
    .custom-confirm-button {
        background-color: #04AAF7 !important;
        /* Green */
        color: white !important;
    }

    .custom-cancel-button {
        background-color: #f72213 !important;
        /* Red */
        color: white !important;
    }

    /* Optional: Change button on hover */
    .custom-confirm-button:hover {
        background-color: #ff4e02;
        /* Darker green */
    }

    .custom-cancel-button:hover {
        background-color: #f51808;
        /* Darker red */
    }
</style>
<link rel="stylesheet" href="{{ asset('backend/vendors/datatable/css/datatables.min.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Booking List</h4>
                    <div class="table-responsive mt-4 p-4">
                        <table class="table table-hover" id="data-table">
                            <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Gateway</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
{{-- Datatable --}}
<script src="{{ asset('backend/vendors/datatable/js/datatables.min.js') }}"></script>
{{-- sweet alart --}}
<script src="{{ asset('backend/vendors/sweetalert/sweetalert2@11.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var searchable = [];
        var selectable = [];
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        });

        if (!$.fn.DataTable.isDataTable('#data-table')) {
            let dTable = $('#data-table').DataTable({
                order: [],
                lengthMenu: [
                    [10, 25, 50, 100, 200, 500, -1],
                    ["10", "25", "50", "100", "200", "500", "All"]
                ],

                pageLength: 10,
                processing: true,
                responsive: true,
                serverSide: true,

                language: {
                    processing: `<div class="text-center">
                            <img src="{{ asset('default/logo.png') }}" alt="Loader" style="width: 50px;">
                            </div>`
                },


                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                ajax: {
                    url: "{{ route('admin.booking.index') }}",
                    type: "get",
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'course',
                        name: 'course',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'gateway',
                        name: 'gateway',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'currency',
                        name: 'currency',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: true,
                        searchable: true
                    }
                ],
            });

            new DataTable('#example', {
                responsive: true
            });
        }
    });
</script>
@endpush