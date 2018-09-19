@extends('layouts.app')

@section('content')


    @include('layouts.feedback')
    <div class="container-fluid mb-5 pb-3">
        <div class="row">
            <div class="list-group w-100">

                <div class="container-fluid mb-0 p-0 ">
                    <div class=" pt-3 pl-3 pr-3 "><h4 >关于我们</h4>
                    </div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"> First Shopping壹商店微商城是Tang Qi PTY LTD公司旗下专业澳洲代购直邮平台。澳洲本地用户首选的代购平台，一件无痕代发，省时省力；价格低廉，直邮高速；产品保真保质，货源稳定齐备！
                    </div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_1.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_2.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3">First Shopping壹商店澳洲代购直邮平台专业运营澳洲产品代购直邮，涵盖了婴儿奶粉（Baby Formula）、成人奶粉（Milk Powder）、营养保健（Health Supplements）、母婴用品（Mother&Baby Products）、健康食品（Health Food）、肌肤护理（Skin Care）等品类的澳洲全线产品。拥有销售可瑞康（Karicare）、贝拉米（Bellamy’s），A2奶粉、Swisse以及澳佳宝（Blackmores）等各大澳洲品牌经验。
                    </div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src={{asset('public/assets/about_us/P_3.jpeg')}}></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_4.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_5.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3">Tang Qi PTY LTD公司成立于2014年10月，公司总部位于澳大利亚墨尔本，在墨尔本同时拥有4家线下门店以及两家仓库，于2018年6月正式建立了First Shopping壹商店微商城澳洲代购直邮平台，为广大顾客铺设了一条便捷省心、一件代发直邮的通道。同时，平台全面支持支付宝与微信跨境支付，轻松便捷。我们拥有一支专业化的团队，团队本着提供最专业、最贴心、最便捷的服务宗旨，期待与您建立起长久稳固的合作关系。
                    </div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_6.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3"><img class="w-100" src="{{asset('public/assets/about_us/P_7.jpeg')}}"></div>
                    <div class=" pt-1 pl-3 pr-3  pb-3">我们郑重承诺：
                        货源渠道—First Shopping壹商店销售的所有商品均来自澳洲本地品牌厂商，100%品质保证。
                        物流渠道—First Shopping壹商店与澳洲一流的国际物流公司合作，线上线下无缝对接，快递物流周期大幅缩短，包裹全程追踪，为您提供稳定并高效的国际直邮物流体验。
                        售后渠道—First Shopping壹商店设有在线客服，为您提供更贴心、更便捷的售后服务。
                    </div>
                </div>

            </div>

        </div>
    </div>

    @include('home.layouts.bot-nav')
@endsection


