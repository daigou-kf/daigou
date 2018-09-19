<!-- Modal -->
<div class="modal fade" id="{{$modal_id}}" tabindex="-1" role="dialog" aria-labelledby="{{$modal_id}}Title"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{$size}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(isset($title_size) && $title_size == "h3")
                    <h3 class="modal-title text-center w-100" id="ModalLongTitle"><strong>{{$title}}</strong></h3>
                @else
                    <h5 class="modal-title text-center w-100" id="ModalLongTitle">{{$title}}</h5>
                @endif

            </div>
            <div class="modal-body">
                {{$content}}
            </div>
            @if(!isset($footer))
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            @endif
        </div>
    </div>
</div>