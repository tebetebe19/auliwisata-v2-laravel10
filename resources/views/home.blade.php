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
                Data Limitation
            </div>
        </div>
        <div class="container package-international">
            <h1 class="section-title">
                Paket International
            </h1>
            <div class="row">
                Data Limitation
            </div>
        </div>
    </section>

    <section id="gallery">
        <div class="container">
            <h1 class="section-title">
                Gallery Auli Wisata
            </h1>
            <div class="images">
                Data Limitation
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
