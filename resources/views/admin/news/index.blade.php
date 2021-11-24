@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('toolbar')
<a href="{{route('admin.news.add')}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Add News</a>
@endsection
@section('s-title')
/ News
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
                        <th>Updated</th>

                        <th></th>
                    </tr>
                </thead>
                <body>
                    @foreach ($news as $_news)
                        <tr id="row-{{$_news->id}}">
                            <th>
                                {{$_news->title}}
                            </th>

                            <td>
                                {{$_news->updated_at}}
                            </td>

                            <td>
                                <a class="btn btn-success" href="{{route('admin.news.edit',['news'=>$_news->id])}}" >Edit</a>
                                <a class="btn btn-danger" href="{{route('admin.news.del',['news'=>$_news->id])}}" >Del</a>

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
