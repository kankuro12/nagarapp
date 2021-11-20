@extends('layout.app')

@section('s-title')
/ <a href="{{route('superadmin.user.index')}}">Users</a> / Add
@endsection
@section('content')
<div class="card shadow mb-4 p-4">
    <form action="{{route('superadmin.user.add')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" required class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" required class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" required class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Municipality">Municipality *</label>
                    <select name="mun" id="mun" class="form-control" required>
                        @foreach (\App\Data::muns as  $key=>$mun)
                            <option value="{{$key}}">{{$mun}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="passord" name="password" id="password" required class="form-control" required>
                </div>
            </div>
            <div class="col-md-3 pt-4">
                <div class="form-group pt-1 ">
                    <button class="btn btn-primary">
                        Add User
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
