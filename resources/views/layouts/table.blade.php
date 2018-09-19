<table class="table table-bordered table-hover text-center">
    @if(isset($check))
        <button type="submit" class="btn btn-info btn-block">
            更新
        </button>
    @endif
    <thead>
    @foreach($key_name as $key)
        <th>
            {{$key}}
        </th>
    @endforeach
    </thead>
    <tbody>
    @foreach($data_array as $data)
        <tr>
            @foreach($key_array as $key)
                <td> @if(strpos($key,'img') !== false) <a href="{{asset('storage/app/'.$data[$key])}}"
                                                          target="_blank"><img
                                src="{{asset('storage/app/'.$data[$key])}}"
                                style="height:100px;width:100px"></a>
                    @elseif(strpos($key,'category') !== false)
                        {{$data->category->name}}
                    @elseif(strpos($key,'brand') !== false)
                        {{$data->brand->name}}
                    @elseif(is_bool($data[$key]))
                        @if($data[$key])
                            是
                        @else
                            否
                        @endif
                    @else
                        {{$data[$key]}}
                    @endif
                </td>
            @endforeach
            <td>
                <div class="btn-group-vertical">
                    @if(isset($show_link))
                        <a href="{{route($show_link,['id' => $data['id']])}}" class="btn btn-info text-light">显示</a>
                    @endif
                    @if(isset($edit_link))
                        <a href="{{route($edit_link,['id' => $data['id']])}}" class="btn btn-info text-light">编辑</a>
                    @endif
                    @if(isset($check))
                        <input type="checkbox" name="check_list[]"
                               @if($check_type == 'collection')
                               @if($collection->products->contains($data))
                               checked
                               @endif
                               @endif
                               value="{{$data['id']}}">
                    @endif
                </div>
            </td>


        </tr>
    @endforeach
    </tbody>
</table>