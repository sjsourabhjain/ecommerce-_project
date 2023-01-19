<!DOCTYPE html>	
<html>
<head>
	<title></title>
		<!-- Bootstrap CSS -->
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">	
</head>
<body>
	<div class="container">
		<!-- Top Navigation Menu -->
		<div class="row">
			<div class="topnav">
		  		<a href="#home" class="primary">Logo</a>
			  <div id="myLinks">
			    <a href="#contact">Order Record</a>
			    <a href="#contact">Cash Balance</a>
			    <a href="{{route('about-us')}}">About Us</a>
			    <a href="">Logout</a>
			  </div>
		  		<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		    		<i class="fa fa-bars"></i>
		  		</a>
			</div>
		</div>
		</div>