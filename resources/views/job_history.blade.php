@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading"><h2>Job History</h2></div>
            <div class="panel-body">
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable" id="jobHistoryDatatable">
                            <thead>
                            <tr role="row">
                                <th>Job ID</th>
                                <th>Job number</th>
                                <th>Output file</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($details as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->job_number}}</td>
                                <td>{{$value->file_download_name}}</td>
                                @if($value->status===0)
                                    <td><span class="badge badge-primary">Pending</span></td>
                                @elseif($value->status===1)
                                    <td><span class="badge badge-success">Success</span></td>
                                @else
                                    <td><span class="badge badge-danger">Failed</span></td>
                                @endif
                                <td>{{$value->created_at}}</td>
                                @if($value->status===1)
                                    <td><a class='btn btn-primary' href='{{ route('file.download.output',$value->id) }}'>Download</a></td>
                                @else
                                    <td>File not available</td>
                                @endif
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$details->links()}}
            </div>
        </div>
    </div>

@endsection
