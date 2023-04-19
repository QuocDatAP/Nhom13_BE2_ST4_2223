@extends('dashboard')
@section('content')
<div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">email</th>
      <th scope="col">phone</th>
    </tr>
  </thead>
  <tbody>
  @foreach($data as $a)
    <tr>  
      <th scope="row">{{++$i}}</th>
      <td><img src="/uploads/{{$a -> image}}" style="width: 100px"></td></td>
      <td>{{$a->name}}</td>
      <td>{{$a->email}}</td>
      <td>{{$a->phone}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

  <div class="">{{$data->links()}}</div>

@endsection
