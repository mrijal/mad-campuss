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
