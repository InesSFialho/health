@extends('layouts.backoffice_master')

@section('head-meta')
<title>{{ str_replace('.', ' ', config('app.name')) }} - Páginma Principal</title>
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="{{URL::asset('js/appimage.js')}}"></script>
@endsection

@section('head-script')
{{-- expr --}}
@endsection

@section('content')
<div class="row">
    @include('flash::message')
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Configurations</h5>
                    </div>
                </div>
                <div>
                    {!! Form::open(['route' => 'backoffice.configurations.store', 'files' => 'true']) !!}
                    {{ csrf_field() }}
                    <div class="form-group">
                        {!! Form::label('title', 'Title') !!}
                        <input name="title" class="form-control" id="title" value="{{$configurations->title ?? 'Title' }}"></input>
                    </div>
                    <div class="form-group">
                        {!! Form::label('subtitle', 'Subtitle') !!}
                        <input name="subtitle" class="form-control" id="subtitle" value="{{$configurations->subtitle ?? 'SubTitle' }}"></input>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Logo') !!}

                                <ul id="media-list" class="clearfix">
                                    @if(!empty($logo))


                                    <li id="imgtmp" value="{{ $logo->id }}">
                                        <img src="{{ url( $logo->url  . $logo->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $logo->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens[]" class="onepicupload" multiple></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Logo Backoffice') !!}

                                <ul id="media-list" class="clearfix-mobile">
                                    @if(!empty($logo_backoffice))
                                    <li id="imgtmp-mobile" value="{{ $logo_backoffice->id }}">
                                        <img src="{{ url( $logo_backoffice->url  . $logo_backoffice->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $logo_backoffice->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens-mobile[]" class="onepicupload-mobile" multiple></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('google_control_id', 'Analytics Control ID') !!}
                        <input name="google_control_id" class="form-control" id="google_control_id" value="{{$configurations->google_control_id ?? 'Analytics Control ID' }}"></input>

                    </div>
                    <div class="form-group">
                        {!! Form::label('google_view_ids', 'Analytics View ID') !!}
                        <input name="google_view_ids" class="form-control" id="google_view_ids" value="{{$configurations->google_view_ids ?? 'Analytics View ID' }}"></input>

                    </div>

                    <div class="form-group">
                        {!! Form::label('analytics_json', 'Analytics Json') !!}

                        <textarea name="analytics_json" class="form-control" id="analytics_json">{{$analytics_json ?? '' }}</textarea>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Background 1') !!}

                                <ul id="media-list" class="clearfix-bg1">
                                    @if(!empty($bg1))
                                    <li id="bg1" value="{{ $bg1->id }}">
                                        <img src="{{ url( $bg1->url  . $bg1->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $bg1->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens-bg1[]" class="onepicupload-bg1" multiple></span>
                                    </li>
                                </ul>
                            </div>
                            </div>
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Background 2') !!}

                                <ul id="media-list" class="clearfix-bg2">
                                    @if(!empty($bg2))
                                    <li id="bg2" value="{{ $bg2->id }}">
                                        <img src="{{ url( $bg2->url  . $bg2->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $bg2->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens-bg2[]" class="onepicupload-bg2" multiple></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Background 3') !!}

                                <ul id="media-list" class="clearfix-bg3">
                                    @if(!empty($bg3))
                                    <li id="bg3" value="{{ $bg3->id }}">
                                        <img src="{{ url( $bg3->url  . $bg3->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $bg3->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens-bg3[]" class="onepicupload-bg3" multiple></span>
                                    </li>
                                </ul>
                            </div>
                            </div>
                        <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('img-tag', 'Background 4') !!}

                                <ul id="media-list" class="clearfix-bg4">
                                    @if(!empty($bg4))
                                    <li id="bg4" value="{{ $bg4->id }}">
                                        <img src="{{ url( $bg4->url  . $bg4->file) }} " id="img-tag" class="imagens" />
                                        <div class="post-thumb">
                                            <div class="inner-post-thumb">
                                                <a href="javascript:void(0);" star-data-id="{{ $bg4->id }}" data-id-item="{{ $configurations->id }}" class="star-pic"><i class="fa fa-star" aria-hidden="true"></i></a>
                                                <div></div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    <li class="myupload">
                                        <span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" id="picupload" name="imagens-bg4[]" class="onepicupload-bg4" multiple></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-outline-secondary')); !!}

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-scripts')


@endsection