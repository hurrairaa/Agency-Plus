<html>
	<head>
        <title>{{$bs->website_title}} - Maintainance Mode</title>
		<!-- favicon -->
		<link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
		<link href='https://fonts.googleapis.com/css?family=Lato:400' rel='stylesheet' type='text/css'>
		<!-- bootstrap css -->
		<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 400;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}

			h3.maintain-txt {
				line-height: 40px;
			}
			.maintain-img-wrapper img {
				width: 100%;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="row">
					<div class="col-lg-4 offset-lg-4">
						<div class="maintain-img-wrapper">
							<img src="{{asset('assets/front/img/maintainance.png')}}" alt="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<h3 class="maintain-txt">
							{!! nl2br($bs->maintainance_text) !!}
						</h3>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
