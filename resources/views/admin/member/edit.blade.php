@extends('layout.app')

@section('s-title')
/ <a href="{{route('admin.member.index')}}">Members</a> / Edit / {{$member->name}}
@endsection
@section('content')
<div class="card shadow mb-4 p-4">
    <form action="{{route('admin.member.edit',['member'=>$member->id])}}" id="add-member" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <img id="old-image" src="{{asset($member->member->image)}}" alt="" class="w-100" onclick="document.getElementById('image').click();">
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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" required class="form-control" value="{{$member->name}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" name="email" id="email"  class="form-control" value="{{$member->email}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone">Phone *</label>
                    <input type="text" name="phone" id="phone" value="{{$member->phone}}" required class="form-control"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  minlength="10" maxlength="10">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Municipality *</label>
                    <input type="text" value="{{$member->mun()}}" readonly class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ward">Ward No *</label>
                    <input type="text" name="ward" id="ward" required class="form-control" value="{{$member->member->ward}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  minlength="10" maxlength="10">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="address">Address </label>
                    <input type="text" name="address" id="address"  class="form-control" value="{{$member->member->address}}" >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="member_level_id">Member  Level *</label>
                    <select type="text" name="member_level_id" id="member_level_id" required class="form-control"  >
                        @foreach ($mls as $ml)
                            <option value="{{$ml->id}}" {{$member->member->member_level_id==$ml->id?"selected":""}}>{{$ml->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="member_type_id">Member  Type *</label>
                    <select type="text" name="member_type_id" id="member_type_id" required class="form-control"  >
                        @foreach ($mts as $mt)
                            <option value="{{$mt->id}}" {{$member->member->member_type_id==$mt->id?"selected":""}}>{{$mt->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="occupation">Occupation </label>
                    <input type="text" name="occupation" id="occupation"  class="form-control" value="{{$member->member->occupation}}"  >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fc">Family Count</label>
                    <input type="number" name="fc" id="fc"  class="form-control" min="1" value="{{$member->member->fc}}">

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bg">Blood Group</label>
                    <select name="bg" id="bg" class="form-control" >
                        @foreach (\App\Data::bg as $bg)
                            <option value="{{$bg}}" {{$member->member->bg==$bg?"selected":""}}>{{$bg}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-3 ">
                <div >
                    <button  class="btn btn-primary w-100">
                        update Member
                    </button >
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
  
    $(document).ready(function() {
        document.getElementById('image').addEventListener("change",readImage);
    });
    function readImage() {
        
        const FR = new FileReader();
        FR.addEventListener("load", (evt) => {
            document.getElementById('old-image').src = evt.target.result;
        });
        FR.readAsDataURL(this.files[0]);
    }

    function clearImage(){
        document.getElementById('old-image').src="{{asset($member->member->image)}}";
        document.getElementById('image').value='';
        
    }

   


  
    
</script>
@endsection
