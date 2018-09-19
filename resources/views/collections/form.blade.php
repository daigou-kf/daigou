<div class="card">
    <div class="card-header">@if($action == 'create') 添加系列 @else 更新系列 @endif</div>
    <div class="card-body">
        <form method="post"
              action="@if($action == 'create'){{route('collections.store')}}@else{{route('collections.update',['id' => $collection->id ])}}@endif"
              enctype="multipart/form-data">
            @csrf
            @if($action == 'edit')
                <input type="hidden" value="PATCH" name="_method">
            @endif
            <div class="form-group row">
                <label for="img_url" class="col-md-4 col-form-label text-md-right">系列图片</label>

                <div class="col-md-6">
                    <input id="img_url" type="file"
                           class="form-control{{ $errors->has('img_url') ? ' is-invalid' : '' }}"
                           name="img_url" @if($action == 'create') required @endif autofocus>

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
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name"
                           value="@if($action == 'create'){{ old('name') }}@else{{$collection->name}}@endif" required
                           autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">搜索名称（请使用英文，后台使用）</label>

                <div class="col-md-6">
                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="search_name"
                           value="@if($action == 'create'){{ old('search_name') }}@else{{$collection->search_name}}@endif"
                           required autofocus>

                    @if ($errors->has('search_name'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('search_name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="display" class="col-md-4 col-form-label text-md-right">首页显示</label>

                <div class="col-md-6">
                    <input type="checkbox" class="custom-checkbox {{ $errors->has('display') ? ' is-invalid' : '' }}"
                           name="display"
                           @if($action == 'edit' && $collection->display) checked @endif
                           autofocus>

                    @if ($errors->has('display'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('display') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        @if($action == 'create') 添加 @else 更新 @endif
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>