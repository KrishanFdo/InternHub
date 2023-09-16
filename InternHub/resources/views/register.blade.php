<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    #login {
        display: inline-block;
        padding: 5px 15px;
        float: right;
        margin-right: 20px;
        background-color: #0c71b4;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.2s ease;
    }

    #login:hover {
        background-color: #9acbe7;
    }

    #login:focus {
        outline: none;
    }
  </style>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InternHub-DCS | Register</title>
  <!--bootstrap css-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="CSS/update.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>


<body>

  <div >
    <div>
      <div>
        <br>
        <h1 class="fs-8 ms-6 name" style="text-align: center"><span class="text" >InternHub - DCS - University Of Ruhuna</span></h1>

      </div>
    </div>
    <div class="content">
      <nav class="navbar navbar-expand-md py-3 navbar-light bg-light ">
        </nav>
      <div class="dashboard-content ms-5 px-3 pt-4">
        <a id="login" href="<?=url('/login')?>">Login</a>
        <div class="container mt-3 ms-2">
          <div class="dashboard-content ms-5 px-3 pt-4">
            <div class="container">
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
                <form class="form-group" action="<?=url('/register-submit')?>" method="POST" enctype='multipart/form-data'>

                    <h3 style="text-decoration: underline;">Personal Details</h3><br>
                    <div class="row jumbotron">
                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Name with Initals</label>
                            <input type="text" class="form-control " name="name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;"> SC Number </label>
                            <input type="text" class="form-control" placeholder="SC/20**/*****" name="scnumber">
                            @error('scnumber')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Email</label>
                                <input type="text" class="form-control" placeholder="Email address" name="email" >
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <br>
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Contact Number </label>
                            <input type="text" class="form-control " placeholder="+94XXXXXXXXX" name="mobile">
                            @error('mobile')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Current GPA</label>
                            <input type="text" class="form-control " placeholder="#.##" name="gpa">
                            @error('gpa')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Are You Expecting to follow BCS Special Degree?</label><br>
                            <select class="form-select" name="special">
                                <option value="" disabled selected>Select</option>
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                            @error('special')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Profile photo</label>
                                <div class="form-group">
                                    <input class="form-control" type="file" name="image" value="" />
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    </div><br>

                    <div class="row jumbotron">

                        <h3 style="text-decoration: underline;">Industrial Training Details</h3><br><br><br>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Company Name</label>
                            <select name="company" id="company" class="form-select">
                                <option value="" disabled selected>Select</option>
                                <option value="WSO2">WSO2</option>
                                <option value="ITX 360">ITX 360</option>
                                <option value="Epic Lanka">Epic Lanka</option>
                                <option value="CodeGen">CodeGen</option>
                                <option value="Bell Solutions">Bell Solutions</option>
                                <option value="Creative Software">Creative Software</option>
                                <option value="Virtusa">Virtusa</option>
                                <option value="EchonLabs">EchonLabs</option>
                                <option value="Sysco Labs">Sysco Labs</option>
                                <option value="Scicom Lanka">Scicom Lanka</option>
                                <option value="Blue Lotus 360">Blue Lotus 360</option>
                                <option value="Enactor">Enactor</option>
                                <option value="Adeona Technologies">Adeona Technologies</option>
                                <option value="VizuaMatix">VizuaMatix</option>
                                <option value="Nvision">Nvision</option>
                                <option value="SLT Digital Labs">SLT Digital Labs</option>
                                <option value="SLT Digital Services">SLT Digital Services</option>
                                <option value="Future CX">Future CX</option>
                                <option value="99X">99X</option>
                                <option value="IFS">IFS</option>
                                <option value="DCS">DCS</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('company')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

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

                        <div id="hidden_html_tag" class="col-sm-6 mb-4" style="display: none;">
                            <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Other Company</label>
                            <input type="text" class="form-control" placeholder="Enter Company Name" name="other-company" required>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Company Address</label>
                            <input type="text" class="form-control " name="c_address">
                            @error('c_address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">HR Department Contact Number</label>
                            <input type="text" class="form-control " placeholder="+94XXXXXXXXX" name="hr_number">
                            @error('hr_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Started Date of Training</label>
                            <input type="date" class="form-control " name="s_date">
                            @error('s_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Expecting Ending Date of Training</label>
                            <input type="date" class="form-control " name="e_date">
                            @error('e_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Supervisor Name with Initials</label>
                            <input type="text" class="form-control " name="supervisor">
                            @error('supervisor')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Email of Supervisor</label>
                            <input type="text" class="form-control " name="s_email">
                            @error('s_email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label style="color: blue;">Contact Number of Supervisor</label>
                            <input type="text" class="form-control " placeholder="+94XXXXXXXXX" name="s_mobile">
                            @error('s_mobile')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label style="color: blue;">Description about Currrent Training Setup (150 words)</label>
                            <textarea row="4" col="50" name="description" class="form-control" style="height: 200px;"></textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror<br>
                        </div>


                        </div>
                        <div style="text-align: center">
                            <input type="hidden" name="_token" value="<?=csrf_token()?>">
                            <input type="submit" value="Submit" class="btn btn-primary btn-md col-sm-4" style="width: 15%; height: 10%">
                        </div><br><br>
              </form>
            </div>
          </div>
        </div>
</body>
</html>
