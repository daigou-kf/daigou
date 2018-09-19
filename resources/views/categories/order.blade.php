@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('categories.category_tab')
        </div>
        <form method="post">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第1位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_1" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第2位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_2" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第3位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_3" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第4位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_4" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第5位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_5" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第6位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_6" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第7位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_7" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <div class="text-right" >第8位</div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                    <select class="form-control" name="index_8" required>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-outline-info">提交</button>
            </div>



        </form>
    </div>
@endsection