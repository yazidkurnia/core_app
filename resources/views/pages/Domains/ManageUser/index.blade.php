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
                            <table class="table table-striped table-hover" id="{{ $dataTableConfig['tableId'] }}">
                                <thead>
                                    <tr>
                                        @foreach($dataTableConfig['columns'] as $column)
                                            <th>{{ $column['label'] }}</th>
                                        @endforeach
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
        // Konfigurasi DataTable dari controller
        const dataTableConfig = @json($dataTableConfig);

        $(document).ready(function() {
            // Build columns configuration
            const columns = dataTableConfig.columns.map(column => {
                let columnConfig = {
                    data: column.data,
                    name: column.name,
                    searchable: column.searchable,
                    orderable: column.orderable
                };

                // Handle different render types
                if (column.render) {
                    switch(column.render) {
                        case 'rowNumber':
                            columnConfig.render = function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            };
                            break;
                        case 'status':
                            columnConfig.render = DataTableHelper.formatStatus(column.statusMap);
                            break;
                        case 'date':
                            columnConfig.render = DataTableHelper.formatDate(column.dateFormat);
                            break;
                        case 'actions':
                            columnConfig.render = DataTableHelper.actionButtons(column.buttons);
                            break;
                    }
                }

                return columnConfig;
            });

            // Inisialisasi DataTable menggunakan DataTableHelper
            const usersTable = DataTableHelper.init(dataTableConfig.tableId, {
                ajax: {
                    url: dataTableConfig.ajaxUrl,
                    type: 'GET'
                },
                columns: columns,
                order: dataTableConfig.order,
                pageLength: dataTableConfig.pageLength
            });

            // Build action callbacks from config
            const actionCallbacks = {};

            if (dataTableConfig.actions.view && dataTableConfig.actions.view.enabled) {
                actionCallbacks.view = function(id) {
                    console.log('View user:', id);
                    // TODO: Implement view functionality
                    window.location.href = dataTableConfig.actions.view.url + '/' + id;
                };
            }

            if (dataTableConfig.actions.edit && dataTableConfig.actions.edit.enabled) {
                actionCallbacks.edit = function(id) {
                    console.log('Edit user:', id);
                    // TODO: Implement edit functionality
                    window.location.href = dataTableConfig.actions.edit.url + '/' + id;
                };
            }

            if (dataTableConfig.actions.delete && dataTableConfig.actions.delete.enabled) {
                actionCallbacks.delete = function(id) {
                    console.log('Delete user:', id);
                    const confirmMsg = dataTableConfig.actions.delete.confirmMessage ||
                                      'Apakah Anda yakin ingin menghapus data ini?';

                    if (dataTableConfig.actions.delete.confirm && !confirm(confirmMsg)) {
                        return;
                    }

                    // TODO: Implement delete functionality with AJAX
                    $.ajax({
                        url: dataTableConfig.actions.delete.url + '/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('User berhasil dihapus');
                            DataTableHelper.reload(usersTable, false);
                        },
                        error: function(xhr) {
                            alert('Gagal menghapus user: ' + xhr.responseJSON?.message);
                        }
                    });
                };
            }

            // Bind action button events
            DataTableHelper.bindActions(dataTableConfig.tableId, actionCallbacks);

            // Button tambah user
            $('#btn-add').on('click', function() {
                // TODO: Implement add user functionality
                alert('Tambah user - belum diimplementasikan');
            });
        });
    </script>
@endpush
