@extends('layouts.app')

@section('content')
    @include('layouts.feedback')
    @if($order->package_method == 'auto' || $order->package_method == null)
        <Order :order-data="'{{ json_encode($order) }}'" :user-credits="'{{$user_credits}}'"></Order>
    @endif
    @if($order->package_method == 'self')
        <order-self :order-data="'{{json_encode($order)}}'" :user_credits="'{{$user_credits}}'">
            @csrf
        </order-self>
    @endif

    @if(isset($reminder) && $order->package_method == 'auto')
        @component('layouts.modal',[
            'modal_id'=>'reminder-message',
            'size'=>'modal-lg',
            'title'=>'温馨提示',
            'title_size'=>'h3',
        ])
            @slot('content')
                <form method="post" action="{{route('users.disable_delivery_reminder')}}">
                    @csrf
                    <div class="mt-4 ml-2 mr-2 mb-3 ">
                        产品预估重量：产品净重+外包装重量+箱子以及耗材重量，然后按0.1进制收尾法计算重量。<br>
                        运费计算：预估重量*运费单价，每个包裹最低为1kg起收取邮寄费用，待包裹查验核重完毕后，退还多收的运费到会员账户，运费多退不少补。<br>
                        增值服务：如需增值服务，请于下单自行时选择。<br>
                        打包规则：详情请见“物流打包规则条例”。<br>
                        产品赔偿：详情请见“物流赔偿条例”。
                    </div>
                    <div class="form-control w-100 form-inline bg-transparent border-0 mt-3 pl-3 pr-3">
                        <label><span class="text-muted">不再显示此消息</span>
                            <input type="checkbox" class="mr-2"
                                   name="disable_delivery_reminder" style="transform: scale(1.3)">
                            <span class="checkmark"></span>

                        </label>

                    </div>
                    <button type="submit" class="w-100 text-white btn btn-block btn-lg mt-3"
                            style="background-color:#62A2EC">确定
                    </button>
                </form>
            @endslot
        @endcomponent
    @endif

    @include('home.layouts.bot-nav')
@endsection