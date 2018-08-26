<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style media="screen">
      .s30 {
        font-size: 30vh;
      }

      .green {
        color: green;
      }

      .red {
        color: red;
      }

      .orange {
        color: orange;
      }

      .max-width {
        width: 100vh;
      }

      .max-height {
        height: 100vh;
      }
    </style>
  </head>
  <body>
    <div class="container text-center max-height max-width">
      @if (!$order)
        <div class="row">
          <div class="col-md">
            <i class="fas fa-times s30 red"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <h2>此報到編號不存在</h2>
          </div>
        </div>
      @elseif ($order->status === App\Order::INITIAL)
        <div class="row">
          <div class="col-md">
            <i class="fas fa-times s30 red"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <h2>尚未完成付款</h2>
          </div>
        </div>
      @else
        @if ($order->amount || !$order->event->price)
          <div class="row">
            <div class="col-md">
              <i class="fas fa-check s30 green"></i>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <h2>已完成報到手續</h2>
            </div>
          </div>
        @else
          <div class="row">
            <div class="col-md">
              <i class="fas fa-exclamation-triangle s30 orange"></i>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <h2>現場收取 {{ $order->total * $order->event->price }} 元</h2>
            </div>
          </div>
        @endif
      @endif
    </div>
  </body>
</html>
