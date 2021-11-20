@extends('layout.app')

@section('s-title')
/ <a href="{{route('admin.member.index')}}">Members</a> / Add
@endsection
@section('content')
<div class="card shadow mb-4 p-4">
    <form action="{{route('admin.member.add')}}" id="add-member" method="post" onsubmit="return save(event);">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <canvas style="height: 150px;width:150px;border:1px solid rgba(248, 157, 157, 0.23)" id="img-canvas" onclick="document.getElementById('image').click();"></canvas>
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
                    <input type="text" name="name" id="name" required class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" name="email" id="email"  class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone">Phone *</label>
                    <input type="text" name="phone" id="phone" required class="form-control"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  minlength="10" maxlength="10">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Municipality *</label>
                    <input type="text" value="{{$user->mun()}}" readonly class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ward">Ward No *</label>
                    <input type="text" name="ward" id="ward" required class="form-control"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  minlength="10" maxlength="10">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="address">Address </label>
                    <input type="text" name="address" id="address"  class="form-control"  >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="member_level_id">Member  Level *</label>
                    <select type="text" name="member_level_id" id="member_level_id" required class="form-control"  >
                        @foreach ($mls as $ml)
                            <option value="{{$ml->id}}">{{$ml->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="member_type_id">Member  Type *</label>
                    <select type="text" name="member_type_id" id="member_type_id" required class="form-control"  >
                        @foreach ($mts as $mt)
                            <option value="{{$mt->id}}">{{$mt->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="occupation">Occupation </label>
                    <input type="text" name="occupation" id="occupation"  class="form-control"  >
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fc">Family Count</label>
                    <input type="number" name="fc" id="fc"  class="form-control" min="1">

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bg">Blood Group</label>
                    <select name="bg" id="bg" class="form-control" >
                        @foreach (\App\Data::bg as $bg)
                            <option value="{{$bg}}">{{$bg}}</option>
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
                        Add Member
                    </button >
                </div>
            </div>
            <div class="col-md-9 d-flex justify-content-end">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="ss" value="true">
                    <label class="form-check-label" for="ss">Same Setting</label>
                  </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var canvas=document.getElementById('img-canvas');
    var ctx=null;
    ctxloaded=false;
    $(document).ready(function() {
        ctx=canvas.getContext('2d');
        document.getElementById('image').addEventListener("change",readImage);
    });
    function readImage() {
        if (!this.files || !this.files[0]){
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            return;
        } 

        const FR = new FileReader();
        FR.addEventListener("load", (evt) => {
            const img = new Image();
            img.addEventListener("load", () => {
            x=0;y=0;_x=300;_y=150;
            ratio=1;
            if(img.width>img.height){
                ratio=_x/img.width;
                __y=_y;
                _y=(ratio*img.height)/2;
                y=(__y-_y)/2;
            }else if(img.height>img.width){
                ratio=_y/img.height;
                __x=_x;
                _x=(ratio*img.width)*2;
                x=(__x-_x)/2;
            }



            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            ctx.drawImage(img, x,y,_x,_y);
            ctxloaded=true;
            });
            img.src = evt.target.result;
        });
        FR.readAsDataURL(this.files[0]);
    }

    function clearImage(){
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        document.getElementById('image').value='';
        ctxloaded=false;
    }

    function dataURItoBlob (dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type: mimeString});
    }


    saving=false;
    function save(e){
        console.log(e);
        e.preventDefault();
        if(saving) return;
        var fd=new FormData(document.getElementById('add-member'));
        
        
        axios.post("{{route('admin.member.add')}}",fd)
        .then((res)=>{
            if(res.data=='ok'){
                toastr.success('Member '+$('#name').val()+' Added Sucessfully');
            }
            if(document.getElementById('ss').checked){
                $('#name').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#address').val('');
                $('#occupation').val('');
                $('#fc').val('');
                $('#bg').val('A+');
                clearImage();
            }else{
                document.getElementById('add-member').reset();clearImage();
            }
        })
        .catch((err)=>{
            toastr.error('Member '+$('#name').val()+' Cannot be Added,Please Try Again');

        });
    }
</script>
@endsection
