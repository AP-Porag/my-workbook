<?php

namespace App\DataTables\Admin\User;

use PDF;
use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends DataTable
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
            ->addColumn('action', function ($item) {
                $buttons = '';
                $buttons .= '<a class="dropdown-item" href="' . route('admin.admins.edit', $item->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit </a>';

                $buttons .= '<form action="' . route('admin.admins.destroy', $item->id) . '"  id="delete-form-' . $item->id . '" method="post" style="">
<input type="hidden" name="_token" value="' . csrf_token() . '">
<input type="hidden" name="_method" value="DELETE">
<button class="dropdown-item text-danger" onclick="return makeDeleteRequest(event, ' . $item->id . ')"  type="submit" title="Delete"><i class="mdi mdi-trash-can-outline"></i> Delete</button></form>
';

                return '<div class="btn-group dropleft">
  <a href="#" onclick="return false;" class="btn btn-sm btn-dark text-white dropdown-toggle dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
  <div class="dropdown-menu">
  ' . $buttons . '
  </div>
</div>';
            })->editColumn('avatar', function ($item) {
                return '<img class="ic-img-32" src="' . $item->avatar_url . '" alt="' . $item->last_name . '" />';
            })->editColumn('name', function ($item) {
                return $item->full_name;
            })->editColumn('role', function ($item) {
//                return implode(", ", $item->roles->pluck('name')->toArray()) ?? '';
            })->editColumn('status', function ($item) {
                $badge = $item->status == GlobalConstant::STATUS_ACTIVE ? "bg-success" : "bg-danger";
                return '<span class="badge ' . $badge . '">' . Str::upper($item->status) . '</span>';
            })->filterColumn('name', function($query, $keyword) {
                $sql = "CONCAT(ic_users.first_name,'-',ic_users.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })->filterColumn('role', function($query, $keyword) {
                $sql = "first_name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->rawColumns(['action','avatar', 'status'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->orderBy('id', 'ASC')->where('user_type', User::USER_TYPE_ADMIN)->select('users.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'Action'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', 'SL#'),
            Column::make('avatar', 'avatar')->title('Avatar'),
            Column::make('name', 'name')->title('Name'),
            Column::make('email', 'email')->title('Email'),
            Column::make('phone', 'phone')->title('Phone'),
//            Column::make('role', 'role')->title('Roles'),
            Column::make('status', 'status')->title('Status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admins_' . date('YmdHis');
    }

    public function pdf()
    {
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ]);
        return $pdf->download($this->getFilename() . '.pdf');
    }
}
