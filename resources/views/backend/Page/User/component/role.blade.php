<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="text-center text-uppercase "> Bảng show các roles active</h2>
                <div>
                    <form action="{{ route('private-system.management.configuration.permissions.change') }}" method="POST"> 
                     @csrf
                     @method('PUT') 
                     @if (!empty($permissions))
                        <table class="table table-bordered">
                            <tr>
                                <th></th>
                                @foreach ($roles as $role)
                                    <th class="text-center">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                       
                         @foreach ($permissions as $permission)
                             <tr>      
                                <td>{{ $permission->name }}</td>
                                @foreach ($roles as $role) 
                                   @php
                                //    dd($role->permissions);
                                       $array = [];
                                       foreach ($role->permissions as $value) {
                                           $array[] = $value->id;
                                       }
                                   @endphp
                                    <td>
                                        <input class="form-control" {{ in_array($permission->id,$array) ? 'checked' : '' }}  type="checkbox" value="{{ $permission->id }}" name="permissions[{{ $role->id }}][]">
                                    </td>                        
                                @endforeach
                                
                             </tr>
                         @endforeach
                        </table>
                     @endif   
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>                               
                    </form>
                </div>
            </div>
        </div>
        </div>
   </div>
</div>