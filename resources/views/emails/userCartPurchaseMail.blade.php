<body>
	<h3>Hello {{ $name }}</h3>

	<h3>{{$content}}</h3>

	<table border="1" style="width: 100% !important">
		<tr>
			<th>Product Name</th>
			<th>Price</th>
		</tr>
		@foreach($data as $key => $puchase)
			<tr>
				<td>{{$puchase['name']}}</td>
				<td>{{$puchase['price']}}</td>
			</tr>
		@endforeach
	</table>
	<h3>Greetings from the team "Pro Music Tutor".</h3>
	
	<h3>We hope you are going to have a great time with us.</h3>
	
	<h4>Best Wishes,</h4><br>
	
	<h4>Pro Music Tutor</h4>
</body>