<header>
      <div class="container">
        <div class="content">
          <div class="logo"> <img class = 'logo-icon' src = "{{asset('icon/PROJE LOGO.png')}}" width = '75' height = '75'> </img></div>
          <!--<a href="#" class="cta"><button>contact</button></a>-->
          <ul class="nav_links">
            <li><a href="/dicle.ai/public/home">Home</a></li>
            <li><a href="/dicle.ai/public/classification/upload">Upload</a></li>
            <li><a href="/dicle.ai/public/classification/train">Train</a></li>
	    @if(Auth::check())
            <li><a href="/dicle.ai/public/logout">Logout</a></li>
            @else  
	    <li><a href="/dicle.ai/public/login">Login/Register</a></li>
	    @endif
	</ul>
        </div>
      </div>
    </header>

<link rel="stylesheet" href="{{asset('css/footer-header.css')}}" />