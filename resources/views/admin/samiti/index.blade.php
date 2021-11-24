@extends('layout.app')
@section('css')
@endsection

@section('s-title')
/ Samiti
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body" id="table-holder">
        <form action="{{route('admin.samiti.add')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-3 pt-5">
                    <input type="checkbox" name="show" id="show" value="1"> Show On Home
                </div>
                <div class="col-md-3">
                     <label for="order">Order</label>
                    <input type="number" class="form-control" id="order" name="order" required>
                </div>

                <div class="col-md-3 pt-3">
                    <button class="btn btn-primary w-100">Add Samiti</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="card shadow mb-4">

    <div class="card-body" id="table-holder">
        @foreach ($samitis as $samiti)
            @include('admin.samiti.single',['samiti'=>$samiti])
        @endforeach
    </div>
</div>

@endsection
@section('script')
<script>
    var table;
    $(document).ready(function() {

    });
</script>
@endsection
