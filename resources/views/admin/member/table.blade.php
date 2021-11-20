<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Ward</th>
                <th></th>
            </tr>
        </thead>
        <body>
            @foreach ($users as $user)
                <tr id="row-{{$user->id}}">
                    <th>
                        {{$user->name}}
                    </th>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        {{$user->phone}}
                    </td>
                    <td>
                        {{$user->ward}}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-success " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('admin.member.edit',['member'=>$user->id])}}" >Edit</a>
                                {{-- <a class="dropdown-item" href="{{route('admin.member.del',['member'=>$user->id])}}" >Del</a> --}}
                                <a class="dropdown-item" href="#" onclick="deleteRow({{$user->id}},'{{$user->name}}',event)">Del</a>
                                <a class="dropdown-item" href="#" onclick="initChangePassword({{$user->id}},'{{$user->name}}',event)">Change Password</a>
                            </div>
                          </div>
                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>