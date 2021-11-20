@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('s-title')
/ Users
@endsection
@section('content')

<div class="row">
    <div class="col-md-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member Level</h6>
                <hr>
                <form action="{{route('superadmin.setting.memberlevel.add')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="name" id="name" required class="form-control" placeholder="Enter Member Type" >
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100">Add </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mls as $ml)
                            <tr>
                                <td>
                                    <form action="{{route('superadmin.setting.memberlevel.edit',['ml'=>$ml->id])}}" method="post" id="ml_update_{{$ml->id}}">
                                        @csrf
                                        <input type="text" value="{{$ml->name}}" class="form-control" name="name">
                                    </form>

                                </td>
                                <td>
                                    <button class="btn btn-success" onclick="document.getElementById('ml_update_{{$ml->id}}').submit();" >
                                        <i class="fas fa-save"></i>
                                    </button>
                                    <a class="btn btn-danger" href="{{route('superadmin.setting.memberlevel.del',['ml'=>$ml->id])}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member Type</h6>
                <hr>
                <form action="{{route('superadmin.setting.membertype.add')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="name" id="name" required class="form-control" placeholder="Enter Member Type" >
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100">Add </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mts as $mt)
                                <tr>
                                    <td>
                                        <form action="{{route('superadmin.setting.membertype.edit',['mt'=>$mt->id])}}" method="post" id="mt_update_{{$mt->id}}">
                                            @csrf
                                            <input type="text" value="{{$mt->name}}" class="form-control" name="name">
                                        </form>

                                    </td>
                                    <td>
                                        <button class="btn btn-success" onclick="document.getElementById('mt_update_{{$mt->id}}').submit();" >
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <a class="btn btn-danger" href="{{route('superadmin.setting.membertype.del',['mt'=>$mt->id])}}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        $('#dataTable1').DataTable();
        $('#dataTable2').DataTable();
    });

@endsection
