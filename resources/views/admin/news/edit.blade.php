@extends('layout.app')
@section('css')
    <!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('s-title')
/ <a href="{{route('admin.news.index')}}">News</a> / {{$news->title}} / Edit
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body" id="table-holder">
        <form action="{{route('admin.news.add')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <img id="old-image" src="{{asset($news->image)}}"  alt="" class="w-100" onclick="document.getElementById('image').click();">
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
                <div class="col-md-12 pt-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required value="{{$news->title}}">
                </div>


                <div class="col-md-12 pt-3">
                    <label for="content">Description</label>
                    <textarea name="content" id="content" class="form-control">{{$news->content}}</textarea>
                </div>

                <div class="col-md-3 pt-2">
                    <button class="btn btn-primary w-100">Update News</button>
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
        document.getElementById('old-image').src="{{asset($news->image)}}";
        document.getElementById('image').value='';

    }






</script>
@endsection
