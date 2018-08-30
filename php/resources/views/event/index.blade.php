@extends('base')

@section('title')
  活動列表
@endsection

@section('content')
  @include('title')
  <div class="container">
   @forelse ($events as $event)
    <div class="col-md-4" style="padding: 15px 15px 8px; padding: .75rem">
      <div class="card" style="margin-right: 15px; background: #FFF; border-radius: 8px;">
       <div style="display: inline; flex: 1 1 0%;">
        <a href="/event/{{ $event->id }}" style="display: block; width: 100%">
          <img class="img-responsive" src="{{ $event->poster ?: 'holder.js/520x260' }}" style="max-width: 280px; max-height: 140px; border-radius: 8px 8px 0px 0px; ; margin: 0 auto;">
        </a>
       </div>
       <div style="padding: 10px 10px 10px;">
         <div>
           <i class="far fa-clock"></i>
           <span>{{ $event->start_at ? $event->start_at->format('Y-m-d (D)') : 'N/A' }}</span>
         </div>
         <div>
           <i class="fas fa-dollar-sign"></i>
           <span> 一般: {{ $event->price }} NTD / 學生: {{ $event->price * (1 - $event->discount_rate) }} NTD </span>
         </div>
         <div style="padding-bottom: 8px;">
           <i class="fas fa-users"></i>
           <span>{{ $event->max - $event->left }} / {{ $event->max }} 人</span>
         </div>
         <div style="display: inline; flex: 1 1 0%;">
           <a href="/event/{{ $event->id }}">
            <b class="subtitle" style="line-height: 15px; white-space: normal; height: 30px; overflow: hidden; text-align: left;">
             {{ $event->name }}
            </b>
           </a>
         </div>
       </div>
      </div>
    </div>
   @empty

   @endforelse
 </div>

 <div class="container margin-bottom25 text-center">
  {{ $events->links() }}
 </div>
@endsection
