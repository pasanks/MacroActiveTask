@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-primary">
            <div class="row">
                <div class="col-8">
                    <div class="panel-heading"><h2>Upload audio file and convert to mp3</h2></div>
                </div>
                <div class="col-4" >
                    <a class='btn btn-primary' href='{{ route('file.job-history') }}'>Job history</a>
                </div>
            </div>
            <div class="panel-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    <img src="uploads/{{ Session::get('file') }}">
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data" id="processFile" name="processFile" >
                        @csrf
                        <div class="form-group row">
                            <label for="text" class="col-4 col-form-label">Name to save the converted file *</label>
                            <div class="col-8">
                                <input id="text" name="file_name" placeholder="Please enter name for the converted file. ex : test convert" type="text" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-4 col-form-label">File *</label>
                            <div class="col-8">
                                <input type="file" name="file" class="form-control">  </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <button name="submit" id="submit-btn" type="button" class="btn btn-primary">Start converting</button>
                            </div>
                            <div class="col-4" id="downloadBtn">

                            </div>
                            <div class="col-4" id="convertAnother">

                            </div>
                        </div>
                    </form>
                    <div class="col-sm-6 offset-3" id="progress-area" hidden>
                        <div class="form-group progress active">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                        <div class="progress-info-text">Uploading file...</div>
                    </div>
                    <div class="col-sm-6 offset-3" id="spinner-area" hidden>
                        <div class="form-group progress active">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                        <div class="convert-progress-info-text">Converting file...</div>
                    </div>
            </div>
        </div>
    </div>


    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script>

        $("#submit-btn").click(function(){
            var file_name = document.forms["processFile"]["file_name"].value;
            var file_input = document.forms["processFile"]["file"].value;

            if ((file_name == null || file_name == "") || (file_input == null || file_input == "") ) {
                alert("Please Fill All Required Fields");
                return false;
            }else{
                $("#progress-area").show();
                $("#submit-btn").attr("disabled", true);
                var form = document.forms.namedItem("processFile");
                var formdata = new FormData(form);

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        //Upload progress
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                $(".progress-bar").width(Math.round(percentComplete * 100) + "%");
                                $(".progress-info-text").text(`file uploaded ${Math.round(percentComplete * 100)}%`);
                                if (Math.round(percentComplete * 100) == 100) {
                                    $(".progress-info-text").text("Starting mp3 conversion...");
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function(){
                        $("#progress-area").hide();
                        $("#spinner-area").removeAttr("hidden");

                    },
                    async: true,
                    type: "POST",
                    url: '{{url("/file-upload")}}',
                    enctype: 'multipart/form-data',
                    dataType: "json",
                    contentType: false,
                    data: formdata,
                    processData: false,
                    success: function(responceData) {
                        $('#spinner-area').hide();
                        $('#processFile').trigger("reset");

                        if (responceData[0]) {
                            var download_btn;
                            var convert_another_btn;
                            let url = "{{ route('file.download.output', ':id') }}";
                            url = url.replace(':id', responceData[1]);

                            download_btn = "<a class='btn btn-primary' href='"+url+"'>Download</a>";
                            convert_another_btn = "<a class='btn btn-primary' href='/home'>Convert another file</a>";

                            document.getElementById("downloadBtn").innerHTML=download_btn;
                            document.getElementById("convertAnother").innerHTML=convert_another_btn;
                        } else {
                            alert('Something went wrong with your file conversion please try again later.')
                            window.location.reload();
                        }

                    }
                });

            }


        });
    </script>
@endsection
