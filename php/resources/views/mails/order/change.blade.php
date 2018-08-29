@extends('mails.base')

@section('message_content')
<p>嗨 {{ $order->name }}</p>
<p>
  感謝您參加了大寫鎖定工作室所舉辦的活動「{{ $order->event->name }}」
</p>
<p>
  因為活動報名踴躍以及場地無法預期租/借，將活動場地改為 {{ $order->event->address }} {{ $order->event->place }}
</p>
<p>
  若是因為活動場地無法出席者，請透過 Telegram 或是直接在 Disqus 留下您的訂單編號，會幫您進行處理
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
