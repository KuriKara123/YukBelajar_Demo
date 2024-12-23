@extends('layouts.app')

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Addresses</h2>
      <div class="row">
        <div class="col-lg-3">
            @include('user.accountnav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__address">
            <div class="row">
            <div class="my-account__address-list row">
              <h5>My Address</h5>
              @foreach ($addresses as $address)
                  
              @endforeach

              <div class="my-account__address-item col-md-6">
                <div class="my-account__address-item__title">
                  <h5>{{$address->name}}<i class="fa fa-check-circle text-success"></i></h5>
                  <a href="#">Edit</a>
                </div>
                <div class="my-account__address-item__detail">
                  <p>{{$address->landmark}}</p>
                  <p>{{$address->city}}</p>
                  <p>{{$address->state}}</p>
                  <p>{{$address->address}}, {{$address->locality}}</p>
                  <p>{{$address->zip}}</p>
                  <br>
                  <p>Mobile : {{$address->phone}}</p>
                </div>
              </div>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection