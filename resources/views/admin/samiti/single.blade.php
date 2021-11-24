<div class="card mb-4 shadow">
    <div class="card-body">
        <form action="{{route('admin.samiti.edit',['samiti'=>$samiti])}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="name-{{$samiti->id}}">Name</label>
                    <input type="text" class="form-control" id="name-{{$samiti->id}}" name="name" value="{{$samiti->name}}" required>
                </div>
                <div class="col-md-3 pt-5">
                    <input type="checkbox" name="show" id="show-{{$samiti->id}}" value="1" {{$samiti->show?'checked':''}}> Show On Home
                </div>
                <div class="col-md-3">
                     <label for="order">Order</label>
                    <input type="number" class="form-control" id="order-{{$samiti->id}}" value="{{$samiti->order}}" name="order" required>
                </div>

                <div class="col-md-3 pt-3">
                    <button class="btn btn-primary w-100">Update Samiti</button>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{route('admin.samiti.del',['samiti'=>$samiti])}}"  class="btn btn-danger w-100">Delete Samiti</a>
                </div>
                <div class="col-md-3 pt-3">
                    <a href="{{route('admin.samiti.view',['samiti'=>$samiti])}}"  class="btn btn-success w-100">View Samiti</a>
                </div>
            </div>
        </form>

    </div>
</div>
