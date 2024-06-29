@extends('layout.main')

@section('content')
    <div class="container" id="detail">
        <div class="row">
            <div class="col-lg-12">
                <img class="hero" src="{{ $products[0]['thumbnail'] }}" alt="">
            </div>
            {{-- <div class="col-lg-12">
                <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($products[0]['gallery'] as $gal)
                                <li class="splide__slide"><img src="{{ $gal }}" alt=""></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title">
                            Penerbangan
                        </div>
                        <hr>
                        <div class="card-flight">
                            <div class="airlines">
                                <div class="bag">
                                    <img src="{{ $products[0]['airlines']['airlinesIcon'] }}" alt="">
                                    <span class="name">{{ $products[0]['airlines']['airlinesName'] }}
                                        [{{ $products[0]['airlines']['airlinesCode'] }}]</span>
                                </div>
                                <div class="airlines-class">Business</div>
                            </div>
                            <div class="item-title">
                                Keberangkatan
                                <hr>
                            </div>
                            <div class="schedule" style="margin-bottom: 20px">
                                @foreach ($products[0]['flightDeparture'] as $fl)
                                    <div class="flight">
                                        @if ($loop->first)
                                            <i class="fas flight-icon fa-plane-departure"></i>
                                        @elseif ($loop->last)
                                            <i class="fas flight-icon fa-plane-arrival"></i>
                                        @else
                                            <i class="fas flight-icon fa-plane"></i>
                                        @endif
                                        <div class="airport">
                                            {{ $fl['airportDepartureCode'] }}, {{ $fl['airportDepartureName'] }}
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <div class="separator"></div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="item-title">
                                Kepulangan
                                <hr>
                            </div>
                            <div class="schedule">
                                @foreach ($products[0]['flightReturn'] as $fl)
                                    <div class="flight">
                                        @if ($loop->first)
                                            <i class="fas flight-icon fa-plane-departure"></i>
                                        @elseif ($loop->last)
                                            <i class="fas flight-icon fa-plane-arrival"></i>
                                        @else
                                            <i class="fas flight-icon fa-plane"></i>
                                        @endif
                                        <div class="airport">
                                            {{ $fl['airportReturnCode'] }}, {{ $fl['airportReturnName'] }}
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <div class="separator"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title">
                            Hotel
                        </div>
                        <hr>
                        <div class="row">
                            @foreach ($products[0]['hotel'] as $ht)
                                <div class="col-12">
                                    <div class="card-hotel">
                                        <img src="{{ $ht['thumbnail'] }}" alt="">
                                        <div class="information">
                                            <div class="bag">
                                                <div class="hotel">
                                                    <div class="name">
                                                        {{ $ht['name'] }}
                                                    </div>
                                                    <div class="star">
                                                        @for ($i = 0; $i < $ht['star']; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor

                                                    </div>
                                                </div>
                                                <div class="city">
                                                    <a href="{{ $ht['location'] }}">
                                                        <i class="fas fa-location-arrow"></i> {{ $ht['city'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="description">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus nisi
                                                minus similique eaque sequi repellendus excepturi fuga incidunt officiis
                                                saepe
                                                mollitia possimus alias voluptates earum laboriosam, error, veniam laborum
                                                ipsum!
                                            </div>
                                            <div class="attraction">
                                                @foreach ($ht['attractions'] as $att)
                                                    <a href="{{ $att['attractionLocation'] }}" target="blank_">
                                                        <i class="fas fa-utensils"></i>
                                                        {{ $att['attractionName'] }}
                                                    </a>
                                                @endforeach
                                                <a href="#" target="blank_">
                                                    <i class="fas fa-utensils"></i>
                                                    Al-Baik Restaurant
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionItin">
                    @foreach ($products[0]['itinerary'] as $itin)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $itin['id'] }}">
                                    Day {{ $loop->iteration }} - {{ $itin['name'] }}
                                </button>
                            </h2>
                            <div id="{{ $itin['id'] }}" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionItin">
                                <div class="accordion-body">
                                    {{-- <div class="splide" role="group" aria-label="" style="margin-bottom: 16px">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                @foreach ($itin['gallery'] as $gal)
                                                    <li class="splide__slide"><img src="{{ $gal }}"
                                                            alt=""></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div> --}}
                                    <div class="description">
                                        <div class="card-description">
                                            {{ $itin['description'] }}
                                        </div>
                                    </div>
                                    <div class="card-meal">
                                        @foreach ($itin['meal'] as $meal)
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
