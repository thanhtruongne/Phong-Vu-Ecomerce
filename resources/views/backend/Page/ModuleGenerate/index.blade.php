@extends('backend.layout.layout');
@section('title')
    Quản lý module
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('module-index') }}            
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.ModuleGenerate.component.record')
                    </div>

                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.ModuleGenerate.component.status')
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.ModuleGenerate.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.module.create') }}" class="btn btn-primary">Thêm mới module <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr >
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên module </th>
                            <th>Schema</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                         <tr class="text-center">
                             <th> Danh sách trống !</th>
                         </tr>
                       
                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
    </div>
@endsection
