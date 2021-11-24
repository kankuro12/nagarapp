@extends('layout.app')
@section('css')
    <!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('s-title')
/ <a href="{{route('admin.samiti.index')}}">Samiti</a>  /  <a href="{{route('admin.samiti.view',['samiti'=>$samiti->id])}}"> {{$samiti->name}}</a> / Members / {{$member->name}} / Edit
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body" id="table-holder">
        <form action="{{route('admin.samiti.member.edit',['member'=>$member->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <img id="old-image" src="{{asset($member->image)}}"  alt="" class="w-100" onclick="document.getElementById('image').click();">
                    <input type="file" id="image" name="image"  accept="image/*" class="d-none">
                </div>
                <div class="col-md-2">
                    <span class="btn btn-primary" onclick="document.getElementById('image').click();">
                        <i class="fas fa-image"></i>
                    </span>
                    <span class="btn btn-danger" onclick="clearImage()">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-6 pt-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{$member->name}}">
                </div>
                <div class="col-md-6 pt-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{$member->address}}">
                </div>
                <div class="col-md-6 pt-3">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required value="{{$member->phone}}">
                </div>
                <div class="col-md-6 pt-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{$member->email}}">
                </div>
                <div class="col-md-6 pt-3">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required value="{{$member->designation}}">
                </div>
                <div class="col-md-3 pt-3">
                    <label for="order">Display Order</label>
                    <input type="number" class="form-control" id="order" name="order" required value="1" value="{{$member->order}}">
                </div>

                <div class="col-md-3 pt-3">
                    <label for="cols">Display Type</label>
                    <select type="number" class="form-control" id="cols" name="cols" required >
                        <option value="12" {{$member->cols==12?'selected':''}}>Full Width</option>
                        <option value="6" {{$member->cols==6?'selected':''}}>Half Width</option>
                    </select>
                </div>

                <div class="col-md-12 pt-3">
                    <label for="description">Description</label>
                    <textarea name="desc" id="desc" class="form-control">{{$member->desc}}</textarea>
                </div>

                <div class="col-md-3 pt-2">
                    <button class="btn btn-primary w-100">Update Member</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card shadow mb-4">


</div>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>

    $(document).ready(function() {
        document.getElementById('image').addEventListener("change",readImage);
        $('#desc').summernote();

    });
    function readImage() {

        const FR = new FileReader();
        FR.addEventListener("load", (evt) => {
            document.getElementById('old-image').src = evt.target.result;
        });
        FR.readAsDataURL(this.files[0]);
    }

    function clearImage(){
        document.getElementById('old-image').src="";
        document.getElementById('image').value='';

    }






</script>
@endsection
