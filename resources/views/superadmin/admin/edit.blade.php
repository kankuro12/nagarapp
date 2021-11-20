@extends('layout.app')

@section('s-title')
/ <a href="{{route('superadmin.user.index')}}">Users</a> / {{$user->name}} / Edit
@endsection
@section('content')
<div class="card shadow mb-4 p-4">
    <form action="{{route('superadmin.user.edit',['user'=>$user->id])}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" required class="form-control" value="{{$user->name}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" required class="form-control" value="{{$user->email}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" required class="form-control" value="{{$user->phone}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Municipality">Municipality *</label>
                    <select name="mun" id="mun" class="form-control" required>
                        @foreach (\App\Data::muns as  $key=>$mun)
                            <option value="{{$key}}" {{$user->nagarcode==$key?'selected':''}}>{{$mun}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3 pt-4">
                <div class="form-group pt-1 ">
                    <button class="btn btn-primary">
                        Update User
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
