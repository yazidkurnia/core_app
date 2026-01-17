@extends('layouts.master')

@section('content')
    <div class="section-header">
        <h1>{{ $titlePage }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">{{ $titlePage }}</a></div>
            <div class="breadcrumb-item">Home</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data User</h4>
                        <div class="card-header-action">
                            <button class="btn btn-primary" id="btn-add">
                                <i class="fa fa-plus"></i> Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="users-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatable-helper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable menggunakan DataTableHelper
            var usersTable = DataTableHelper.init('users-table', {
                ajax: {
                    url: '{{ route('manage.users.datatable') }}',
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: DataTableHelper.formatStatus({
                            'active': {label: 'Aktif', class: 'success'},
                            'inactive': {label: 'Tidak Aktif', class: 'danger'},
                            'pending': {label: 'Pending', class: 'warning'}
                        })
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: DataTableHelper.formatDate('DD/MM/YYYY HH:mm')
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                        render: DataTableHelper.actionButtons({
                            view: true,
                            edit: true,
                            delete: true
                        })
                    }
                ],
                order: [[1, 'asc']]
            });

            // Bind action button events
            DataTableHelper.bindActions('users-table', {
                view: function(id) {
                    console.log('View user:', id);
                    // TODO: Implement view functionality
                    alert('View user ID: ' + id);
                },
                edit: function(id) {
                    console.log('Edit user:', id);
                    // TODO: Implement edit functionality
                    alert('Edit user ID: ' + id);
                },
                delete: function(id) {
                    console.log('Delete user:', id);
                    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                        // TODO: Implement delete functionality
                        alert('Delete user ID: ' + id);
                    }
                }
            });

            // Button tambah user
            $('#btn-add').on('click', function() {
                // TODO: Implement add user functionality
                alert('Tambah user - belum diimplementasikan');
            });
        });
    </script>
@endpush
