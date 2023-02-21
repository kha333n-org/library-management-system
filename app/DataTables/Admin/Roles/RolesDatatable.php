<?php

namespace App\DataTables\Admin\Roles;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function (Role $role) {
                return Carbon::parse($role->created_at)->diffForHumans();
            })
            ->editColumn('updated_at', function (Role $role) {
                return Carbon::parse($role->updated_at)->diffForHumans();
            })
            ->addIndexColumn()
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
