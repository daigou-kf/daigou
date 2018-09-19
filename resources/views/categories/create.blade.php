@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('categories.category_tab')
            <hr>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">添加类别</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            @csrf
                            @include('layouts.feedback')
                            <div class="form-group row">
                                <label for="img_url" class="col-md-4 col-form-label text-md-right">类别图片</label>

                                <div class="col-md-6">
                                    <input id="img_url" type="file" class="form-control{{ $errors->has('img_url') ? ' is-invalid' : '' }}" name="img_url" required autofocus>

                                    @if ($errors->has('img_url'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('img_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">名称</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        添加
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
