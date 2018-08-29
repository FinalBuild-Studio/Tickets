@extends('mails.base')

@section('message_content')
<p>嗨 {{ $order->name }}</p>
<p>
  感謝您參加了大寫鎖定工作室所舉辦的活動「{{ $order->event->name }}」
</p>
<p>
  您可以透過<a href="{{ action('ConfirmController@index', $order->reference) }}">這裡</a>查看您的電子票券
</p>
<p>
  如果您今天不克前往，臨時有事情，可以透過<a style="color: red;" href="{{ action('ReturnController@index', $order->reference, ['key' => $order->key]) }}">這裡</a>取消您的票券
</p>
<br>
<br>
<p>
  如果有其他問題，請向我們詢問
</p>
<p>
  祝您有個美好的一天
</p>
@endsection
