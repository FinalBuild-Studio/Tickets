@extends('base')

@section('title')
  詳細訂單資訊
@endsection

@section('content')
  @include('head')
  <section id="order_form" class="container">
    <div class="row">
      <h1 class="section_head">
        詳細訂單資訊
      </h1>
    </div>
    <div class="col-md-12">
      <div class="event_order_form">
        <form method="POST" action="{{ action('PayController@store', $order->reference) }}">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="ticket_holders_details">
                <h3>購票人資訊</h3>
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="name">名稱</label>
                          <input required="required" class="ticket_holder_first_name form-control" name="name" type="text" id="name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="email">Email 地址</label>
                          <input required class="ticket_holder_email form-control" name="email" type="email" id="email">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input class="btn btn-lg btn-success card-submit" style="width:100%;" type="submit" value="結帳">
        </form>
      </div>
    </div>
  </section>
@endsection
