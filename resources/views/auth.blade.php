<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
    
    
    
    
  </head>
  <body>
    <div class="hero">
      <div class="form-box">
        <div class="button-box">
          <div id="btn"></div>
          <button type="button" class="toggle-btn" onclick="login()">
            Login
          </button>
          <button type="button" class="toggle-btn" onclick='register()'>
            Register
          </button>
        </div>
        <form class="inputs-group" id="login" method = 'POST' action = 'login'>
        {{ csrf_field() }}
          <input
            type="email"
            class="input-field"
            placeholder="Email"
            required
            name = 'email'
          />
          <input
            type="password"
            class="input-field"
            placeholder="Password"
            required
            name = 'password'
          />
          <input type="checkbox" class="check-box" id = 'rememberme'/><span
            >remember me</span
          >
          <button type="submit" class="submit-btn">Login</button>
        </form>
        <form class="inputs-group" id="register" method = 'POST' action = 'register'>
        {{ csrf_field() }}
          <input
            type="text"
            class="input-field"
            placeholder="Name"
            required
            name='name'
          />
          <input
            type="text"
            class="input-field"
            placeholder="Email"
            required
            name='email'
          />
          <input
            type="password"
            class="input-field"
            placeholder="Password"
            required
            name='password'
          />
          <input type="checkbox" class="check-box" /><span
            >I agree to the terms &condition</span
          >
          <button type="submit" class="submit-btn">Register</button>
          @if ($errors->any())
          <div class="errormesages">
            <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
            </ul>
          </div>
          @endif
        </form>
        
      </div>
      
    </div>

    
    
    
  </body>
  <script src= "{{asset('js/jquery-3.6.0.min.js')}}"></script>
  <script src= "{{asset('js/app.js')}}"></script>
  
</html>
