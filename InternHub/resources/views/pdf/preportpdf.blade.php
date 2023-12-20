<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Progress Report - {{ $report->period }}</title>
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
    <h1 style="text-align: center">{{ $scnumber }}</h1>
    <h1 style="text-align: center">{{ $report->period }}</h1>
    <hr>

    <h3>--Projects Involved-- </h3>
    <p>{!! $report->projects !!}</p>
    <hr style="border: none; border-top: 1px dashed black;">
    <h3>--Tasks Completed-- </h3>
    <p>{!! $report->tasks_completed !!}</p>
    <hr style="border: none; border-top: 1px dashed black;">
    <h3>--New Technologies Learned-- </h3>
    <p>{!! $report->technologies_learned !!}</p>
    <hr style="border: none; border-top: 1px dashed black;">

    {{-- Page Breaking --}}
    <div class="page-break"></div>
    <h3>--Technologies Used--</h3>
    <p>{!! $report->technologies_used !!}</p>
    <hr style="border: none; border-top: 1px dashed black;">
    <h3>--Problems Encountered-- </h3>
    <p>{!! $report->problems_encountered !!}</p>
    <hr style="border: none; border-top: 1px dashed black;">
    <h3>--Small Description-- </h3>
    <p>{!! $report->description !!}</p>
</body>
</html>
