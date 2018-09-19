<div class="container-fluid fixed-bottom">
    <div class="row">
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
           {{ __('Logout') }} class="btn-warning btn btn-block text-light">退出</a>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
    @csrf
</form>