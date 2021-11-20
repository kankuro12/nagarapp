@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection
@section('toolbar')
<a href="{{route('superadmin.user.add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add User</a>
@endsection
@section('s-title')
/ Users
@endsection
@section('content')
@php
    $muns=[];
    if(count($users)>0){
        $muns=\App\Data::muns;
    }
@endphp
<div class="card shadow mb-4">
    {{-- <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Local Body</th>
                        <th></th>
                    </tr>
                </thead>
                <body>
                    @foreach ($users as $user)
                        <tr>
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
                                {{$muns[$user->nagarcode]}}
                            </td>
                            <td>
                                <a href="{{route('superadmin.user.edit',['user'=>$user->id])}}" class="btn btn-sm btn-success">Edit</a>
                                <a href="{{route('superadmin.user.del',['user'=>$user->id])}}" class="btn btn-sm btn-danger">Del</a>
                                <button class="btn btn-sm btn-success" onclick="initChangePassword({{$user->id}},'{{$user->name}}')">Change Password</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="changepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Password For <span id="passname"></span></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" id="password">
            <input type="hidden" id="user_id">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" type="button" onclick="changePassword()">Update Passord</button>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    function initChangePassword(id,name){
        $('#changepass').modal('show');
        $('#user_id').val(id);
        $('#passname').html(name);

    }
    function changePassword(){
        $('#changepass').modal('hide');

        id=$('#user_id').val();
        pass=$('#password').val();
        $url="{{route('superadmin.user.changepass',['user'=>'xx_xx'])}}";
        $url=$url.replace('xx_xx',id);
        $('#password').val('');
        $('#user_id').val('');
        axios.post($url,{'password':pass})
        .then((res)=>{
            toastr.success("Password Updated Successfully");
        })
        .catch((err)=>{
            toastr.error("Cannot Update Password Please Try Again");
        });

    }
</script>
@endsection
