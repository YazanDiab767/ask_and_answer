@extends('layouts.app')

@section('title','اسأل و جاوب طلاب جامعة النجاح الوطنية')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')



<section class="vh-100">


    <div class="container h-100">
       
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="text-center">
            <h1 class>
                <img src="{{ asset("images/question.png") }}" width="50" height="50"/>
                Ask and answer An-Najah University students
            </h1>
        </div>
        <hr>

        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
            class="img-fluid" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form>
            <div class="mb-3">
                <h1> <i class="fa-solid fa-right-to-bracket"></i> Login </h1>
            </div>
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form1Example13" class="form-control form-control-lg" />
              <label class="form-label" for="form1Example13">Email address</label>
            </div>
  
            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="form1Example23" class="form-control form-control-lg" />
              <label class="form-label" for="form1Example23">Password</label>
            </div>
  
            <div class="d-flex justify-content-around align-items-center mb-4">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3"> Remember me </label>
              </div>
              <a href="#!">Forgot password?</a>
            </div>
  
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
  
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>
  
            <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
              role="button">
              <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
            </a>
            <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
              role="button">
              <i class="fab fa-twitter me-2"></i>Continue with Twitter</a>
  
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary fixed-bottom">  
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
@section('script')
@parent
    {{-- <script src=" {{ asset('js/index.js') }} "></script> --}}
@endsection