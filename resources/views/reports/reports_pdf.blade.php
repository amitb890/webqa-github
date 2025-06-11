<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meta Title Report - {{ $activeProject->name }}</title>
    <style>
        /* Define your PDF styles here */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Meta Title Report</h2><br>
        <h3>Project URL : {{ $activeProject->homepage }}
        <br>
        Date : {{ date('jS F Y') }}</h3>
    <table>
        <thead>
            <tr>
                @foreach($data[0] as $key => $value)
                    <th @if($key == 'Meta Title Content') width="60%"  @endif) 
                    style="background-color: #000; 
                   border: 1px solid white;
                   color: #fff"><strong>{{ $key }}</strong></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $key=>$value)
                        <td @if($key == 'duplicate' || $key == 'equal_h1') 
                           {{-- @if($value == 'Yes')
                             style="background: #e5f5df !important;"
                             @else
                             style="background: #f9e6e6 !important;"
                           @endif --}}
                         @endif>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
