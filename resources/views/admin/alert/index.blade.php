@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/tag/tagsinput.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('toolbar')
<a href="{{route('admin.alert.add')}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add Alert</a>
@endsection
@section('s-title')
/ Alerts
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
                        <th>Title</th>
                        <th>Message</th>
                        <th>Sent</th>

                        <th></th>
                    </tr>
                </thead>
                <body>
                    @foreach ($alerts as $alert)
                        <tr id="row-{{$alert->id}}">
                            <th>
                                {{$alert->title}}
                            </th>
                            <td>
                                {{$alert->msg}}
                            </td>
                            <td>
                                {{$alert->created_at}}
                            </td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('admin.alert.view',['alert'=>$alert->id])}}" >View</a>
                                        {{-- <a class="dropdown-item" href="{{route('admin.member.del',['member'=>$alert->id])}}" >Del</a> --}}
                                        <a class="dropdown-item" href="{{route('admin.alert.del',['alert'=>$alert->id])}}" >Del</a>
                                    </div>
                                  </div>

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
