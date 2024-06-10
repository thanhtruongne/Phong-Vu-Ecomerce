@extends('backend.layout.layout');
@section('title')
    Quản lý Promotion
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="display: flex;justify-content:space-between;align-items:center">
                {{ Breadcrumbs::render('promotion-index') }}>
               
            </div>
            <div class="ibox-content">
                <div class="" style="display: flex;justify-content: space-between;align-items:center">
                    <form action="{{ url()->current() }}" style="width: 80%;display: flex;justify-content: space-between;align-items:center">
                    <div class="col-sm-3 m-b-xs">
                        @include('backend.Page.sale.promotion.component.record',['data' => $filter['record']])
                    </div>
                    <div style="display: flex;align-items:center">
                        <div>
                          @include('backend.Page.sale.promotion.component.filter')
                        </div>  
                    </div>
                    </form>
                    <div>
                        <a href="{{ route('private-system.management.promotion.create') }}" class="btn btn-primary">Thiết lập promotion <i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-size: 12px">
                            <th>
                                <input type="checkbox" name="check_box_all" class="check_box_all_user">
                            </th>
                            <th>Tên chương trình </th>
                            <th colspan="1">Chiết khấu </th>                   
                            <th>Thông tin</th>
                            <th>Ngảy bắt đầu</th> 
                            <th>Ngảy kết thúc</th> 
                            <th>Tình trạng</th>
                            <th>Action</th>
                        </tr>
                       
                        </thead>
                        <tbody>
                            @if (!empty($promotion) && count($promotion) > 0)
                                @foreach ($promotion as $key => $item)
                                @php
                                   $startDate = \Carbon\Carbon::parse($item->startDate)->format('d/m/y H:i');
                                  
                                  if(!is_null($item->endDate) && $item->neverEndDate == null ) {
                                    $endDate = \Carbon\Carbon::parse($item->endDate)->format('d/m/y H:i');
                                    
                                  }
                                  $status = '';
            
                                  if(!is_null($item->endDate) && strtotime($item->endDate) - strtotime(now()) <=0) {
                                    $status = '<span class="text-danger">-hết hạn</span>';
                                  }
                                @endphp
                                  <tr style="font-size:13px">
                                      <td><input type="checkbox" value="{{ $item->id }}"  class="check_item" name="input[]"></td>
                                        <td>
                                            <div> {{ $item->name }} {!! $status !!} </div>
                                            <span class="text-primary" style="font-size:10px"> Mã: {{ $item->code }} </span>
                                        </td>       
                                        <td>{!! renderDiscountInfomation($item) !!}</td>    
                                      <td>{!! renderInfomationPromotion($item) !!}</td>    
                                      <td>{{ $startDate }}</td>    
                                      <td>
                                        {{ 
                                            ($item->neverEndDate == 'choose') ? 'Không thời hạn' : $endDate 
                                        }}
                                       </td>    
                                      <td class="js-switch-{{ $item->id }} text-center">
                                          @if ($item->status == 0)
                                          <input 
                                          type="checkbox" 
                                          class="js-switch change_status" 
                                          data-id="{{ $item->id }}"
                                          data-model = 'Promotion'  />
                                              
                                          @else
                                          <input 
                                          type="checkbox" 
                                          class="js-switch change_status" 
                                          data-id="{{ $item->id }}"
                                          data-model = 'Promotion'  checked />
                                          @endif
                                      </td>                   
                                      <td>
                                          <a href="{{ route('private-system.management.promotion.edit',$item->id) }}" class="btn btn-info m-r-xs">Sửa</a>
                                          <a href="{{ route('private-system.management.promotion.remove',$item->id) }}" class="btn btn-danger delete_item">Xóa</a>
                                      </td>
                                  </tr>
                                @endforeach
  
                                  @else
                                  <tr class="text-center">
                                      <th> Danh sách trống !</th>
                                  </tr>
                                @endif
                          </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
