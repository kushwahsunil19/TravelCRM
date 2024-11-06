<!DOCTYPE html>
<html>
<head>
    <title>Hotel Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
        .expense-list {
            margin: 0;
            padding-left: 20px; 
        }
    </style>
</head>
<body>

<h1>Hotel Report</h1>

<table>
    <thead>
        <tr>
            <th>S. No</th>
            <th>Name</th>
            <th>Expenses</th>
            <th>Date</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @php $serialNumber = 1; @endphp
        @foreach ($suppliers as $supplier)
            <tr>
                <td class="center">{{ $serialNumber++ }}</td>
                <td>{{ $supplier->name }}</td>
                <td>
                    @if($supplier->expenses->isEmpty())
                        No expenses
                    @else
                        <ul class="expense-list">
                            @php $totalAmount = 0; @endphp
                            @foreach ($supplier->expenses as $expense)
                                @if ($expense->amount > 0) <!-- Only show expenses with non-zero amounts -->
                                    <li>{{ $expense->title }} = {{ number_format($expense->amount, 2) }}</li>
                                @endif
                                @php $totalAmount += $expense->amount; @endphp
                            @endforeach
                        </ul>
                    @endif
                </td>
               <td>{{$supplier->created_at}}</td>
                <td>
                    @if($supplier->expenses->isNotEmpty() && $totalAmount > 0)
                        {{ number_format($totalAmount, 2) }} <!-- Show total only if greater than 0 -->
                    @else
                        0.00
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
