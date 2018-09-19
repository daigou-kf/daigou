@extends('layouts.app')

@section('content')

    <h4 class="pl-3 pt-2 pb-1">常见问题</h4>
    @include('layouts.feedback')
    <div class="container-fluid mb-5 pb-3 ">
        <div class="row">
            <div class="list-group w-100">
                <button  class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q1">
                    First Shopping壹商店的商品是正品吗？
                </button>
                <div class="container-fluid mb-0 p-0 collapse" id="q1">
                    <div class="card pt-3 pl-3 pr-3 pb-3 "> Tang Qi成立于澳洲，在当地与多家厂商、药房等渠道建立稳定的合作关系，拥有一手货源，无任何中间环节，为广大渠道客户提供最划算的产品价格，100%正品保证！
                    </div>
                </div>
                <button
                        class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q2">海外直邮周期有多长？
                </button>
                <div class="container-fluid  mb-0 p-0 collapse" id="q2">
                    <div class="card pt-3 pl-3 pr-3 pb-3 "> 海外直邮流程包括了国际物流配送、国内海关清关、国内快递派送三个环节。其中国内海关清关属不可控环节，凡遇政策调整、节假日或其他重大会议、事件，清关时间均可能延长。通常情况下，您在First Shopping壹商店下单的包裹从国际物流发货到买家收件，一般历时8～10个工作日左右。
                    </div>
                </div>

                <button
                        class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q3">产品保质期新鲜吗？
                </button>
                <div class="container-fluid mb-0 p-0 collapse" id="q3">
                    <div class="card pt-3 pl-3 pr-3 pb-3 "> 产品保质期会标注于产品页面上，一般在品名旁或者产品底部。因商城批发货流量大，库存变动快，新货入库可能快于系统保质期更新，可能造成实际发出的货物保质期更优于网页标识，请您留意。
                    </div>
                </div>

                <button
                        class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q4">货款如何支付？
                </button>
                <div class="container-fluid mb-0 p-0 collapse" id="q4">
                    <div class="card pt-3 pl-3 pr-3 pb-3 ">用户可选择“微信支付”或“支付宝支付”，手续费率为1%.</div>
                </div>

                <button
                        class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q5">付款后多长时间发货？
                </button>
                <div class="container-fluid mb-0 p-0 collapse" id="q5">
                    <div class="card pt-3 pl-3 pr-3 pb-3 ">订单付款成功后，客户需上传收件人身份证照片信息。待上传收件人身份证照片信息上传完毕后，工作日当天即可打包发货。
                    </div>

                </div>

                <button
                        class="bg-gold text-white list-group-item list-group-item-action btn pt-2 pb-2" data-toggle="collapse" data-target="#q6">发货后，如何修改收件人信息？
                </button>
                <div class="container-fluid mb-0 p-0 collapse" id="q6">
                    <div class="card pt-3 pl-3 pr-3 pb-3 ">修改地址请联系线上客服（扫描下方二维码）。如果，产品已清关完毕，进入国内派送阶段，则无法确定地址更改一定成功，望悉知。.</div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-6 text-center">
                <span>客服1</span>
                <img class="w-100" src="{{asset('public/assets/CV_1.png')}}">
            </div>
            <div class="col-6 text-center">
                <span>客服2</span>
                <img class="w-100" src="{{asset('public/assets/CV_2.png')}}">
            </div>
        </div>
    @include('home.layouts.bot-nav')
@endsection


