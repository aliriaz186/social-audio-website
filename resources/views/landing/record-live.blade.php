@extends('layouts.major')

@section('content')
    @if(\Illuminate\Support\Facades\Session::has('msg'))
        <div class="alert alert-success" style="margin-bottom: 0px!important;">
            <h4>{{\Illuminate\Support\Facades\Session::get("msg")}}</h4>
        </div>
    @endif

    <div class="container-fluid">
        <div class="video-block section-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <h3>Notifications</h3>
                    </div>
                    <input type="file" accept="audio/*" capture id="recorder">
                    <audio id="player" controls></audio>


                </div>
            </div>
        </div>

        <script>
            const recorder = document.getElementById('recorder');
            const player = document.getElementById('player');

            recorder.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const url = URL.createObjectURL(file);
                // Do something with the audio file.
                player.src = url;
            });
        </script>

@endsection
