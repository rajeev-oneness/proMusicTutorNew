<!DOCTYPE html>
<html>
<head>
	<title>Thankyou</title>
</head>
<body>
	<h1>Your Payment was successFull</h1>
	<br>
	<h3>Note : Please Save the Below Details for future Referance</h3><br>
	<span>Booking Id : <strong>{{$stripe->id}}</strong></span><br>
	<span>Transaction Id : <strong>{{$stripe->transactionId}}</strong></span><br>
	<span>Amount Charged : Rs.<strong>$ {{$stripe->amount / 100}} </strong></span>

	<br><br><br><br>
	<a href="{{url('/')}}">Click here to go home</a>
</body>
</html>