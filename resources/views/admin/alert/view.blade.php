@extends('layout.app')
@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/tag/tagsinput.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    th{
        width: 25%;
    }
</style>
@endsection
@section('s-title')
/ <a href="{{route('admin.alert.index')}}">Alerts</a> / {{$alert->title}}
@endsection
@section('content')

<div class="card shadow mb-4">
    {{-- <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div> --}}
    <div class="card-body" id="table-holder">
        <table class="table">
            <tr>
                <th >Title</th>
                <td>
                    {{$alert->title}}
                </td>
            </tr>
            <tr>
                <th>
                    Message
                </th>
                <td>
                    {{$alert->msg}}
                </td>
            </tr>
            <tr>
                <th>
                    SMS
                </th>
                <td>
                    {{$alert->is_sms?"Yes":"No"}}
                </td>
            </tr>
            <tr>
                <th>
                    Push
                </th>
                <td>
                    {{$alert->is_push?"Yes":"No"}}
                </td>
            </tr>
            <tr>
                <th>
                    Parameters
                </th>
                <td>
                    @php
                        $stat=$alert->getStat();
                    @endphp
                    <table class="table">
                        <tr>
                            <th>
                                Send To All
                            </th>
                            <td>
                                {{$stat['all']}}
                            </td>
                        </tr>
                        @if ($stat['all']=='no')
                            <tr>
                                <th>
                                    Wards
                                </th>
                                <td>
                                    {{$stat['ward']}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Member Levels
                                </th>
                                <td>
                                    {{$stat['ml']??''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Member Types
                                </th>
                                <td>
                                    {{$stat['mt']??''}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Send To All Selected
                                </th>
                                <td>
                                    {{$stat['sel_all']}}
                                </td>
                            </tr>

                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="btn btn-primary" onclick="resendAlert()">Resend Alert</button>
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection
@section('script')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    var table;
    $(document).ready(function() {

    });
</script>
@endsection
