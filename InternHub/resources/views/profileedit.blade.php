<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InternHub-DCS | Home</title>

    <!--bootstrap css-->
    <link href="{{ asset('css/userlist.css') }}" rel="stylesheet">
    <link href="{{ asset('css/usertiles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/button.css') }}" rel="stylesheet">

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
            <li class=""><a href="<?=url('/userhome')?>" class="text-decoration-none px-3 py-3 d-block">HOME</a></li>
            <li class=""><a href="/user-reset-password" class="text-decoration-none px-3 py-3 d-block">CHANGE PASSWORD</a></li>
            <li class="active"><a href="/profile/edit" class="text-decoration-none px-3 py-3 d-block">UPDATE PROFILE</a></li>
            <li class=""><a href="/submit_report" class="text-decoration-none px-3 py-3 d-block">SUBMIT REPORT</a></li>
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
                    <form id="logout" method="POST" action="<?=url('/logout')?>">
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

          <br>

          <div style="margin-left: 1%">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('fail'))
                <div class="alert alert-danger">{{ session('fail') }}</div>
            @endif

            <form id="profileUpdateForm" action="<?=url('/profile/update')?>" method="POST">
                <h5 style="color: blue">Personal Details</h5>
                @csrf
                @method('PUT')
                <div style="display:flex;">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" readonly>
                        @error('name')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="scnumber">SC Number</label>
                        <input type="scnumber" id="scnumber" name="scnumber" value="{{ $user->scnumber }}" class="form-control" readonly>
                        @error('scnumber')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
                        @error('email')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" name="mobile" value="{{ $user->mobile }}" class="form-control" readonly>
                        @error('mobile')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="gpa">Current GPA</label>
                        <input type="text" id="gpa" name="gpa" value="{{ $user->gpa }}" class="form-control">
                        @error('gpa')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="special">Expecting Special</label>
                        <select class="form-select" name="special">
                            <option value="" disabled selected>Select</option>
                            <option value="YES" {{ $user->special === 'YES' ? 'selected' : '' }}>YES</option>
                            <option value="NO" {{ $user->special === 'NO' ? 'selected' : ''  }}>NO</option>
                        </select>
                        @error('special')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="credits">Credits Completed</label>
                        <input type="text" id="credits" name="credits" value="{{ $user->credits }}" class="form-control">
                        @error('credits')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <h5 style="color: blue">Industrial Training Details</h5>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <select name="company" id="company" class="form-select">
                            <option value="" disabled selected>Select</option>
                            <option value="WSO2" {{ $user->company === 'WSO2' ? 'selected' : '' }}>WSO2</option>
                            <option value="ITX 360" {{ $user->company === 'ITX 360' ? 'selected' : '' }}>ITX 360</option>
                            <option value="Epic Lanka" {{ $user->company === 'Epic Lanka' ? 'selected' : '' }}>Epic Lanka</option>
                            <option value="CodeGen" {{ $user->company === 'CodeGen' ? 'selected' : '' }}>CodeGen</option>
                            <option value="Bell Solutions" {{ $user->company === 'Bell Solutions' ? 'selected' : '' }}>Bell Solutions</option>
                            <option value="Creative Software" {{ $user->company === 'Creative Software' ? 'selected' : '' }}>Creative Software</option>
                            <option value="Virtusa" {{ $user->company === 'Virtusa' ? 'selected' : '' }}>Virtusa</option>
                            <option value="EchonLabs" {{ $user->company === 'EchonLabs' ? 'selected' : '' }}>EchonLabs</option>
                            <option value="Sysco Labs" {{ $user->company === 'Sysco Labs' ? 'selected' : '' }}>Sysco Labs</option>
                            <option value="Scicom Lanka" {{ $user->company === 'Scicom Lanka' ? 'selected' : '' }}>Scicom Lanka</option>
                            <option value="Blue Lotus 360" {{ $user->company === 'Blue Lotus 360' ? 'selected' : '' }}>Blue Lotus 360</option>
                            <option value="Enactor" {{ $user->company === 'Enactor' ? 'selected' : '' }}>Enactor</option>
                            <option value="Adeona Technologies" {{ $user->company === 'Adeona Technologies' ? 'selected' : '' }}>Adeona Technologies</option>
                            <option value="VizuaMatix" {{ $user->company === 'VizuaMatix' ? 'selected' : '' }}>VizuaMatix</option>
                            <option value="Nvision" {{ $user->company === 'Nvision' ? 'selected' : '' }}>Nvision</option>
                            <option value="SLT Digital Labs" {{ $user->company === 'SLT Digital Labs' ? 'selected' : '' }}>SLT Digital Labs</option>
                            <option value="SLT Digital Services" {{ $user->company === 'SLT Digital Services' ? 'selected' : '' }}>SLT Digital Services</option>
                            <option value="Future CX" {{ $user->company === 'Future CX' ? 'selected' : '' }}>Future CX</option>
                            <option value="99X" {{ $user->company === '99X' ? 'selected' : '' }}>99X</option>
                            <option value="IFS" {{ $user->company === 'IFS' ? 'selected' : '' }}>IFS</option>
                            <option value="DCS" {{ $user->company === 'DCS' ? 'selected' : '' }}>DCS</option>
                            <option value="Other" {{ $user->company === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('company')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <br>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const selectList = document.getElementById('company');
                            const hiddenHtmlTag = document.getElementById('hidden_html_tag');

                            // Function to toggle visibility and required attribute of the HTML tag
                            function toggleHtmlTagVisibility() {
                                if (selectList.value === 'Other') {
                                    hiddenHtmlTag.style.display = 'block';
                                    hiddenHtmlTag.querySelector('input').setAttribute('required', 'required');
                                } else {
                                    hiddenHtmlTag.style.display = 'none';
                                    hiddenHtmlTag.querySelector('input').removeAttribute('required');
                                }
                            }

                            // Call the function initially to set the initial state
                            toggleHtmlTagVisibility();

                            // Add an event listener to the select list to update visibility and required attribute on change
                            selectList.addEventListener('change', toggleHtmlTagVisibility);
                        });
                    </script>

                    <div id="hidden_html_tag" class="form-group" style="display: none; margin-left: 1%">
                        <label for="other-company">Other Company</label>
                        <input type="text" class="form-control" placeholder="Enter Company Name" name="other-company" required>
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="c_address">Company Address</label>
                        <input type="text" id="c_address" name="c_address" value="{{ $user->c_address }}" class="form-control">
                        @error('c_address')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="hr_number">HR Number</label>
                        <input type="text" id="hr_number" name="hr_number" value="{{ $user->hr_number }}" class="form-control">
                        @error('hr_number')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="s_date">Started Date</label>
                        <input type="date" id="s_date" name="s_date" value="{{ $user->s_date }}" class="form-control">
                        @error('s_date')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="e_date">Ending Date</label>
                        <input type="date" id="e_date" name="e_date" value="{{ $user->e_date }}" class="form-control">
                        @error('e_date')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="supervisor">Supervisor</label>
                        <input type="text" id="supervisor" name="supervisor" value="{{ $user->supervisor }}" class="form-control">
                        @error('supervisor')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-left: 1%">
                        <label for="s_email">Email of Supervisor</label>
                        <input type="text" id="s_email" name="s_email" value="{{ $user->s_email }}" class="form-control">
                        @error('s_email')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div style="display:flex;">
                    <div class="form-group">
                        <label for="s_mobile">Supervisor Number</label>
                        <input type="text" id="s_mobile" name="s_mobile" value="{{ $user->s_mobile }}" class="form-control">
                        @error('s_mobile')
                            <label class="alert alert-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div><br>

                <div class="form-group">
                    <label for="technologies">Technologies you are using in the Training Setup</label>
                    <textarea rows="5" cols="20" name="technologies" class="form-control">{!! str_replace('<br />', "", $user->technologies) !!}</textarea>
                    @error('technologies')
                        <label class="alert alert-danger">{{ $message }}</label>
                    @enderror<br>
                </div>

                <div class="form-group">
                    <div style="display:flex;">
                        <label>Description about Training Setup (150 words)</label>
                        <div id="wordCount">: Word Count: 0</div>
                    </div>
                    <textarea rows="10" cols="20" id="description" name="description" class="form-control">{!! str_replace('<br />', "", $user->description) !!}</textarea>
                    @error('description')
                        <label class="alert alert-danger">{{ $message }}</label>
                    @enderror<br>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const textarea = document.getElementsByName('description')[0]; // Use getElementsByName to access the textarea by name
                        const wordCountDisplay = document.getElementById('wordCount');
                        const submitButton = document.getElementById('submitButton');

                        function updateWordCount() {
                            const text = textarea.value;
                            const words = text.trim().split(/\s+/);
                            const wordCount = words.length;
                            wordCountDisplay.textContent = `: Word Count: ${wordCount}`;

                            // Check if word count is greater than or equal to 150
                            if (wordCount >= 150) {
                                wordCountDisplay.style.color = 'green';
                            } else {
                                wordCountDisplay.style.color = 'red'; // Reset to default color
                            }
                        }

                        textarea.addEventListener('input', updateWordCount);

                        // Call the function initially to set the initial state
                        updateWordCount();
                    });
                </script>


                <br>
                <button type="submit" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                <button type="reset" id="customResetButton" class="btn btn-secondary">Reset</button>
            </form>
            <script>
                // Get the button element
                const updateProfileBtn = document.getElementById('updateProfileBtn');

                // Add an event listener to the button
                updateProfileBtn.addEventListener('click', function (event) {
                  // Prevent the default form submission behavior
                  event.preventDefault();

                  // Display a confirmation dialog
                  const result = confirm('Are you sure you want to update your profile?');

                  // If the user clicks "OK," submit the form
                  if (result) {
                    // Assuming your form has an id attribute (e.g., 'profileUpdateForm')
                    document.getElementById('profileUpdateForm').submit();
                  }
                });
              </script>

              <script>
                // Get the "Reset" button element
                const resetBtn = document.getElementById('customResetButton');

                // Add an event listener to the button
                resetBtn.addEventListener('click', function () {
                    // Define the route URL you want to navigate to
                    const routeURL = '/profile/edit';

                    // Navigate to the specified route
                    window.location.href = routeURL;
                });
            </script>
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
    <br>
</body>
</html>
