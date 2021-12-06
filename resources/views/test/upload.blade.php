<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>上传测试</title>
</head>
<body>
	<form action="{{ url('/test/uploads') }}" method="post" enctype="multipart/form-data">
		@csrf
		<input type="file" name="file[]" multiple />

		<button type="submit">上传</button>
	</form>
</body>
</html>