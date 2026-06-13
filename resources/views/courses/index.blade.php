@extends('layouts.app')
@section('title', 'Courses')

@section('content')
<div class="section-head">
    <div>
        <div class="section-title">Courses</div>
        <div style="font-size:13px;color:var(--muted);margin-top:3px">Manage course spaces</div>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-lg"></i> Add Course
    </button>
</div>

<div class="table-wrap">
    <div class="table-toolbar">
        <form method="GET" action="{{ route('courses.index') }}" class="search-field" style="display: flex; gap: 10px; width: 100%;">
            <div style="position: relative; flex: 1;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search courses…"/>
            </div>
            
            <select name="department_id" class="filter-sel">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            @if($search || $departmentId)
            <a href="{{ route('courses.index') }}" class="btn-ghost">Clear</a>
            @endif
            <button type="submit" class="btn-primary-custom">Search</button>

            <div class="d-flex justify-content-end align-items-center" style="gap:6px">
                <a href="{{route('course.print')}}" class="btn btn-primary" target="_blank" title="Print"><i class="bi bi-printer"></i></a>
                <a href="{{route('course.export-csv')}}" class="btn btn-success" target="_blank" title="Export CSV"><i class="bi bi-filetype-csv"></i></a>
                <a href="{{route('course.export-excel')}}" class="btn btn-success" target="_blank" title="Export Excel"><i class="bi bi-file-earmark-excel"></i></a>
            </div>
        </form>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Department</th>
                    <th>SKS</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td style="color:var(--muted)">{{ $loop->iteration + ($courses->currentPage()-1) * $courses->perPage() }}</td>
                    <td><div style="font-weight:600;color:#fff">{{ $course->name }}</div></td>
                    <td>{{ $course->department ? $course->department->name : 'N/A' }}</td>
                    <td>{{ $course->sks }}</td>
                    <td>
                        <div class="action-btns">
                            <div class="btn-act edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $course->id }}" title="Edit"><i class="bi bi-pencil"></i></div>
                            <div class="btn-act del" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $course->id }}" title="Delete"><i class="bi bi-trash3"></i></div>
                        </div>
                    </td>
                </tr>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center" style="padding: 30px 20px;">
                            <div style="font-size: 50px; color: var(--red); margin-bottom: 20px; line-height: 1;">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h4 style="font-family:'Syne', sans-serif; color:#fff; font-weight:700; margin-bottom: 10px;">Delete Course</h4>
                            <p style="color:var(--muted); font-size:14px; margin-bottom:24px;">Are you sure you want to delete <strong>{{ $course->name }}</strong>? This action cannot be undone.</p>
                            
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:flex; gap:10px; justify-content:center;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-cancel" data-bs-dismiss="modal" style="flex:1">Cancel</button>
                                <button type="submit" class="btn-danger" style="flex:1"><i class="bi bi-trash3"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">Course Name</label>
                                        <input name="name" class="form-control-custom" value="{{ $course->name }}" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">Department</label>
                                            <select name="department_id" class="form-control-custom" required>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}" {{ $course->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SKS</label>
                                            <input type="number" name="sks" class="form-control-custom" value="{{ $course->sks }}" required min="1" max="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Update Course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🏫</div>
                            <div class="empty-text">No courses found.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <div class="table-info">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} results</div>
        <div class="pagination-btns">
            {{ $courses->appends(['search' => $search, 'department_id' => $departmentId])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Course Name</label>
                        <input name="name" class="form-control-custom" placeholder="e.g. Algorithm" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select name="department_id" class="form-control-custom" required>
                                <option value="">Select department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">SKS</label>
                            <input type="number" name="sks" class="form-control-custom" placeholder="3" required min="1" max="6">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
