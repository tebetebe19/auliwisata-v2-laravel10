@extends('layout.main')

@section('content')
    <div class="container" id="detail">
        <div class="row">
            <div class="col-lg-12">
                <img class="hero" src="{{ $products[0]['thumbnail'] }}" alt="">
            </div>
            <div class="col-lg-12">
                <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($products[0]['gallery'] as $gal)
                                <li class="splide__slide"><img src="{{ $gal }}" alt=""></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionItin">
                    @foreach ($products[0]['itinerary'] as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $item['id'] }}">
                                    Day {{ $loop->iteration }} - {{ $item['title'] }}
                                </button>
                            </h2>
                            <div id="{{ $item['id'] }}" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionItin">
                                <div class="accordion-body">
                                    <div class="flight-schedule">
                                        <div class="item-title">
                                            Penerbangan
                                            <hr>
                                        </div>
                                        @foreach ($item['flight'] as $fl)
                                            <div class="card-flight">
                                                <div class="airlines">
                                                    <div class="bag">
                                                        <img src="assets/img/airlines/qatar.png" alt="">
                                                        <span class="name">{{ $fl['airlinesName'] }}
                                                            [{{ $fl['airlinesCode'] }}]</span>
                                                    </div>
                                                    <div class="airlines-class">Business</div>
                                                </div>
                                                <div class="schedule">
                                                    <div class="flight departure">
                                                        <i class="fas flight-icon fa-plane-departure"></i>
                                                        <div class="airport">
                                                            <i class="fas fa-map-pin"></i>
                                                            {{ $fl['airportDepartureCode'] }},
                                                            {{ $fl['airportDepartureCity'] }}
                                                        </div>
                                                    </div>
                                                    <div class="separator"></div>
                                                    <div class="duration">
                                                        {{ $fl['flightDuration'] }}
                                                    </div>
                                                    <div class="separator"></div>
                                                    <div class="flight arrival">
                                                        <i class="fas flight-icon fa-plane-arrival"></i>
                                                        <div class="airport">
                                                            <i class="fas fa-map-pin"></i>
                                                            {{ $fl['airportArrivalCode'] }},
                                                            {{ $fl['airportArrivalCity'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="description">
                                        <div class="item-title">
                                            Description
                                            <hr>
                                        </div>
                                        <div class="card-description">
                                            {{ $item['description'] }}
                                        </div>
                                    </div>
                                    <div class="hotel-information">
                                        <div class="item-title">
                                            Hotel
                                            <hr>
                                        </div>
                                        <div class="card-hotel">
                                            <img src="{{ $item['hotel']['hotelThumbnail'][0]['url'] }}" alt="">
                                            <div class="information">
                                                <div class="bag">
                                                    <div class="hotel">
                                                        <div class="name">
                                                            {{ $item['hotel']['hotelName'][0] }}
                                                        </div>
                                                        <div class="star">
                                                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="city">
                                                        {{ $item['hotel']['hotelCity'][0] }}
                                                    </div>
                                                </div>
                                                <div class="description">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam ut
                                                    saepe
                                                    deleniti quos harum? Maiores asperiores error iure veritatis aperiam?
                                                </div>
                                                <div class="bag">
                                                    <div class="attraction">
                                                        @foreach ($item['attraction'][0] as $att)
                                                            <a href="{{ $att['attractionLocation'] }}" target="blank_">
                                                                <i class="fas fa-utensils"></i>
                                                                {{ $att['attractionName'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>

                                                    <a href="{{ $item['hotel']['hotelLocation'][0] }}" target="blank"
                                                        class="location">
                                                        <i class="fas fa-location-arrow"></i> See Maps
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-meal" {{ isset($item['meal']) ? '' : 'hidden' }}>
                                        @foreach ($item['meal'] as $meal)
                                            <span>{{ $meal }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Splide JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide('.splide', {
                type: 'loop',
                drag: 'free',
                focus: 'center',
                perPage: 4,
                // autoWidth: true,
                autoHeight: true,
                arrows: false,
                pagination: false,
                gap: 20,
            });
            splide.mount(window.splide.Extensions);
        });
    </script>
@endsection
