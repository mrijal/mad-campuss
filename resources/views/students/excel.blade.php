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