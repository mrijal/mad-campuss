<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Student Data</title>
</head>
<body>
    <h2>Student Data</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>NIM</th>
            <th>Name</th>
            <th>Department</th>
        </tr>
        
        @foreach($students as $student)
        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->nim}}</td>
            <td>{{$student->name}}</td>
            <td>{{$student->department->name}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>