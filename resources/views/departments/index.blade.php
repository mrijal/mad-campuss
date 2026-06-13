@extends('layouts.app')
@section('title', 'Departments')

@section('content')
<div class="section-head">
    <div>
        <div class="section-title">Departments</div>
        <div style="font-size:13px;color:var(--muted);margin-top:3px">Manage academic departments</div>
    </div>
    <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-lg"></i> Add Department
    </button>
</div>

<div class="table-wrap">
    <div class="table-toolbar">
        <form method="GET" action="{{ route('departments.index') }}" class="search-field" style="display: flex; gap: 10px; width: 100%;">
            <div style="position: relative; flex: 1;">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search departments…"/>
            </div>
            @if($search)
            <a href="{{ route('departments.index') }}" class="btn-ghost">Clear</a>
            @endif
            <button type="submit" class="btn-primary-custom">Search</button>

            <div class="d-flex justify-content-end align-items-center" style="gap:6px">
                <a href="{{route('department.print')}}" class="btn btn-primary" target="_blank" title="Print"><i class="bi bi-printer"></i></a>
                <a href="{{route('department.export-csv')}}" class="btn btn-success" target="_blank" title="Export CSV"><i class="bi bi-filetype-csv"></i></a>
                <a href="{{route('department.export-excel')}}" class="btn btn-success" target="_blank" title="Export Excel"><i class="bi bi-file-earmark-excel"></i></a>
            </div>
        </form>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Accreditation</th>
                    <th>Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td style="color:var(--muted)">{{ $loop->iteration + ($departments->currentPage()-1) * $departments->perPage() }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <span style="font-weight:600;color:#fff">{{ $dept->name }}</span>
                        </div>
                    </td>
                    <td><span class="badge-status {{ $dept->accreditation == 'A' ? 'badge-active' : ($dept->accreditation == 'B' ? 'badge-pending' : 'badge-inactive') }}">{{ $dept->accreditation }}</span></td>
                    <td><span style="font-weight:600;color:var(--accent)">{{ $dept->students()->count() }}</span> students</td>
                    <td>
                        <div class="action-btns">
                            <div class="btn-act edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $dept->id }}" title="Edit"><i class="bi bi-pencil"></i></div>
                            <div class="btn-act del" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $dept->id }}" title="Delete"><i class="bi bi-trash3"></i></div>
                        </div>
                    </td>
                </tr>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $dept->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center" style="padding: 30px 20px;">
                            <div style="font-size: 50px; color: var(--red); margin-bottom: 20px; line-height: 1;">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h4 style="font-family:'Syne', sans-serif; color:#fff; font-weight:700; margin-bottom: 10px;">Delete Department</h4>
                            <p style="color:var(--muted); font-size:14px; margin-bottom:24px;">Are you sure you want to delete <strong>{{ $dept->name }}</strong>? This action cannot be undone.</p>
                            
                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" style="display:flex; gap:10px; justify-content:center;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-cancel" data-bs-dismiss="modal" style="flex:1">Cancel</button>
                                <button type="submit" class="btn-danger" style="flex:1"><i class="bi bi-trash3"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $dept->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('departments.update', $dept->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Department</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">Department Name</label>
                                        <input name="name" class="form-control-custom" value="{{ $dept->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Accreditation</label>
                                        <input name="accreditation" class="form-control-custom" value="{{ $dept->accreditation }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Update Department</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🏛️</div>
                            <div class="empty-text">No departments found.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <div class="table-info">Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} results</div>
        <div class="pagination-btns">
            {{ $departments->appends(['search' => $search])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input name="name" class="form-control-custom" placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Accreditation</label>
                        <input name="accreditation" class="form-control-custom" placeholder="e.g. A" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom"><i class="bi bi-check-lg"></i> Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
