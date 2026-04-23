@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="section-head">
    <div>
        <div class="section-title">Students</div>
        <div style="font-size:13px;color:var(--muted);margin-top:3px">Manage enrolled students</div>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-lg"></i> Add Student
    </button>
</div>

<div class="table-wrap">
    <div class="table-toolbar">
        <form method="GET" action="{{ route('students.index') }}" class="search-field" style="display: flex; gap: 10px; width: 100%;">
            <div style="position: relative; flex: 1;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search students…"/>
            </div>
            
            <select name="department_id" class="filter-sel">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            @if($search || $departmentId)
            <a href="{{ route('students.index') }}" class="btn-ghost">Clear</a>
            @endif
            <button type="submit" class="btn-primary-custom">Search</button>
        </form>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td style="color:var(--muted)">{{ $loop->iteration + ($students->currentPage()-1) * $students->perPage() }}</td>
                    <td><code style="background:var(--surface2);padding:2px 8px;border-radius:5px;font-size:12px">{{ $student->nim }}</code></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="avatar-sm" style="background:var(--accent)">
                                {{ strtoupper(substr($student->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;color:#fff">{{ $student->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $student->department ? $student->department->name : 'N/A' }}</td>
                    <td>
                        <div class="action-btns">
                            <div class="btn-act edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $student->id }}" title="Edit"><i class="bi bi-pencil"></i></div>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-act del" title="Delete" style="border:none;background:var(--surface2)"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('students.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">Full Name</label>
                                            <input name="name" class="form-control-custom" value="{{ $student->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">NIM</label>
                                            <input name="nim" class="form-control-custom" value="{{ $student->nim }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Department</label>
                                        <select name="department_id" class="form-control-custom" required>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ $student->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Update Student</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🎓</div>
                            <div class="empty-text">No students found.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <div class="table-info">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results</div>
        <div class="pagination-btns">
            {{ $students->appends(['search' => $search, 'department_id' => $departmentId])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input name="name" class="form-control-custom" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIM</label>
                            <input name="nim" class="form-control-custom" placeholder="e.g. 2024001" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-control-custom" required>
                            <option value="">Select department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Save Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
