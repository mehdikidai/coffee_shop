<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Receipt #{{ $order->id }}</title>

  <style>

    *{
        color: #000;
    }

    @page {
      size: 80mm auto;
      margin: 0;
    }

    body {
      width: 80mm;
      margin: 0;
      padding: 0;
      font-family: 'Courier New', monospace;
      font-size: 11px;
      direction: ltr;
    }

    .container {
      padding: 20px 15px 30px;
    }

    h2, p {
      margin: 4px 0;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
        text-align: start;
    }

    th, td {
      border-bottom: 1px dashed #000000;
      padding: 6px 2px;
    }

    tfoot td {
      border-top: 1px solid #000000;
      font-weight: bold;
    }

    .footer {
      margin-top: 100px;
      margin-bottom: 40px;
      text-align: center;
      font-size: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>{{ $name_store }}</h2>
    <p>Customer: {{ $order->user->name }}</p>
    <p>Order: {{ $order->id }}</p>
    <p>Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th style="text-align:center;">Qty</th>
          <th style="text-align:right;">Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->items as $item)
        <tr>
          <td>{{ \Illuminate\Support\Str::limit($item->product->name, 20) }}</td>
          <td style="text-align:center;">{{ $item->quantity }}</td>
          <td style="text-align:right;">{{ number_format($item->price * $item->quantity, 2) }} MAD</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2" style="text-align:start;">Total:</td>
          <td style="text-align:right;">
            {{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 2) }} MAD
          </td>
        </tr>
      </tfoot>
    </table>

    <div class="footer">
      Thank you for your purchase!
    </div>
  </div>
</body>

</html>
