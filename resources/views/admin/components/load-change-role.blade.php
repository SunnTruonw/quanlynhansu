<a  class="btn btn-sm {{$data->role == 'admin' ? 'btn-success':'btn-warning'}} @if($authCheck->role == 'admin') lb-role @else unselectable  @endif" data-value="{{$data->role}}" data-type="{{$type?$type:''}}" >{{$data->role== 'admin' ?'Admin':'User'}}</a>
