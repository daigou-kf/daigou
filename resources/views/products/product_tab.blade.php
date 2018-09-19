<div class="container-fluid">
    <div class="col-md-6 offset-3 btn-group d-flex" role="group">
        <a href="{{ route('products.index') }}" class="btn btn-info w-100">全部产品</a>
        <a href="{{ route('products.index_trashed') }}" class="btn btn-info w-100">已删除产品</a>
        <a href="{{ route('products.create') }}" class="btn btn-info w-100">添加产品</a>
    </div>
</div>