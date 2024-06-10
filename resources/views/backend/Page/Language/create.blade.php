@extends('backend.layout.layout');
@section('title')
    Quản lý ngôn ngữ
@endsection
@section('content')
   
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="min-height:60px">
                {{ Breadcrumbs::render('languages-create') }}           
                   
                
            </div>
            <div class="ibox-content">
                <div>
                     <form action="{{ route('private-system.management.configuration.language.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div style="margin: 20px 0px;">
                            <h3 class="text-success">{{ $filter['create']['title'] }}</h3>
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Tên (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('name') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Mô tả (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('desc') }}" name="desc" class="form-control">
                            </div>
                            @if ($errors->has('desc'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('desc') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 8px"><label class="col-sm-2 control-label">Canonical (*)</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{ old('canonical ') }}" name="canonical" class="form-control">
                            </div>
                            @if ($errors->has('canonical'))
                                <div class="mt-3 text-left text-danger italic">{{ $errors->first('canonical') }}(*)</div>
                            @endif
                        </div>
                        <div class="form-group col-lg-12" style="margin-top: 8px">
                            <label class="col-sm-2 control-label"> Hình ảnh(*)</label>                 
                                <div class="input-group mb-3 col-lg-6 px-2 ckfinder_2" data-type="image">
                                    <input type="text" name="image" id="inputGroupFile01" class="form-control" >
                                  </div>
                             @if ($errors->has('image'))
                                <div class="mt-3 text-end text-danger italic">
                                    <span>{{ $errors->first('image') }}(*)</span>
                                </div>
                            @endif
                        </div>
                       <div class="hr-line-dashed"></div>
                       <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Tạo mới</button>
                            </div>
                        </div>
                      
                     </form>
                </div>
            </div>
         
        </div>
    </div>
@endsection

{{-- 
@push('scripts')
    <script>
        var button1 = document.getElementById( 'ckfinder-popup-1' );
        button1.onclick = function() {
            selectFileWithCKFinder( 'ckfinder-input-1' );
        };

        function selectFileWithCKFinder( elementId ) {
            CKFinder.popup( 
                {
                chooseFiles: true,
                displayFoldersPanel: false,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        var file = evt.data.files.first();
                        console.log(file)
                        var output = document.getElementById( elementId );
                        output.value = file.getUrl();
                        console.log(output.value );
                    } );

                    finder.on( 'file:choose:resizedImage', function( evt ) {
                        var output = document.getElementById( elementId );
                        output.value = evt.data.resizedUrl;
                    } );
                }
            } 
            );
        }
    </script>
@endpush --}}
     