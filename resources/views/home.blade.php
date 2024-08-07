@extends('layout.main')

@section('keywords', $keywords)

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
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="assets/img/hero.jpeg" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="package">
        <div class="container package-umroh">
            <h1 class="section-title">
                Paket Umroh
            </h1>
            <div class="row">
                @foreach ($umroh as $item)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="/{{ $item['slug'] }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-img">
                                        {{-- <div id="{{ $item['slug'] }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="{{ $item['thumbnail'] }}">
                                                </div>
                                                @foreach ($item['gallery'] as $gal)
                                                    <div class="carousel-item">
                                                        <img src="{{ $gal }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#{{ $item['slug'] }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#{{ $item['slug'] }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div> --}}
                                        <img src="{{ $item['thumbnail'] }}">
                                        {!! $item['is_full'] == true ? '<div class="overlay">CLOSED</div>' : '' !!}

                                    </div>
                                    <h5 class="card-title">{{ $item['name'] }}</h5>
                                    <div class="card-information">
                                        <div class="duration">
                                            <i class="fas fa-clock"></i> {{ count($item['itinerary']) }} Hari
                                            {{ count($item['itinerary']) - 1 }} Malam
                                        </div>
                                        <div class="airlines">
                                            <i class="fas fa-plane-departure"></i> {{ $item['airlines']['airlinesName'] }}
                                        </div>
                                        <div class="hotel">
                                            <i class="fas fa-hotel"></i>
                                            @foreach ($item['hotel'] as $ht)
                                                <span>{{ $ht['name'] }}</span>
                                            @endforeach
                                        </div>

                                    </div>
                                    {{-- <div class="card-allotment">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $item['seat_percentage'] >= 100 ? '100' : $item['seat_percentage'] }}%">
                                        </div>
                                    </div>
                                    {!! $item['seat_left'] <= 0 ? '<p>PENUH</p>' : '<p>Sisa ' . $item['seat_left'] . '</p>' !!}
                                </div> --}}
                                    <hr>
                                    <div class="card-price">
                                        Rp {{ number_format($item['price']['priceNormal'], 0, ',', '.') }}
                                        {!! number_format($item['price']['priceDiscount'], 0, ',', '.') == 0
                                            ? ''
                                            : '<del>Rp ' . number_format($item['price']['priceDiscount'], 0, ',', '.') . '</del>' !!}

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container package-international">
            <h1 class="section-title">
                Paket International
            </h1>
            <div class="row">
                @foreach ($international as $item)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="/{{ $item['slug'] }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-img">
                                        {{-- <div id="{{ $item['slug'] }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="{{ $item['thumbnail'] }}">
                                                </div>
                                                @foreach ($item['gallery'] as $gal)
                                                    <div class="carousel-item">
                                                        <img src="{{ $gal }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#{{ $item['slug'] }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#{{ $item['slug'] }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div> --}}
                                        <img src="{{ $item['thumbnail'] }}">
                                        {!! $item['is_full'] == true ? '<div class="overlay">CLOSED</div>' : '' !!}

                                    </div>
                                    <h5 class="card-title">{{ $item['name'] }}</h5>
                                    <div class="card-information">
                                        <div class="duration">
                                            <i class="fas fa-clock"></i> {{ count($item['itinerary']) }} Hari
                                            {{ count($item['itinerary']) - 1 }} Malam
                                        </div>
                                        <div class="airlines">
                                            <i class="fas fa-plane-departure"></i> {{ $item['airlines']['airlinesName'] }}
                                        </div>
                                        <div class="hotel">
                                            <i class="fas fa-hotel"></i>
                                            @foreach ($item['hotel'] as $ht)
                                                <span>{{ $ht['name'] }}</span>
                                            @endforeach
                                        </div>

                                    </div>
                                    {{-- <div class="card-allotment">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $item['seat_percentage'] >= 100 ? '100' : $item['seat_percentage'] }}%">
                                        </div>
                                    </div>
                                    {!! $item['seat_left'] <= 0 ? '<p>PENUH</p>' : '<p>Sisa ' . $item['seat_left'] . '</p>' !!}
                                </div> --}}
                                    <hr>
                                    <div class="card-price">
                                        Rp {{ number_format($item['price']['priceNormal'], 0, ',', '.') }}
                                        {!! number_format($item['price']['priceDiscount'], 0, ',', '.') == 0
                                            ? ''
                                            : '<del>Rp ' . number_format($item['price']['priceDiscount'], 0, ',', '.') . '</del>' !!}

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="gallery">
        <div class="container">
            <h1 class="section-title">
                Gallery Auli Wisata
            </h1>
            <div class="images">
                @foreach ($galleries as $gall)
                    <div type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $gall['id'] }}"
                        class="item{{ $loop->iteration }}">
                        <img src="{{ $gall['thumbnail'] }}" alt="">
                    </div>
                    <div class="modal fade" id="modal-{{ $gall['id'] }}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body" style="padding: 0px">
                                    <img src="{{ $gall['thumbnail'] }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="button">
                <a type="button" href="/gallery" class="btn btn-gallery">
                    Lihat Selengkapnya...
                </a>
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
