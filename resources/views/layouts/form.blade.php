{{--

Form Component

Required parameters:
$title
$method
$action
$fields: $attr, $label, $type, $field['required'], *$step, *$multiple, *options(array of pair of value and text)， *$radio_options(array of pair of value and text) (* optional)
$submit_text

Optional parameters:
$if_file
$edit
$data

--}}
<div class="card">
    <div class="card-header">{{$title}}</div>
    <div class="card-body">
        <form method="{{$method}}" action="{{$action}}" @if(isset($if_file))enctype="multipart/form-data"@endif >
            @csrf
            @if(isset($edit)) <input type="hidden" name="_method" value="PATCH"> @endif
            @foreach($fields as $field)
                <div class="form-group row">
                    <label for="{{$field['attr']}}"
                           class="col-md-4 col-form-label text-md-right">{{$field['label']}}</label>
                    <div class="col-md-6">
                        @if($field['type'] == 'text')
                            <input name="{{$field['attr']}}" type="text"
                                   class="form-control{{ $errors->has($field['attr']) ? ' is-invalid' : '' }}"
                                   value="@if(isset($edit)){{$data[$field['attr']]}}@else{{old($field['attr'])}}@endif"
                                   @if($field['required']) required @endif autofocus
                            >
                        @elseif($field['type'] == 'number')
                            <input name="{{$field['attr']}}" type="number" step="{{$field['step']}}"
                                   class="form-control{{ $errors->has($field['attr']) ? ' is-invalid' : '' }}"
                                   value="@if(isset($edit)){{$data[$field['attr']]}}@else{{old($field['attr'])}}@endif"
                                   @if($field['required']) required @endif autofocus
                            >
                        @elseif($field['type'] == 'file')
                            <input @if(isset($multiple)) name="{{$field['attr']}}[]" @else name="{{$field['attr']}}"
                                   @endif
                                   type="file" class="form-control" @if(isset($multiple)) multiple @endif
                                   @if($field['required']) required @endif autofocus
                            >
                        @elseif($field['type'] == 'select')
                            <select name="{{$field['attr']}}"
                                    class="form-control{{ $errors->has($field['attr']) ? ' is-invalid' : '' }}"
                                    @if($field['required']) required @endif autofocus
                            >
                                <option>请选择{{$field['label']}}</option>
                                @foreach($field['options'] as $option)
                                    <option value="{{$option['value']}}"
                                            @if(isset($edit) && $data[$field['attr']] == $option['value']) selected @endif >{{$option['text']}}</option>
                                @endforeach
                            </select>
                        @elseif($field['type'] == 'checkbox')
                            <input name="{{$field['attr']}}" type="checkbox"
                                   @if(isset($edit) && $data[$field['attr']]) checked @endif autofocus>
                        @elseif($field['type'] == 'textarea')
                            <textarea name="{{$field['attr']}}"
                                      class="form-control{{ $errors->has($field['attr']) ? ' is-invalid' : '' }}" @if($field['required']) required @endif >@if(isset($edit)) {{$data[$field['attr']]}} @else {{old($field['attr'])}} @endif </textarea>
                        @elseif($field['type'] == 'radio')
                            @foreach($field['radio_options'] as $radio_option)
                                <input name="{{$field['attr']}}" type="radio" value="{{$radio_option['value']}}" @if(isset($radio_option['checked'])) checked @endif>{{$radio_option['text']}}<br>
                            @endforeach
                        @elseif($field['type'] == 'password')
                            <input name="{{$field['attr']}}" type="password"
                                   class="form-control{{ $errors->has($field['attr']) ? ' is-invalid' : '' }}"
                                   @if(isset($edit)) placeholder="******" @endif @if($field['required']) required @endif >
                        @elseif($field['type'] == 'date')

                        @endif
                    </div>
                </div>
            @endforeach
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{$submit_text}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>