@extends('layout.main')

@section('content')
    <section id="gallery-page">
        <div class="container">
            <h1>Gallery Auli Wisata</h1>
            @foreach ($galleries as $gall)
                <h2>{{ $gall['name'] }}</h2>
                <hr>
                <div class="row">
                    @foreach ($gall['images'] as $img)
                        <div class="col-lg-3 col-6">
                            <img src="{{ $img['url'] }}" type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $img['id'] }}">
                            <div class="modal fade" id="modal-{{ $img['id'] }}" tabindex="-1">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body" style="padding: 0px">
                                            <img src="{{ $img['url'] }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
@endsection
