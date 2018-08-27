@extends('base')

@section('title')
  活動內容
@endsection

@section('content')
  @include('head')
  <script type="text/javascript">
    const updateTicket = id => {
      const map = {
        crypto: 'free',
        free: 'crypto'
      }
      const current = document.querySelector(`#${id}`)
      const remain = 3 - current.value

      while (document.querySelector(`#${map[id]}`).options.length) {
        document.querySelector(`#${map[id]}`).options[0] = null
      }

      for (let value = 0; value <= 3; value ++) {
        if (value <= remain) {
          const option = document.createElement('option')

          option.setAttribute('value', value)
          option.text = value

          document.querySelector(`#${map[id]}`).append(option)
        }
      }
    }
  </script>
  <section id="tickets" class="container">
    <div class="row">
      <h1 class="section_head">
        票種
      </h1>
    </div>
    <form method="POST" action="{{ action('CheckoutController@store', $event->id) }}">
     @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="content">
            <div class="tickets_table_wrap">
             @if ($event->left)
              <table class="table">
                <tbody>
                  <tr class="ticket" property="offers" typeof="Offer">
                    <td>
                      <span class="ticket-title semibold" property="name">
                        現場票
                      </span>
                      <p class="ticket-descripton mb0 text-muted" property="description">
                        到現場以現金支付新台幣 {{ $event->price }} 元 {{ $event->discount_rate ? '(學生優惠: 新台幣 '.((1 - $event->discount_rate) * $event->price).' 元)' : '' }}
                      </p>
                    </td>
                    <td style="width:180px; text-align: right;">
                      <div class="ticket-pricing" style="margin-right: 20px;">
                       0 NTD
                      </div>
                    </td>
                    <td style="width:85px;">
                      <select id="free" name="free" class="form-control" style="text-align: center" onchange="updateTicket('free')">
                        @for ($i = 0; $i <= $event->left && $i <= 3; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                    </td>
                  </tr>
                  @if ($event->price > 0)
                    <tr class="ticket" property="offers" typeof="Offer">
                      <td>
                        <span class="ticket-title semibold" property="name">
                         由加密貨幣支付
                        </span>
                        <p class="ticket-descripton mb0 text-muted" property="description">
                          支持多種加密貨幣
                        </p>
                      </td>
                      <td style="width:180px; text-align: right;">
                       <div class="ticket-pricing" style="margin-right: 20px;">
                        *{{ $event->price }} NTD
                       </div>
                      </td>
                      <td style="width:85px;">
                        <select id="crypto" name="crypto" class="form-control" style="text-align: center" onchange="updateTicket('crypto')">
                          @for ($i = 0; $i <= $event->left && $i <= 3; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      </td>
                    </tr>
                  @endif
                  <tr class="checkout">
                    <td colspan="3">
                      <div class="hidden-xs pull-left">
                        <div class="help-block" style="font-size: 11px;">
                         附註: 不同加密貨幣皆有不同折扣以及相關手續費
                        </div>
                      </div>
                      <input class="btn btn-lg btn-primary pull-right" type="submit" value="送出">
                    </td>
                  </tr>
                </tbody>
              </table>
             @else
              <div style="display:flex; align-items: center; justify-content: center;">
                <h4>所有票卷皆已售完</h4>
              </div>
             @endif
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
  <section id="details" class="container">
    <div class="row">
      <h1 class="section_head">
        活動內容
      </h1>
    </div>
    <div class="row">
      <div class="col-md-7">
        <div class="content event-details" property="description">
          {!! $event->description !!}
        </div>
      </div>
      <div class="col-md-5">
        <div class="content event-poster">
          <img alt="{{ $event->name }}" src="{{ $event->poster }}" property="image">
        </div>
      </div>
    </div>
  </section>
  @if($event->address)
    <section id="location" class="container p0">
      <div class="row">
        <div class="col-md-12">
          <div class="google-maps content">
            <iframe frameborder="0" style="border:0;" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&q={{ urlencode($event->address) }}"></iframe>
          </div>
        </div>
      </div>
    </section>
  @endif
@endsection
