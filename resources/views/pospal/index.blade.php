@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('layouts.feedback')
        @if(session('result'))
            <div class="row justify-content-center">
                <h3>结果：</h3>
                <div>修改前积分：{{session('result')['pointBeforeUpdate']}}</div>
                <div>修改后积分：{{session('result')['pointAfterUpdate']}}</div>
                <div>修改积分：{{session('result')['pointIncrement']}}</div>
            </div>
        @endif
        @if(session('points'))
            <div class="row justify-content-center">
                <h3>该用户积分：{{session('points')}}</h3>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                @component('layouts.form',[
                    'title' => '银豹会员修改积分',
                    'method' => 'post',
                    'action' => route('pospal.change_points'),
                    'fields' => [
                        [
                            'attr' => 'phone',
                            'label' => '会员手机',
                            'type' => 'text',
                            'required' => false
                        ],
                        [
                            'attr' => 'member_id',
                            'label' => '会员号',
                            'type' => 'text',
                            'required' => false
                        ],
                        [
                            'attr' => 'points',
                            'label' => '修改积分（变量）',
                            'type' => 'number',
                            'step' => '0.01',
                            'required' => true
                        ],
                        [
                            'attr' => 'search_method',
                            'label' => '搜索方式',
                            'type' => 'radio',
                            'radio_options' => [
                                [
                                    'value' => 'phone',
                                    'text' => '电话'
                                ],
                                [
                                    'value' => 'member_id',
                                    'text' => '会员ID',
                                    'checked' => true
                                ]
                            ]
                        ]
                    ],
                    'submit_text' => '提交'
                ]
                )
                @endcomponent
                <div class="container-fluid text-center mt-5">
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#check-point">查询积分</button>
                </div>
                @component('layouts.modal',[
                    'modal_id' => 'check-point',
                    'size' => 'modal-lg',
                    'title' => '查询积分'
                ])
                    @slot('content')
                        @component('layouts.form',[
                            'title' => '查询会员积分',
                            'method' => 'post',
                            'action' => route('pospal.get_member_points'),
                            'fields' => [
                                [
                                    'attr' => 'phone',
                                    'label' => '会员手机',
                                    'type' => 'text',
                                    'required' => false
                                ],
                                [
                                    'attr' => 'member_id',
                                    'label' => '会员号',
                                    'type' => 'text',
                                    'required' => false
                                ],
                                [
                                    'attr' => 'search_method',
                                    'label' => '搜索方式',
                                    'type' => 'radio',
                                    'radio_options' => [
                                        [
                                            'value' => 'phone',
                                            'text' => '电话'
                                        ],
                                        [
                                            'value' => 'member_id',
                                            'text' => '会员ID',
                                            'checked' => true
                                        ]
                                    ]
                                ]
                            ],
                            'submit_text' => '查询'
                        ])

                        @endcomponent
                    @endslot
                @endcomponent
            </div>
        </div>

    </div>

@endsection