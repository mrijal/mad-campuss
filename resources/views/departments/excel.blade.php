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
