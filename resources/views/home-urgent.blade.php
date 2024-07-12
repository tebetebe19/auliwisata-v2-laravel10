@extends('layout.main')



@section('content')
    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 information">
                    <div class="bag">
                        <h1>
                            Happily traveling without forget about <span>aqidah</span>
                        </h1>
                        <button class="btn btn-green">
                            Check Legalitas
                        </button>
                        <div class="point">
                            Safety <span>|</span> Guider <span>|</span> Religious <span>|</span> Legal
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="assets/img/hero.jpeg" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="container" id="package">
        <h1 class="section-title">
            Paket Umroh
        </h1>
        <div class="row">
            @foreach ($products as $item)
                <div class="col-lg-4 col-md-6">
                    <a href="https://wa.me/628119180192" target="blank_">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-img">
                                    <div id="{{ $item['fields']['code'] }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($item['fields']['thumbnail'] as $gal)
                                                <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                                    <img src="{{ $gal['url'] }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <button class="carousel-control-prev" type="button"
                                            data-bs-target="#{{ $item['fields']['code'] }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#{{ $item['fields']['code'] }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button> --}}
                                    </div>
                                </div>
                                <h5 class="card-title">{{ $item['fields']['nama'] }}</h5>
                                <div class="card-information">
                                    <div class="duration">
                                        <i class="fas fa-clock"></i> {{ $item['fields']['durasi'] }} Hari
                                        {{ $item['fields']['durasi'] - 1 }} Malam
                                    </div>
                                    <div class="airlines">
                                        <i class="fas fa-plane-departure"></i> {{ $item['fields']['airlinesName'][0] }}
                                    </div>
                                    <div class="hotel">
                                        <i class="fas fa-hotel"></i>{{ $item['fields']['hotelName'][0] }}
                                    </div>
                                </div>
                                {{-- <div class="card-allotment">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $item['seat_percentage'] >= 100 ? '100' : $item['seat_percentage'] }}%">
                                        </div>
                                    </div>
                                    {!! $item['seat_left'] <= 0 ? '<p>PENUH</p>' : '<p>Sisa ' . $item['seat_left'] . '</p>' !!}
                                </div>
                                <hr> --}}
                                <div class="card-price">
                                    Rp {{ number_format($item['fields']['harga'], 0, ',', '.') }} {!! $item['fields']['hargaCoret'] == 0
                                        ? ''
                                        : '<del>Rp ' . number_format($item['fields']['hargaCoret'], 0, ',', '.') . '</del>' !!}

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section id="gallery">
        <div class="container">
            <h1 class="section-title">
                Gallery Auli Wisata
            </h1>
            <div class="images">
                <div class="item1"><img src="assets/img/gallery/g1.png" alt=""></div>
                <div class="item2"><img src="assets/img/gallery/g2.png" alt=""></div>
                <div class="item3"><img src="assets/img/gallery/g3.png" alt=""></div>
                <div class="item4"><img src="assets/img/gallery/g4.png" alt=""></div>
                <div class="item5"><img src="assets/img/gallery/g5.png" alt=""></div>
                <div class="item6"><img src="assets/img/gallery/g6.png" alt=""></div>
                <div class="item7"><img src="assets/img/gallery/g7.png" alt=""></div>
            </div>
        </div>
    </section>

    <section id="partner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="section-title">
                        Partner Maskapai
                    </h1>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <img src="assets/img/airlines/emirates.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/airlines/etihad.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/airlines/oman.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/airlines/qatar.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/airlines/saudia.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="section-title">
                        Partner Hotel
                    </h1>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <img src="assets/img/hotel/anjum.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/hotel/makarim.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/hotel/movenpick.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/hotel/pullman.png" alt="">
                        </div>
                        <div class="col-4">
                            <img src="assets/img/hotel/raffles.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
