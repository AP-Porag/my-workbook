@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Users</h4>
                    {!! $dataTable->table(['class'=>'table-responsive']) !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    @include('includes.styles.datatable')
@endpush

@push('script')
    @include('includes.scripts.datatable')
@endpush
