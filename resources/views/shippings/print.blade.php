<!DOCTYPE html>
<html>
<head>
    <title>Job Print</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        <style>
    @media print {
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
        }
    }
</style>
    </style>
</head>
<body>
    <h2>Job #{{ $receipt_details->job_no }}</h2>
    <p>Date: {{ $receipt_details->date }}</p>
    <!-- Your job details here -->
    {{-- @dd( $receipt_details); --}}
    <table>
        <thead>
            <tr>
                <th>Bilty No</th>
                <th>Description</th>
                <th>From</th>
                <th>To</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receipt_details->details as $detail)
                <tr>
                    <td>{{ $detail->bilty_number }}</td>
                    <td>{{ $detail->description }}</td>
                    <td>{{ $detail->from_location }}</td>
                    <td>{{ $detail->to_location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
