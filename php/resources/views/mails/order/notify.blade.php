@extends('mails.base')

@section('message_content')
<p>嗨 {{ $order->name }}</p>
<p>
  感謝您參加了大寫鎖定工作室所舉辦的活動「{{ $order->event->name }}」
</p>
<p>
  提醒您，活動將於 {{ $order->event->start_at }} 開始，地點為 <span style="color: red;">{{ $order->event->address }} {{ $order->event->place }}</span>
</p>
<p>
  請申請相關特殊票券的聽眾，攜帶相關證明文件(學生、贊助票)
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
