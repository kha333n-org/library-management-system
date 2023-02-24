<?php

namespace App\DataTables\Admin\Roles;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable(mixed $query): DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function (Role $role) {
                return Carbon::parse($role->created_at)->diffForHumans();
            })
            ->editColumn('updated_at', function (Role $role) {
                return Carbon::parse($role->updated_at)->diffForHumans();
            })
            ->addColumn('permissions', function (Role $role) {
                $permissionHtml = '';
                $permissions = $role->permissions->take(3); // get the first 3 roles
                foreach ($permissions as $permission) {
                    $permissionHtml .= '<span class="badge badge-primary">' . $permission->name . '</span> ';
                }
                if ($role->permissions->count() > 3) {
                    $permissionHtml .= '<button type="button" class="btn btn-link" data-toggle="modal" data-target="#rolesModal-' . $role->id . '">...</button>';
                }
                $permissionHtml .= '<div class="modal fade" id="rolesModal-' . $role->id . '" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel-' . $role->id . '" aria-hidden="true">';
                $permissionHtml .= '<div class="modal-dialog" role="document">';
                $permissionHtml .= '<div class="modal-content">';
                $permissionHtml .= '<div class="modal-header">';
                $permissionHtml .= '<h5 class="modal-title" id="rolesModalLabel-' . $role->id . '">Permissions for ' . $role->name . '</h5>';
                $permissionHtml .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                $permissionHtml .= '<span aria-hidden="true">&times;</span>';
                $permissionHtml .= '</button>';
                $permissionHtml .= '</div>';
                $permissionHtml .= '<div class="modal-body">';
                foreach ($role->permissions as $permission) {
                    $permissionHtml .= '<span class="badge badge-primary">' . $permission->name . '</span> ';
                }
                $permissionHtml .= '</div>';
                $permissionHtml .= '<div class="modal-footer">';
                $permissionHtml .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                $permissionHtml .= '</div>';
                $permissionHtml .= '</div>';
                $permissionHtml .= '</div>';
                $permissionHtml .= '</div>';
                return $permissionHtml;
            })
            ->addIndexColumn()
            ->rawColumns(['permissions'])
            ->addColumn('action', function (Role $role) {
                return view('admin.roles.buttons', compact('role'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->searching()
            ->deferRender()
            ->stateSave()
            ->pagingType('full_numbers')
            ->fixedHeaderHeader()
            ->responsive()
            ->autoWidth(false)
            ->select()->parameters(
                [
                    'select.className' => 'alert alert-success',
                    'select.blurable' => true,
                ]
            )
            ->orderBy(0, 'asc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::computed('permissions'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->width(130)
                ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Admin/Roles/Roles_' . date('YmdHis');
    }
}
