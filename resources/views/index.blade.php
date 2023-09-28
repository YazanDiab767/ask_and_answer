@extends('layouts.app')

@section('title','Ask and answer An-Najah University students')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@if (auth()->user()) {{-- if user logged in return to main page --}}
    <script>window.location = "/main";</script>
@endif

@section('content')

    <div class="p-1 bg-primary text-center title">
        <h2 class="text-white">
            <img src="{{ asset("images/question.png") }}" width="50" height="50"/>
            Ask and answer An-Najah University students
        </h2>
    </div>

    <div class="container mt-2 pb-5">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-5 col-xl-5">
          <div class="card login-form text-white" style="border-radius: 1rem;">

            <div class="card-body card-login text-center">
  
              {{-- form login --}}
              <div class="mb-md-1 mt-md-1">
                <form action="{{ route('login') }}" method="POST">
                  @csrf
                  <h3 class="fw-bold mb-2"><i class="fa-solid fa-user-large"></i> Form Login</h3>

                  <hr style="color: white">
    
                  <div class="form-outline form-white mb-4">
                    <input type="number" id="universityID" name="universityID" value="{{ old('universityID') }}" class="form-control form-control-lg @error('universityID') is-invalid @enderror" required />
                    <label class="form-label" for="universityID">Student ID</label>
                    @error('universityID')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
    
                  <div class="form-outline form-white mb-4 mt-5">
                    <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required />
                    <label class="form-label"  for="password">Password</label>
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
    
    
                  <button class="btn btn-success mt-3 btn-lg px-5 w-100" type="submit"> <i class="fa-solid fa-right-to-bracket"></i> Login </button>
                </form>
                <p class="mt-3"><a class="text-white" href="#">Forgot password ?</a></p>

                <div class="divider d-flex align-items-center my-4">
                    <p class="text-center fw-bold mx-3 mb-0 text-white">OR</p>
                </div>

  
                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="#!" class="text-white mr-4">
                    <img src="{{ asset('images/facebook.png') }}" width="50" height="50" />
                  </a>
                  <a href="#!" class="text-white mr-4">
                    <img src="{{ asset('images/google.png') }}" width="50" height="50" />
                  </a>
                  <a href="#!" class="text-white mr-4">
                    <img src="{{ asset('images/twitter.png') }}" width="50" height="50" />
                  </a>
                </div>
  
              </div>
  
              <div class="mt-4">
                <p class="mb-0">Don't have an account? <a href="#" id="showFormSignUp" class="text-white fw-bold">Sign Up</a></p>
              </div>
  
            </div>

            <div class="card-body text-center card-sign-up">
  
                <div class="mb-md-1 mt-md-1">
                    <form action="{{ route('register') }}" id="formRegister" method="POST">
                      @csrf

                      <h2 class="fw-bold mb-2 text-uppercase"><i class="fa-solid fa-user-plus"></i> SignUp</h2>
    
                      <hr style="color: white">
      
                      <div class="form-outline form-white mb-4">
                          <input type="number" id="r_universityID" name="universityID" class="form-control form-control-lg" />
                          <label class="form-label" for="r_universityID">Student ID</label>
                      </div>

                      <div class="form-outline form-white mb-4">
                          <input type="text" id="r_name" name="name" class="form-control form-control-lg" />
                          <label class="form-label" for="r_name">Name</label>
                      </div>

                      <div class="mb-4">
                          <?php $year = date("y"); ?>
                          <select id = "r_classNum" name="classNum" class="form-control form-control-lg">
                              <option>Class Number</option>
                              @for ($i = ($year + 100); $i >= 115; $i--)
                                  <option value="{{$i}}" <?php echo (old('classNum') == $i ) ? "selected" : ""; ?> >{{ $i }}</option> 
                              @endfor
                          </select>
                      </div>
      
                      <div class="form-outline form-white mb-4">
                          <input type="password" id="r_password" name="password" class="form-control form-control-lg" />
                          <label class="form-label" for="r_password">Password</label>
                      </div>

                      <div class="form-outline form-white mb-4">
                        <input type="password" id="r_password-confirm" name="password_confirmation" class="form-control form-control-lg" />
                        <label class="form-label" for="r_password-confirm">Confirm  Password</label>
                      </div>

                      <div class="form-outline" id="result">
                      </div>

                      <button class="btn btn-success btn-lg px-5 w-100" id = "btn_register" type="submit"> <i class="fa-solid fa-plus"></i> SignUp </button>
                    </form>
                    <hr>

                    <a href="#" id="showLoginForm" class="text-white"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
    
                </div>

            </div>

          </div>
        </div>
      </div>
    </div>
    
    <div class="mt-5 d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-3 px-3 px-xl-4 bg-primary fixed-bottom">  
        <div class="text-white mb-3 mb-md-0">
            Copyright © 2023. All rights reserved.
        </div>

        <div>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
                <i class="fab fa-google"></i>
            </a>
            <a href="#!" class="text-white">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
  </div>

@endsection

@section('script')
@parent
    <script src=" {{ asset('js/index.js') }} "></script>
    <script src=" {{ asset('js/users/register.js') }} "></script>
@endsection