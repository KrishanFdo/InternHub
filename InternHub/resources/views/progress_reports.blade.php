<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InternHub-DCS | Interns</title>

    <!--bootstrap css-->
    <link href="{{ asset('css/userlist.css') }}" rel="stylesheet">
    <link href="{{ asset('css/usertiles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('css/searchoptions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reports.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/userlist.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

   <div class="main-container d-flex">
    <div class="sidebar " id="side_nav">
         <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
            <h1 class="fs-3 ms-2 name"><span class="text">InternHub-DCS</span></h1>
            <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i class="fa-solid fa-bars-staggered"></i></button>
        </div>


        <ul class="list-unstyled px-2 ">
            <li class=""><a href="<?=url('/home')?>" class="text-decoration-none px-3 py-3 d-block">HOME</a></li>
            <li class=""><a href="/admin-accept" class="text-decoration-none px-3 py-3 d-block">NEWLY REGISTERED</a></li>
            <li class=""><a href="/users" class="text-decoration-none px-3 py-3 d-block">INTERNS</a></li>
            <li class="active"><a href="/reports" class="text-decoration-none px-3 py-3 d-block">REPORTS</a></li>
        </ul>


    </div>
    <div class="content">

        <nav class="navbar navbar-expand-md py-3 navbar-light bg-light ">
            <div class="container-fluid">
            <div class="d-flex justify-content-between d-md-none d-block">
            <button class="btn px-1 py-0 open-btn me-2"><i class="fa-solid fa-bars-staggered"></i></button>
            <a class="navbar-brand fs-4" href="#"></a>
            </div>
            <button class="navbar-toggler p-0 border-0 " type="button" onclick="toggleContent()">

                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
              <ul class="navbar-nav  mb-2 mb-lg-0">
                <!--<li class="nav-item py-2 p-2 me-4">
                    <i class="fa-solid fa-bell"></i>
                </li>-->
                <nav class="navbar navbar-expand-md py-3 navbar-light bg-light ">
                    <img src="" class="avatar">
                    <form id="logout" method="POST" action="<?=url('/adminlogout')?>">
                        @csrf
                        <input type="submit" class="btn btn-secondary default btn" onclick="confirmlogout(event)" value="Logout" name="logout" />
                    </form>
                    <script>
                        function confirmlogout(event) {
                            event.preventDefault(); // Prevent the default form submission behavior
                            const result = confirm('Are you sure you want to logout?');
                            if (result) {
                                document.getElementById('logout').submit(); // Submit the form if OK is clicked
                            }
                        }
                    </script>
                </nav>

              </ul>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            function toggleContent() {
                $('#navbarSupportedContent').toggleClass('show');
            }
            </script>
        </div>
          </nav>

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif
        <br>
        <form id="submitform" action="<?=url('/filtered-reports')?>" method="POST" style="margin-left: 1%">
            @csrf

            <div class="form-group">
                <label for="scnumber"><b>SC Number</b></label>
                <input type="text" class="form-control" id="scnumber" name="scnumber" style="width: 50%" placeholder="Type SC Number" value="{{ $scnumber }}" required >
                <div class="scnumber-select" id="scnumber-select">
                    <div class="select-scnumbers">
                        <!-- Dynamic options will be inserted here -->
                    </div>
                </div>
            </div><br>

            <input type="submit" class="btn btn-primary" id="submitBtn" value="See Reports"></input>
            <button type="button" id="customResetButton" class="btn btn-secondary">Reset</button>
        </form>
        <script>
            const searchscnumber = document.getElementById('scnumber');
                        const scnumberSelect = document.getElementById('scnumber-select');
                        const selectscnumbers = scnumberSelect.querySelector('.select-scnumbers');

                        //list of options
                        const scnumbers = [
                            @foreach ($scnumbers as $scnumber)
                                "{{ $scnumber }}",
                            @endforeach
                        ];

                        searchscnumber.addEventListener('input', function () {
                            const searchValue = this.value.toLowerCase();
                            const filtered = scnumbers.filter(option => option.toLowerCase().includes(searchValue));

                            // Generate HTML for filtered options
                            const html = filtered.map(option => `<div>${option}</div>`).join('');
                            selectscnumbers.innerHTML = html;

                            // Show/hide the filtered options container
                            if (searchValue.length > 0) {
                                scnumberSelect.style.display = 'block';
                            } else {
                                scnumberSelect.style.display = 'block';
                                // If search box is empty, show all positions
                                selectscnumbers.innerHTML = scnumbers.map(option => `<div>${option}</div>`).join('');
                            }
                        });

                        // Handle option selection
                        scnumberSelect.addEventListener('click', function (event) {
                            if (event.target.tagName === 'DIV') {
                                searchscnumber.value = event.target.textContent;
                                scnumberSelect.style.display = 'none';
                            }
                        });

                        const resetBtn = document.getElementById('customResetButton');

                // Add an event listener to the button
                resetBtn.addEventListener('click', function () {
                    // Define the route URL you want to navigate to
                    const routeURL = '/reports';

                    // Navigate to the specified route
                    window.location.href = routeURL;
                });
        </script>
        <br>
        @if($reports->count() != 0)
            @if($reports->count() == 1)
                <h3 style="margin-left: 1%; color: rgb(156, 86, 6);">{{ $name }} - 1 Report Available</h3>
            @else
                <h3 style="margin-left: 1%; color: rgb(156, 86, 6);">{{ $name }} - {{ $reports->count() }} Reports Available</h3>
            @endif

            @foreach ($reports as $key => $report)
                @php
                    $timestamp = $report->created_at;
                    $date_obj = \DateTime::createFromFormat('Y-m-d H:i:s', $timestamp);
                    $date = $date_obj->format('Y-m-d');
                @endphp
                <div class="report-container" id="report-{{ $key }}">
                    <div class="report-title" onclick="toggleReport({{ $key }})">Report {{ $loop->iteration }} - {{ $date}}</div>
                    <div class="report-content" style="display: none;">
                        <h5>Question 1</h5>
                        <p>{{ $report->a1 }}</p>
                        <h5>Question 2</h5>
                        <p>{{ $report->a2 }}</p>
                        <h5>Question 3</h5>
                        <p>{{ $report->a3 }}</p>
                    </div>
                </div><br>
            @endforeach
        @else
                @if ($name != "")
                    <h3 style="margin-left: 1%; color: rgb(156, 86, 6);">{{ $name }} - No Reports Available</h3>
                @endif
        @endif
    </div>
   </div>

   <script>
    function toggleReport(reportIndex) {
        var reportContent = document.getElementById('report-' + reportIndex).getElementsByClassName('report-content')[0];

        if (reportContent.style.display === 'none') {
            reportContent.style.display = 'block';
        } else {
            reportContent.style.display = 'none';
        }
    }
    </script>


   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://kit.fontawesome.com/c752b78af3.js" crossorigin="anonymous"></script>


   <script>
    $(".sidebar ul li").on('click', function() {
            $(".sidebar ul li.active").removeClass('active');
            $(this).addClass('active');

        })

        $('.open-btn').on('click',function(){
     $('.sidebar').addClass('active');
        })

        $('.close-btn').on('click',function(){
     $('.sidebar').removeClass('active');
        })



    </script>


</body>
</html>