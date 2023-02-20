<?php

namespace App\DataTables\Admin\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersListDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (User $user) {
                return view('admin.users.buttons', compact('user'));
            })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->diffForHumans();
            })
            ->editColumn('updated_at', function ($user) {
                return Carbon::parse($user->updated_at)->diffForHumans();
            })
            ->editColumn('is_active', function (User $user) {
                return $user->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">In-Active</span>';
            })
            ->rawColumns(['is_active'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UsersList $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
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
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('address'),
            Column::make('phone_number'),
            Column::make('is_active'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
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
        return 'UsersList_' . date('YmdHis');
    }
}
