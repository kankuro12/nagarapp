@php
    $mls=\App\Models\MemberLevel::select('id','name')->get();
    $mts=\App\Models\MemberType::select('id','name')->get();
    $wards=\App\Models\Member::join('users','users.id','=','members.user_id')->distinct('members.ward')->where('users.nagarcode',Auth::user()->nagarcode)->pluck('members.ward');
@endphp
<form id="selector-table" action="{{route('admin.member.load')}}" target="_blank" method="POST" onsubmit="return loadTableFromSelector(this,event);">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <label for="ml">Member Level</label>
            <select name="ml[]" id="ml" class="form-control select2" multiple>
                @foreach ($mls as $ml)
                    <option value="{{$ml->id}}">{{$ml->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="mt">Member Type</label>
            <select name="mt[]" id="mt" class="form-control select2" multiple>
                @foreach ($mts as $mt)
                    <option value="{{$mt->id}}">{{$mt->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="ward">Ward</label>
            <select name="ward[]" id="ward" class="form-control select2" multiple>
                @foreach ($wards as $ward)
                    <option value="{{$ward}}">{{$ward}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="occupation">occupations</label>
            <input type="text" name="occupation" id="occupation" data-role="tagsinput" class="form-control">
        </div>
        <div class="col-md-3 pt-2">
            <button class="btn btn-primary w-100">Load Data</button>
        </div>
    </div>
</form>
