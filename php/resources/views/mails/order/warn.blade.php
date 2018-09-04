@extends('mails.base')

@section('message_content')
<p>嗨 {{ $order->name }}</p>
<p>
  感謝您參加了大寫鎖定工作室所舉辦的活動「{{ $order->event->name }}」
</p>
<p>
  提醒您，報名該活動相關主辦單位票券者，<span style="color: red;">需要有主辦單位提供的證明佐證</span>，若是無法提供相關證明者，場地主辦單位有權力可以拒絕入場。
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
