<section id="intro" class="container" style="color: #666;">
  <div class="row">
    <div class="col-md-12">
      <h2 property="name">{{ $event->name }}</h2>
      <div class="event_venue">
        <span property="startDate" content="{{ $event->start_at->format('Y-m-d H:i') }}">
          {{ $event->start_at->format('Y-m-d H:i') }}
        </span>
        -
        <span property="endDate" content="{{ $event->end_at->format('Y-m-d H:i') }}">
          {{ $event->end_at->format('Y-m-d H:i') }}
        </span>
        @
        <span property="location" typeof="Place">
          <b property="name">{{ $event->place }}</b>
        </span>
      </div>
    </div>
  </div>
</section>
