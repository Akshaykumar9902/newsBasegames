<x-header data="Users Component Header"/>
<h1>Users file {{count($user)}}</h1>
@if($name=="akshay")
<h1>Hi akshay</h1>
@elseif($name=='sam')
<h1>hi sam</h1>
@elseif($name=='peter')
<h1>hi peter</h1>
@else
<h2>hi unknown</h2>
@endif

@for($i=0;$i<10;$i++)
    <h4>{{$i}}</h4>
@endfor
@foreach ($user as $item)
    <h1> {{$item}} </h1>
@endforeach

@include('hello')
{{$errors}}
@if($errors->any())
 @foreach ($errors->all() as $item)
 <li>{{$item}}</li> 
 @endforeach
  
@endif
<form action="/form" method="post">
    @csrf
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email" value="{{old('email')}}">
        <span style="color: red">@error('email')
            {{$message}}
            
        @enderror</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
        <span style="color: red">@error('password')
            {{$message}}
            
        @enderror</span>
    </div>
    </div>

   
    <div class="form-group row">
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Sign in</button>
      </div>
    </div>
  </form>






    <script>
          data=@json($user);
          
          console.log(data);
    </script>