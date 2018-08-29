@extends('base')

@section('title')
  訂單確認
@endsection

@section('content')
  @php
    $event = $order->event;
  @endphp
  @include('head')
  <style>
    /*@todo  This is temp - move to styles*/
    h3 {
      border: none !important;
      font-size: 30px;
      text-align: center;
      margin: 0;
      margin-bottom: 30px;
      letter-spacing: .2em;
      font-weight: 200;
    }
    .order_header {
      text-align: center
    }
    .order_header .massive-icon {
      display: block;
      width: 120px;
      height: 120px;
      font-size: 100px;
      margin: 0 auto;
      color: #63C05E;
    }
    .order_header h1 {
      margin-top: 20px;
      text-transform: uppercase;
    }
    .order_header h2 {
      margin-top: 5px;
      font-size: 20px;
    }
    .order_details.well, .offline_payment_instructions {
      margin-top: 25px;
      background-color: #FCFCFC;
      line-height: 30px;
      text-shadow: 0 1px 0 rgba(255,255,255,.9);
      color: #656565;
      overflow: hidden;
    }
  </style>
  <section id="order_form" class="container">
    <div class="row">
      <div class="col-md-12 order_header">
        <span class="massive-icon">
        <i class="far fa-check-circle"></i>
        </span>
        <h1>感謝您的訂購</h1>
        <h2>
          關於您的票卷資訊已經透過e-mail寄給您了。
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="content event_view_order">
          <div class="order_details well">
            <div class="row">
              <div class="col-sm-4 col-xs-6">
                <b>名稱</b><br> {{ $order->name }}
              </div>
              <div class="col-sm-4 col-xs-6">
                <b>數量</b><br> {{ $order->total }}
              </div>
              <div class="col-sm-4 col-xs-6">
                <b>金額</b><br> {{ $order->amount }} NTD
              </div>
              <div class="col-sm-4 col-xs-6">
                <b>訂單號碼</b><br> {{ $order->reference }}
              </div>
              <div class="col-sm-4 col-xs-6">
                <b>日期</b><br> {{ $order->created_at }}
              </div>
              <div class="col-sm-4 col-xs-6">
                <b>Email</b><br> {{ $order->email }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(action('CheckinController@index', $order->reference))) !!}">
      </div>
    </div>
  </section>
@endsection
