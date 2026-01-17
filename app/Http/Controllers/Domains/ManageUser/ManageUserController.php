<?php

namespace App\Http\Controllers\Domains\ManageUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titlePage = 'Management User';

        // Konfigurasi DataTable
        $dataTableConfig = $this->getDataTableConfig();

        $compact = compact('titlePage', 'dataTableConfig');
        return view('pages.Domains.ManageUser.index', $compact);
    }

    /**
     * Get DataTable configuration
     *
     * @return array
     */
    private function getDataTableConfig()
    {
        return [
            'tableId' => 'users-table',
            'ajaxUrl' => route('manage.users.datatable'),
            'columns' => [
                [
                    'data' => null,
                    'name' => 'no',
                    'label' => 'No',
                    'searchable' => false,
                    'orderable' => false,
                    'render' => 'rowNumber' // Special render type
                ],
                [
                    'data' => 'name',
                    'name' => 'name',
                    'label' => 'Nama',
                    'searchable' => true,
                    'orderable' => true,
                ],
                [
                    'data' => 'email',
                    'name' => 'email',
                    'label' => 'Email',
                    'searchable' => true,
                    'orderable' => true,
                ],
                [
                    'data' => 'role',
                    'name' => 'role',
                    'label' => 'Role',
                    'searchable' => true,
                    'orderable' => true,
                ],
                [
                    'data' => 'status',
                    'name' => 'status',
                    'label' => 'Status',
                    'searchable' => true,
                    'orderable' => true,
                    'render' => 'status', // Special render type
                    'statusMap' => [
                        'active' => ['label' => 'Aktif', 'class' => 'success'],
                        'inactive' => ['label' => 'Tidak Aktif', 'class' => 'danger'],
                        'pending' => ['label' => 'Pending', 'class' => 'warning']
                    ]
                ],
                [
                    'data' => 'created_at',
                    'name' => 'created_at',
                    'label' => 'Tanggal Dibuat',
                    'searchable' => false,
                    'orderable' => true,
                    'render' => 'date', // Special render type
                    'dateFormat' => 'DD/MM/YYYY HH:mm'
                ],
                [
                    'data' => 'action',
                    'name' => 'action',
                    'label' => 'Aksi',
                    'searchable' => false,
                    'orderable' => false,
                    'render' => 'actions', // Special render type
                    'buttons' => [
                        'view' => true,
                        'edit' => true,
                        'delete' => true
                    ]
                ]
            ],
            'order' => [[1, 'asc']], // Order by nama (index 1)
            'pageLength' => 10,
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'url' => route('manage.users') . '/view', // TODO: implement route
                ],
                'edit' => [
                    'enabled' => true,
                    'url' => route('manage.users') . '/edit', // TODO: implement route
                ],
                'delete' => [
                    'enabled' => true,
                    'url' => route('manage.users') . '/delete', // TODO: implement route
                    'confirm' => true,
                    'confirmMessage' => 'Apakah Anda yakin ingin menghapus user ini?'
                ]
            ]
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
