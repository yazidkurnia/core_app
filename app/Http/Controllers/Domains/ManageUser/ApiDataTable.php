<?php

namespace App\Http\Controllers\Domains\ManageUser;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class ApiDataTable extends Controller
{
    /**
     * Get users data for DataTable
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersData(Request $request)
    {
        // Ambil semua user dari database
        $users = User::all()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $this->getRoleName($user->role_id),
                'status' => $user->status,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        });

        // Setup DataTable Service
        $dataTable = new DataTableService($request);

        // Set data
        $dataTable->setData($users);

        // Set columns configuration
        $dataTable->setColumns([
            ['key' => 'name', 'label' => 'Nama', 'searchable' => true, 'orderable' => true],
            ['key' => 'email', 'label' => 'Email', 'searchable' => true, 'orderable' => true],
            ['key' => 'role', 'label' => 'Role', 'searchable' => true, 'orderable' => true],
            ['key' => 'status', 'label' => 'Status', 'searchable' => true, 'orderable' => true],
            ['key' => 'created_at', 'label' => 'Tanggal Dibuat', 'searchable' => false, 'orderable' => true],
            ['key' => 'action', 'label' => 'Aksi', 'searchable' => false, 'orderable' => false],
        ]);

        // Set primary key
        $dataTable->setPrimaryKey('id');

        // Generate dan return response
        return response()->json($dataTable->generate());
    }

    /**
     * Get role name by role_id
     *
     * @param int $roleId
     * @return string
     */
    private function getRoleName($roleId)
    {
        // TODO: Implement proper role mapping from database
        // For now using static mapping
        $roles = [
            1 => 'Administrator',
            2 => 'User',
            3 => 'Manager',
        ];

        return $roles[$roleId] ?? 'Unknown';
    }
}
