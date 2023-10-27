<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InternHub-DCS | Newly Registered</title>

    <!--bootstrap css-->
    <link href="{{ asset('css/userlist.css') }}" rel="stylesheet">
    <link href="{{ asset('css/usertiles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('css/searchoptions.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/userlist.css">

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
            <li class="active"><a href="/admin-accept" class="text-decoration-none px-3 py-3 d-block">NEWLY REGISTERED</a></li>
            <li class=""><a href="/users" class="text-decoration-none px-3 py-3 d-block">INTERNS</a></li>
            <li class=""><a href="/reports" class="text-decoration-none px-3 py-3 d-block">REPORTS</a></li>
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

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('mailerror'))
                    <div class="alert alert-danger">
                        {{ session('mailerror') }}
                    </div>
                @endif

                <br>
                <form style="margin-left: 0.5%;" class="form-group" action="<?=url('/filtered-registers')?>" method="GET">
                    <div style=" display: flex;">

                        <div style="margin-left: 1%;">
                            <label for="scnumber">SC Number</label>
                            <input type="text" class="form-control" id="scnumber" name="scnumber" value="{{ $selectedscnumber }}">
                            <div class="scnumber-select" id="scnumber-select">
                                <div class="select-scnumbers">
                                    <!-- Dynamic options will be inserted here -->
                                </div>
                            </div>
                        </div>

                        <div style="margin-left: 1%;">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" id="company" name="company" value="{{ $selectedcompany }}">
                            <div class="company-select" id="company-select">
                                <div class="select-companies">
                                    <!-- Dynamic options will be inserted here -->
                                </div>
                            </div>
                        </div>

                        <div style="margin-left: 1%;">
                            <label for="special">Expecting Special</label>
                            <select class="form-select" id="special" name="special" value="{{ $selectedspecial }}">
                                <option value="" {{ $selectedspecial == "" ? 'selected' : '' }}>All</option>
                                <option value="YES" {{ $selectedspecial == 'YES' ? 'selected' : '' }}>YES</option>
                                <option value="NO" {{ $selectedspecial == 'NO' ? 'selected' : '' }}>NO</option>
                            </select>
                        </div>

                    </div>
                    <div style=" display: flex;">
                        <button type="submit" class="btn btn-primary btn-md col-sm-4" style="width: 15%; height: 5%; margin-left: 1%; margin-top: 2.1%;">Apply Filters</button>
                        <button type="reset" id="customResetButton" class="btn btn-secondary btn-md col-sm-4" style="width: 15%; height: 5%; margin-left: 1%; margin-top: 2%;">Reset</button>

                        @if(count($data)!=0)
                            @if(count($data)==1)
                                <h5 style="margin-top: 3%; margin-left: 1%; color:rgba(189, 61, 10, 0.925)">{{ count($data) }} Intern Available</h5>
                            @else
                                <h5 style="margin-top: 3%; margin-left: 1%; color:rgba(189, 61, 10, 0.925)">{{ count($data) }} Interns Available</h5>
                            @endif
                        @endif
                    </div>



                    <script>
                        document.getElementById('customResetButton').addEventListener('click', function() {
                            // Perform the desired action when the reset button is clicked
                            window.location.href = "<?=url('/admin-accept')?>";
                        });

                        const searchscnumber = document.getElementById('scnumber');
                        const scnumberSelect = document.getElementById('scnumber-select');
                        const selectscnumbers = scnumberSelect.querySelector('.select-scnumbers');

                        //list of options
                        const scnumbers = [
                            "All",
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

                        //serach workplaces
                        const searchcompany = document.getElementById('company');
                        const companySelect = document.getElementById('company-select');
                        const selectcompanies = companySelect.querySelector('.select-companies');

                        //list of options
                        const companies = [
                            "All",
                            @foreach ($companies as $company)
                                "{{ $company }}",
                            @endforeach
                        ];

                        searchcompany.addEventListener('input', function () {
                            const searchValue = this.value.toLowerCase();
                            const filtered = companies.filter(option => option.toLowerCase().includes(searchValue));

                            // Generate HTML for filtered options
                            const html = filtered.map(option => `<div>${option}</div>`).join('');
                            selectcompanies.innerHTML = html;

                            // Show/hide the filtered options container
                            if (searchValue.length > 0) {
                                companySelect.style.display = 'block';
                            } else {
                                companySelect.style.display = 'block';
                                // If search box is empty, show all workplaces
                                selectcompanies.innerHTML = companies.map(option => `<div>${option}</div>`).join('');
                            }
                        });

                        // Handle option selection
                        companySelect.addEventListener('click', function (event) {
                            if (event.target.tagName === 'DIV') {
                                searchcompany.value = event.target.textContent;
                                companySelect.style.display = 'none';
                            }
                        });
                    </script>
                </form>

                @if($data->isEmpty())
                    <br>
                    <div class="alert alert-danger">
                        <p>NO USERS AVAILABLE</p>
                    </div>
                @endif
                <br>
                @foreach($data as $item)
                <div class="user-tile">
                    <div class="user-avatar">
                        <div style="display: flex;">
                        <img src="{{ asset('storage/'.$item->imgpath) }}" alt="User Avatar">
                        <div style="margin-top: 4%; margin-left: 1%;">
                            <h4 style="color: blue;">{{ $item->name }}</h4>
                            <h5 style="color: blue;">{{ $item->scnumber }}</h5>
                        </div>
                        <div style="float:right; margin-top: 2.5%; margin-right: 1%;">
                        <div class="container">
                            <form id="{{ $item->id }}" action="<?=url('/accept')?>" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <input type="submit" value="Accept" id="accept" onclick="confirmaccept(event)" data-aid="{{ $item->id }}">
                            </form>
                            <script>
                                function confirmaccept(event){
                                    event.preventDefault(); // Prevent the default form submission behavior
                                    const userId = event.target.getAttribute('data-aid');
                                    const result = confirm('Are you sure you want to accept?');
                                    if (result) {
                                        document.getElementById(userId).submit(); // Submit the form if OK is clicked
                                    }
                                }
                            </script>

                            <form id="{{ $item->id }}r" action="<?=url('/delete-register')?>" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <input type="submit" value="Remove" id="remove" onclick="confirmremove(event)" data-rid="{{ $item->id }}">
                            </form>
                            <script>
                                function confirmremove(event) {
                                    event.preventDefault(); // Prevent the default form submission behavior
                                    const userId = event.target.getAttribute('data-rid');
                                    const result = confirm('Are you sure you want to Remove?');
                                    if (result) {
                                        document.getElementById(userId+'r').submit(); // Submit the form if OK is clicked
                                    }
                                }
                            </script>
                        </div>
                        </div>
                        </div>
                    </div>
                    <div class="user-details">

                        <div style="display: flex;">
                            <div>
                                <p><b>Email:</b> {{ $item->email }}</p>
                                <p><b>Mobile:</b> {{ $item->mobile }}</p>
                                <p><b>Company:</b> {{ $item->company }}</p>
                                <p><b>HR Number:</b> {{ $item->hr_number }}</p>
                            </div>
                            <div style="margin-left: 10%">
                                <p><b>Started Date:</b> {{ $item->s_date }}</p>
                                <p><b>Supervisor:</b> {{ $item->supervisor }}</p>
                                <p><b>Supervisor Email:</b> {{ $item->s_email }}</p>
                                <p><b>Supervisor Mobile:</b> {{ $item->s_mobile }}</p>
                            </div>
                        </div><br>
                    </div>

                </div>
                @endforeach
                </div>

    </div>
   </div>

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
