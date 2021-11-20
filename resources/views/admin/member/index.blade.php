@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/tag/tagsinput.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('toolbar')
<button class="btn btn-primary btn-sm" id="filter-show" onclick="$('#filter-holder').show();$('#filter-show').hide();">
   <i class="fas fa-list"></i> Filter 
</button>
<button class="btn btn-danger btn-sm" id="filter-show" onclick="refreshTable()">
    <i class="fas fa-redo"></i> Refresh 
 </button>
<a href="{{route('admin.member.add')}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Member</a>
@endsection
@section('s-title')
/ Users
@endsection
@section('content')
<div class="card shadow mb-4" id="filter-holder" >
     <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between">
            <span>Filter</span>
            <button class="btn btn-danger" onclick="$('#filter-holder').hide();$('#filter-show').show();"><i class="fas fa-times"></i></button>
        </h6>
    </div>
    <div class="card-body">
        @include('admin.member.selector')
    </div>
</div>
<div class="card shadow mb-4">
    {{-- <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div> --}}
    <div class="card-body" id="table-holder">
       
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
<script src="{{asset('vendor/tag/tagsinput.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    var table;
    $(document).ready(function() {
        loadTable();
        $('.select2').select2();$('#filter-holder').hide();
    });


    function refreshTable(){
        loadTable();
        document.getElementById('selector-table').reset();
    }
    

    function deleteRow(id,name,e){
        e.preventDefault();
        
        if(prompt("Enter YES To Delete").toLowerCase()=='yes'){
            axios.post("{{route('admin.member.del')}}",{"id":id})
            .then((res)=>{
                table.row( $('#row-'+id ))
                .remove()
                .draw();
                toastr.success('Member '+name+'Deleted Sucessfully');
            })
            .catch((err)=>{

            });
        }
    }
    function loadTableFromSelector(ele,e){
        e.preventDefault();
        const fd=new FormData(ele);
        axios.post("{{route('admin.member.load')}}",fd)
        .then((res)=>{
            $('#table-holder').html(res.data);
            table=$('#dataTable').DataTable({
                "columnDefs": [
                    { "sortable":false,"searchable": false, "targets": 4 }
                ]
            });
        })
        .catch((err)=>{

        });
    }
    function loadTable(){
        axios.get("{{route('admin.member.load')}}")
        .then((res)=>{
            $('#table-holder').html(res.data);
            table=$('#dataTable').DataTable({
                "columnDefs": [
                    { "sortable":false,"searchable": false, "targets": 4 }
                ]
            });
        })
        .catch((err)=>{

        });
    }
    function initChangePassword(id,name,e){
        e.preventDefault();
        $('#changepass').modal('show');
        $('#user_id').val(id);
        $('#passname').html(name);

    }
    function changePassword(){
        $('#changepass').modal('hide');

        id=$('#user_id').val();
        pass=$('#password').val();
        $url="{{route('admin.member.changepass',['member'=>'xx_xx'])}}";
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
