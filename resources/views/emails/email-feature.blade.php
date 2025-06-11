<DOCTYPE html>
   <html lang="en-US">
     <head>
     <meta charset="utf-8">
     </head>
<body>
     <br>
     <p>There was a request for a feature, information is given below:-</p>
     <br>
    <ul>
        <li>Name: {{$data['name']}}</li>
        <li>Email: {{$data['email']}}</li>
        <li>Url: {{$data['url']}}</li>
        <li>Message: {{$data['message']}}</li>
        <li>Importance: {{$data['importance']}}</li>
    </ul>

     @if($data['file'])
     <a href="{{$data['file']}}">Click here to download the file</a>
     @endif
     <br>
     <br>
</body>
</html>