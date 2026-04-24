<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }
        h2 {
            text-align: center;
            color: #1a1e2a;
            margin-bottom: 20px;
        }
        .summary, .departments {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .summary th, .summary td, .departments th, .departments td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .summary th, .departments th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .text-right {
            text-align: right !important;
        }
        .header-date {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="header-date">Printed Date: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</div>
    
    <h2>MadUniv Dashboard Report</h2>

    <h3>Summary</h3>
    <table class="summary">
        <thead>
            <tr>
                <th>Indicator</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Students</td>
                <td class="text-right">{{ $studentsCount }}</td>
            </tr>
            <tr>
                <td>Total Departments</td>
                <td class="text-right">{{ $departmentsCount }}</td>
            </tr>
            <tr>
                <td>Total Courses</td>
                <td class="text-right">{{ $coursesCount }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Departments Breakdown</h3>
    <table class="departments">
        <thead>
            <tr>
                <th>No.</th>
                <th>Department Name</th>
                <th>Accreditation</th>
                <th class="text-right">Students</th>
                <th class="text-right">Courses</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $index => $dept)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $dept->name }}</td>
                <td>{{ $dept->accreditation ?? '-' }}</td>
                <td class="text-right">{{ $dept->students_count }}</td>
                <td class="text-right">{{ $dept->courses_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
