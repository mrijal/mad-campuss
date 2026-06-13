<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Course Data</title>
</head>
<body>
    <h2>Course Data</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>SKS</th>
        </tr>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->id }}</td>
            <td>{{ $course->name }}</td>
            <td>{{ $course->department->name ?? 'N/A' }}</td>
            <td>{{ $course->sks }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
