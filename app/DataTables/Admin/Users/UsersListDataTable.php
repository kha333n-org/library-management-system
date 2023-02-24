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
     * @return EloquentDataTable
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
            ->addColumn('roles', function (User $user) {
                $rolesHtml = '';
                $roles = $user->roles->take(3); // get the first 3 roles
                foreach ($roles as $role) {
                    $rolesHtml .= '<span class="badge badge-primary">' . $role->name . '</span> ';
                }
                if ($user->roles->count() > 3) {
                    $rolesHtml .= '<button type="button" class="btn btn-link" data-toggle="modal" data-target="#rolesModal-' . $user->id . '">...</button>';
                }
                $rolesHtml .= '<div class="modal fade" id="rolesModal-' . $user->id . '" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel-' . $user->id . '" aria-hidden="true">';
                $rolesHtml .= '<div class="modal-dialog" role="document">';
                $rolesHtml .= '<div class="modal-content">';
                $rolesHtml .= '<div class="modal-header">';
                $rolesHtml .= '<h5 class="modal-title" id="rolesModalLabel-' . $user->id . '">Roles for ' . $user->name . '</h5>';
                $rolesHtml .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                $rolesHtml .= '<span aria-hidden="true">&times;</span>';
                $rolesHtml .= '</button>';
                $rolesHtml .= '</div>';
                $rolesHtml .= '<div class="modal-body">';
                foreach ($user->roles as $role) {
                    $rolesHtml .= '<span class="badge badge-primary">' . $role->name . '</span> ';
                }
                $rolesHtml .= '</div>';
                $rolesHtml .= '<div class="modal-footer">';
                $rolesHtml .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
//                $rolesHtml .= '<a href="' . route('users.roles', $user->id) . '" class="btn btn-primary">View all roles</a>';
                $rolesHtml .= '</div>';
                $rolesHtml .= '</div>';
                $rolesHtml .= '</div>';
                $rolesHtml .= '</div>';
                return $rolesHtml;
            })
            ->editColumn('is_active', function (User $user) {
                return $user->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">In-Active</span>';
            })
            ->rawColumns(['is_active', 'roles'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return QueryBuilder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
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
            Column::computed('roles'),
            Column::make('is_active'),
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
        return 'UsersList_' . date('YmdHis');
    }
}
