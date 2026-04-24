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

    <div class="chart-grid"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <!-- Students Chart -->
        <div class="stat-card" style="padding: 20px;">
            <div class="section-head" style="margin-bottom: 20px;">
                <div class="section-title" style="font-size: 15px;">Students per Department</div>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="studentsChart"></canvas>
            </div>
        </div>

        <!-- Courses Chart -->
        <div class="stat-card" style="padding: 20px;">
            <div class="section-head" style="margin-bottom: 20px;">
                <div class="section-title" style="font-size: 15px;">Courses per Department</div>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="coursesChart"></canvas>
            </div>
        </div>

        <!-- Accreditations Chart -->
        <div class="stat-card" style="padding: 20px;">
            <div class="section-head" style="margin-bottom: 20px;">
                <div class="section-title" style="font-size: 15px;">Department Accreditation</div>
            </div>
            <div style="position: relative; height: 250px; display: flex; justify-content: center;">
                <canvas id="accreditationsChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Theme Colors
        const accent = '#5b7fff';
        const accent2 = '#a78bfa';
        const green = '#34d399';
        const orange = '#fb923c';
        const red = '#f87171';
        const yellow = '#fbbf24';
        const surface2 = '#1a1e2a';
        const border = 'rgba(255,255,255,0.07)';
        const text = '#e2e8f0';
        const muted = '#64748b';

        // Set global ChartJS defaults for the dark theme
        Chart.defaults.color = muted;
        Chart.defaults.font.family = "'DM Sans', sans-serif";
        Chart.defaults.scale.grid.color = border;
        Chart.defaults.plugins.tooltip.backgroundColor = surface2;
        Chart.defaults.plugins.tooltip.titleColor = text;
        Chart.defaults.plugins.tooltip.bodyColor = text;
        Chart.defaults.plugins.tooltip.borderColor = border;
        Chart.defaults.plugins.tooltip.borderWidth = 1;
        Chart.defaults.plugins.tooltip.padding = 10;
        Chart.defaults.plugins.tooltip.cornerRadius = 8;

        const departmentsData = @json($departments);
        const deptNames = departmentsData.map(d => d.name || 'Unknown');
        const deptStudents = departmentsData.map(d => d.students_count);
        const deptCourses = departmentsData.map(d => d.courses_count);

        const accreditationsData = @json($accreditations);
        const accNames = accreditationsData.map(a => a.accreditation || 'None');
        const accTotals = accreditationsData.map(a => a.total);

        // 1. Students Bar Chart
        new Chart(document.getElementById('studentsChart'), {
            type: 'bar',
            data: {
                labels: deptNames,
                datasets: [{
                    label: 'Total Students',
                    data: deptStudents,
                    backgroundColor: 'rgba(91,127,255,0.8)',
                    borderColor: accent,
                    borderWidth: 1,
                    borderRadius: 6,
                    hoverBackgroundColor: accent
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        // 2. Courses Bar Chart
        new Chart(document.getElementById('coursesChart'), {
            type: 'bar',
            data: {
                labels: deptNames,
                datasets: [{
                    label: 'Total Courses',
                    data: deptCourses,
                    backgroundColor: 'rgba(52,211,153,0.8)',
                    borderColor: green,
                    borderWidth: 1,
                    borderRadius: 6,
                    hoverBackgroundColor: green
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // horizontal bar chart
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        // 3. Accreditations Doughnut Chart
        new Chart(document.getElementById('accreditationsChart'), {
            type: 'doughnut',
            data: {
                labels: accNames,
                datasets: [{
                    data: accTotals,
                    backgroundColor: [accent, accent2, green, orange, red, yellow],
                    borderWidth: 2,
                    borderColor: '#13161e',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' }
                    }
                }
            }
        });
    });
</script>