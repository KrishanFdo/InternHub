<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intern Details - {{ $item->scnumber }}</title>
    <style>
        /* Page border with 0.5-inch margin */
        body {
            padding: 0.5in;
            border: 1px solid black;
        }

        /* Aligning Content 0.5 inches from the right */
        .content-container {
            width: calc(100% - 0.5in); /* Adjust for the 0.5in margin */
            word-wrap: break-word;
        }

        h1:first-of-type {
            margin-top: 0.1in; /* Adjust the value to your preference */
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">{{ $item->name }}</h1>
    <h2 style="text-align: center">{{ $item->scnumber }}</h2>
    <h2 style="text-align: center">Current GPA: {{ $item->gpa }}</h2>
    <hr>

    <h3 style="text-align: center">--Personal Details-- </h3>
    <h4 style="text-align: left">Email: {{ $item->email }}</h4>
    <h4 style="text-align: left">Contact Number: {{ $item->mobile }}</h4>
    <h4 style="text-align: left">Willing to apply for the Special Degree Program: {{ $item->special }}</h4>
    <h4 style="text-align: left">Credits Completed: {{ $item->credits }}</h4>
    <hr>
    <h3 style="text-align: center">--Internship Details-- </h3>
    <h4 style="text-align: left">Company: {{ $item->company }}</h4>
    <h4 style="text-align: left">Company Address: {{ $item->c_address }}</h4>
    <h4 style="text-align: left">HR Number: {{ $item->hr_number }}</h4>
    <h4 style="text-align: left">Started Date: {{ $item->s_date }}</h4>
    <h4 style="text-align: left">Expected Ending Date: {{ $item->e_date }}</h4>
    <hr>
    <h3 style="text-align: center">--Supervisor Details-- </h3>
    <h4 style="text-align: left">Supervisor Name: {{ $item->supervisor }}</h4>
    <h4 style="text-align: left">Email: {{ $item->s_email }}</h4>
    <h4 style="text-align: left">Contact Number: {{ $item->s_mobile }}</h4>
    <hr>

    {{-- Page Breaking --}}
    <div class="page-break"></div>
    <h3 style="text-align: center">--Technologies Using-- </h3>
    <p>{!! $item->technologies !!}</p>
    <hr>

    <h3 style="text-align: center">--Description-- </h3>
    <p>{!! $item->description !!}</p>
</body>
</html>
