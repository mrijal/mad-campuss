<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Department Data</title>
</head>
<body>
    <h2>Department Data</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Accreditation</th>
            <th>Students Count</th>
        </tr>
        @foreach($departments as $dept)
        <tr>
            <td>{{ $dept->id }}</td>
            <td>{{ $dept->name }}</td>
            <td>{{ $dept->accreditation }}</td>
            <td>{{ $dept->students_count }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
