@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-change up">+</div>
        </div>
        <div class="stat-value">{{ $studentsCount }}</div>
        <div class="stat-label">Total Students</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-top">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <div class="stat-change up">Active</div>
        </div>
        <div class="stat-value">{{ $departmentsCount }}</div>
        <div class="stat-label">Departments</div>
    </div>
    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div class="stat-change up">Active</div>
        </div>
        <div class="stat-value">{{ $coursesCount }}</div>
        <div class="stat-label">Courses</div>
    </div>
</div>
@endsection
