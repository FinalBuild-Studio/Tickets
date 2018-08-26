<b>
  轉址中，請勿關閉目前視窗...
</b>
<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayment">
  <input type="hidden" name="cmd" value="_pay_simple">
  <input type="hidden" name="reset" value="1">
  <input type="hidden" name="merchant" value="{{ env('PAYMENT_MERCHANT_ID') }}">
  <input type="hidden" name="currency" value="{{ env('PAYMENT_CURRENCY', 'TWD') }}">
  <input type="hidden" name="amountf" value="{{ $order->amount }}">
  <input type="hidden" name="item_name" value="大寫鎖定工作室(訂單編號: #{{ $order->reference }})">
  <input type="hidden" name="item_number" value="{{ $order->reference }}">
  <input type="hidden" name="success_url" value="{{ action('ConfirmController@index', $order->reference) }}">
</form>

<script type="text/javascript">
  document.getElementById('coinpayment').submit()
</script>
