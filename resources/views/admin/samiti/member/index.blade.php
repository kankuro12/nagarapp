@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/tag/tagsinput.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('toolbar')
<a href="{{route('admin.samiti.member.add',['samiti_id'=>$samiti->id])}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Member</a>
@endsection
@section('s-title')
/ <a href="{{route('admin.samiti.index')}}">Samitis</a> / {{$samiti->name}}
@endsection
@section('content')

<div class="card shadow mb-4">
    {{-- <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div> --}}
    <div class="card-body" id="table-holder">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <body>
                    @foreach ($members as $member)
                        <tr id="row-{{$member->id}}">
                            <th>
                                {{$member->name}}
                            </th>
                            <td>
                                {{$member->phone}}
                            </td>
                            <td>
                                {{$member->address}}
                            </td>

                            <td>
                                <a class="btn btn-success" href="{{route('admin.samiti.member.edit',['member'=>$member->id])}}" >Edit</a>
                                <a class="btn btn-danger" href="{{route('admin.samiti.member.del',['member'=>$member->id])}}" >Del</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    var table;
    $(document).ready(function() {
        table=$('#dataTable').DataTable({
                "columnDefs": [
                    { "sortable":false,"searchable": false, "targets": 3 },
                    // {"sortable":false,"searchable": false, "targets": 2}
                ]
            });
    });
</script>
@endsection
