<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Pelajaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Poppins;
            font-size: 17px;
        }

        #myVideo  {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
        }

        .content {
            position: fixed;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #f1f1f1;
            width: 100%;
            height: 100vh;

        }

        #myBtn {
            width: 200px;
            font-size: 18px;
            padding: 10px;
            border: none;
            background: #000;
            color: #fff;
            cursor: pointer;
        }

        #myBtn:hover {
            background: #ddd;
            color: black;
        }
        .zoom:hover {
            -ms-transform: scale(0.5);
            -webkit-transform: scale(0.5);
            transform: scale(1.1); 
        }

        .logo-sekolah {
            max-width: 128px;
        }
        @media only screen and (min-width: 200px) and (max-width: 1250px) { 
            .content {
            overflow-y: scroll;
            overflow-x: hidden;

        }
         } 
        
    </style>
</head>
<body>
    <div class="fullscreen-bg">
        <video loop muted autoplay class="fullscreen-bg__video" id="myVideo">
            <source src="{{ asset('video/bg_video.mp4') }}" type="video/mp4">
        </video>
    </div>

    <div class="content">
        <div class="row justify-content-center mt-5">
            <div class="col-12 text-center">
                <img src="{{ asset('image/logo/'.$setting_umum->logo) }}" class="img-fluid logo-sekolah" alt="">
                <h1 class="mt-3">Selamat Datang</h1>
                <h3>Jadwal Pelajaran {{ $setting_umum->nama_sekolah }}</h3>
            </div>
        </div>           

        <div class="">
            <div class="d-flex flex-wrap align-items-center justify-content-center mt-4 w-100 h-100">
                @foreach ($jurusan as $item)
                    <a href="{{ route('lihat_kelas',  $item->id) }}" class="text-decoration-none text-dark zoom">
                        <div class="px-3 justify-content-center mt-3">
                            <div class="card p-3 shadow text-center mx-0"
                                style="background-color:#ffffff9c;width: 7rem;height: 7rem;">
                                <p class="h1 text-dark my-0 font-weight-bold"><i class="{{ $item->icon }}"></i></p>
                                <div class="" style="white-space: nowrap;width: 70px;overflow: hidden;text-overflow: ellipsis; ">
                                    <p class="p font-weight-bold font-weight-bold mt-2">{{ $item->nama_jurusan }}</p>
                                </div>
                            </div>
                        </div>
                    </a>   
                @endforeach 
                 
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
</body>

</html>