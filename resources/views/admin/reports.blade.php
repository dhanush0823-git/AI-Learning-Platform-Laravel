<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Department Reports</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: Inter, system-ui, sans-serif; }

    /* Gradient top stripe on stat cards */
    .stat-card { position: relative; overflow: hidden; }
    .stat-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg,#4285F4,#6ea8fe); }
    .stat-card.green::before  { background: linear-gradient(90deg,#34A853,#6ee7a0); }
    .stat-card.amber::before  { background: linear-gradient(90deg,#f59e0b,#fcd34d); }
    .stat-card.purple::before { background: linear-gradient(90deg,#8b5cf6,#c4b5fd); }

    /* Table row hover */
    tbody tr { transition: background .12s; }
    tbody tr:hover { background: #fafbff; }

    /* Avatar gradient cycles */
    .av-0 { background: linear-gradient(135deg,#4285F4,#6ea8fe); }
    .av-1 { background: linear-gradient(135deg,#34A853,#6ee7a0); }
    .av-2 { background: linear-gradient(135deg,#8b5cf6,#c4b5fd); }
    .av-3 { background: linear-gradient(135deg,#f59e0b,#fcd34d); }
    .av-4 { background: linear-gradient(135deg,#ef4444,#fca5a5); }

    /* Smooth progress bar */
    .prog-fill { transition: width .6s ease; }

    /* Pagination */
    nav[aria-label="Pagination Navigation"],
    .pagination-links nav { display:flex; align-items:center; justify-content:flex-end; }
    .pagination-links span,
    .pagination-links nav span,
    nav[aria-label="Pagination Navigation"] span { display:flex; align-items:center; gap:4px; }
    nav[aria-label="Pagination Navigation"] button,
    nav[aria-label="Pagination Navigation"] a,
    nav[aria-label="Pagination Navigation"] span > span,
    .pagination-links a,
    .pagination-links button,
    .pagination-links span > span {
      display:inline-flex !important; align-items:center !important; justify-content:center !important;
      min-width:34px !important; height:34px !important; padding:0 10px !important; border-radius:10px !important;
      font-size:13px !important; font-weight:600 !important; border:1px solid #e8e9eb !important;
      background:#fff !important; color:#555 !important; text-decoration:none !important; transition:all .15s ease !important;
      cursor:pointer !important; line-height:1 !important;
    }
    nav[aria-label="Pagination Navigation"] button:hover,
    nav[aria-label="Pagination Navigation"] a:hover,
    .pagination-links a:hover,
    .pagination-links button:hover { background:#eff6ff !important; border-color:#bfdbfe !important; color:#4285f4 !important; }
    nav[aria-label="Pagination Navigation"] button[aria-current="page"],
    nav[aria-label="Pagination Navigation"] span[aria-current="page"] span,
    .pagination-links span[aria-current="page"] span {
      background:linear-gradient(135deg,#4285f4,#34a853) !important; border-color:transparent !important; color:#fff !important;
      box-shadow:0 3px 10px rgba(66,133,244,.3) !important;
    }
    nav[aria-label="Pagination Navigation"] span > span:not([aria-current]),
    .pagination-links span > span:not([aria-current]) { background:#f9fafb !important; color:#9ca3af !important; cursor:default !important; border-color:#f0f0f0 !important; }
    nav[aria-label="Pagination Navigation"] button:first-child,
    nav[aria-label="Pagination Navigation"] button:last-child,
    .pagination-links button:first-child,
    .pagination-links button:last-child,
    nav[aria-label="Pagination Navigation"] a[rel="prev"],
    nav[aria-label="Pagination Navigation"] a[rel="next"],
    .pagination-links a[rel="prev"],
    .pagination-links a[rel="next"] { background:#f5f6f8 !important; border-color:#e8e9eb !important; color:#4285f4 !important; font-weight:700 !important; }
    nav[aria-label="Pagination Navigation"] > p.text-sm { display:none !important; }
    nav[aria-label="Pagination Navigation"] p.text-sm { display:none !important; }
    nav[aria-label="Pagination Navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:first-child { display:none !important; }

    /* Print-friendly */
    @media print {
      .no-print { display: none !important; }
      body { background: #fff; }
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  {{-- ── TOP HEADER ── --}}
  <div class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between gap-4 flex-wrap">

      <div class="flex items-center gap-3">
        {{-- Dept badge --}}
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-extrabold text-sm"
             style="background:linear-gradient(135deg,#4285F4,#34A853)">
          {{ strtoupper(substr($department->code ?? 'D', 0, 2)) }}
        </div>
        <div>
          <h1 class="text-lg font-extrabold text-gray-900 leading-none">
            {{ $department->name ?? 'Department' }} Report
          </h1>
          <p class="text-xs text-gray-400 mt-0.5">
            {{ $department->code ?? 'N/A' }} · Overall learning progress overview
          </p>
        </div>
      </div>

      <div class="flex items-center gap-2 no-print">
        <button onclick="window.print()"
          class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
          </svg>
          Print
        </button>
        <a href="{{ route('department.dashboard') }}"
           class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:shadow-md"
           style="background:linear-gradient(135deg,#4285F4,#34A853)">
          ← Dashboard
        </a>
      </div>

    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-6 py-8 space-y-6">

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

      {{-- Total Students --}}
      <div class="stat-card blue bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-xl">👥</div>
          <span class="text-xs font-bold text-blue-500 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">Enrolled</span>
        </div>
        <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalStudents }}</div>
        <div class="text-xs text-gray-400 font-medium mt-1.5">Total Students</div>
      </div>

      {{-- Total Courses --}}
      <div class="stat-card green bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-xl">📚</div>
          <span class="text-xs font-bold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">Active</span>
        </div>
        <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalCourses }}</div>
        <div class="text-xs text-gray-400 font-medium mt-1.5">Total Courses</div>
      </div>

      {{-- Avg Progress --}}
      <div class="stat-card amber bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-xl">🎯</div>
          <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full">Average</span>
        </div>
        <div class="text-3xl font-extrabold text-gray-900 leading-none">{{ $avgProgress }}%</div>
        <div class="text-xs text-gray-400 font-medium mt-1.5">Avg Progress</div>
        {{-- Mini progress bar --}}
        <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full rounded-full prog-fill" style="width:{{ $avgProgress }}%; background:linear-gradient(90deg,#f59e0b,#fcd34d)"></div>
        </div>
      </div>

      {{-- Enrollments --}}
      <div class="stat-card purple bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-xl">📋</div>
          <span class="text-xs font-bold text-purple-600 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-full">Breakdown</span>
        </div>
        <div class="space-y-2 mt-1">
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500 font-medium flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>Completed
            </span>
            <span class="text-sm font-extrabold text-green-600">{{ $completedEnrollments }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-xs text-gray-500 font-medium flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>In Progress
            </span>
            <span class="text-sm font-extrabold text-amber-600">{{ $inProgressEnrollments }}</span>
          </div>
        </div>
        <div class="text-xs text-gray-400 font-medium mt-2">Enrollments</div>
      </div>

    </div>

    {{-- ── STUDENT PROGRESS TABLE ── --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
        <div>
          <h2 class="text-base font-bold text-gray-900">Student Progress Overview</h2>
          <p class="text-xs text-gray-400 mt-0.5">All students enrolled in this department</p>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
            {{ method_exists($students, 'total') ? $students->total() : count($students ?? []) }} students
          </span>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider">
              <th class="px-5 py-3 text-left">#</th>
              <th class="px-5 py-3 text-left">Student</th>
              <th class="px-5 py-3 text-left">Department</th>
              <th class="px-5 py-3 text-left">Courses</th>
              <th class="px-5 py-3 text-left">Progress</th>
              <th class="px-5 py-3 text-left">Status</th>              <th class="px-5 py-3 text-left">Action</th>            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            @forelse($students as $idx => $student)
              @php
                $p = (int) ($student->progress ?? 0);
                $barColor = $p >= 75
                  ? 'background:linear-gradient(90deg,#34A853,#6ee7a0)'
                  : ($p >= 40
                    ? 'background:linear-gradient(90deg,#f59e0b,#fcd34d)'
                    : 'background:linear-gradient(90deg,#ef4444,#fca5a5)');
                $avClass = 'av-' . ($idx % 5);
              @endphp
              <tr>
                <td class="px-5 py-3.5 text-xs font-bold text-gray-300">{{ (method_exists($students, 'firstItem') ? $students->firstItem() : 1) + $idx }}</td>
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full {{ $avClass }} flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                      {{ strtoupper(substr($student->name ?? 'S', 0, 2)) }}
                    </div>
                    <div>
                      <p class="font-semibold text-gray-900 leading-none">{{ $student->name }}</p>
                      <p class="text-xs text-gray-400 mt-0.5">{{ $student->email }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-3.5">
                  <span class="inline-flex items-center text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg tracking-wide">
                    {{ $student->department->code ?? 'N/A' }}
                  </span>
                </td>
                <td class="px-5 py-3.5 text-gray-600 text-sm font-medium">
                  {{ $student->enrollments_count ?? 0 }}
                </td>
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-2">
                    <div class="w-28 h-1.5 bg-gray-100 rounded-full overflow-hidden flex-shrink-0">
                      <div class="h-full rounded-full prog-fill" style="{{ $barColor }}; width:{{ $p }}%"></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600 w-8 text-right">{{ $p }}%</span>
                  </div>
                </td>
                <td class="px-5 py-3.5">
                  @if(($student->status ?? 'inactive') === 'active')
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Inactive
                    </span>
                  @endif
                </td>
                <td class="px-5 py-3.5">
                    <a href="{{ route('department.reports.student', ['student' => $student->id]) }}" class="text-xs font-bold text-blue-600 hover:underline">View</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-5 py-12 text-center">
                  <div class="text-3xl mb-2">📭</div>
                  <p class="text-sm text-gray-400 font-medium">No student data found.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination if needed --}}
      @if(isset($students) && method_exists($students, 'links'))
        <div class="px-5 py-4 border-t border-gray-100">
          {{ $students->links('pagination::tailwind') }}
        </div>
      @endif

    </div>

    {{-- ── COURSE PROGRESS TABLE ── --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
        <div>
          <h2 class="text-base font-bold text-gray-900">Course-wise Progress</h2>
          <p class="text-xs text-gray-400 mt-0.5">Enrollment and completion breakdown per course</p>
        </div>
        <span class="text-xs font-bold text-green-600 bg-green-50 border border-green-100 px-3 py-1 rounded-full">
          {{ method_exists($courseProgressRows, 'total') ? $courseProgressRows->total() : count($courseProgressRows ?? []) }} courses
        </span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider">
              <th class="px-5 py-3 text-left">#</th>
              <th class="px-5 py-3 text-left">Course</th>
              <th class="px-5 py-3 text-left">Enrolled</th>
              <th class="px-5 py-3 text-left">Completed</th>
              <th class="px-5 py-3 text-left">Completion Rate</th>
              <th class="px-5 py-3 text-left">Avg Progress</th>
              <th class="px-5 py-3 text-left">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50">
            @forelse($courseProgressRows as $i => $row)
              @php
                $ap = (int) ($row->avg_progress ?? 0);
                $enrolled  = (int) ($row->enrolled ?? 0);
                $completed = (int) ($row->completed ?? 0);
                $rate = $enrolled > 0 ? round(($completed / $enrolled) * 100) : 0;
                $rateColor = $rate >= 75
                  ? 'background:linear-gradient(90deg,#34A853,#6ee7a0)'
                  : ($rate >= 40
                    ? 'background:linear-gradient(90deg,#f59e0b,#fcd34d)'
                    : 'background:linear-gradient(90deg,#ef4444,#fca5a5)');
                $apColor = $ap >= 75
                  ? 'background:linear-gradient(90deg,#34A853,#6ee7a0)'
                  : ($ap >= 40
                    ? 'background:linear-gradient(90deg,#f59e0b,#fcd34d)'
                    : 'background:linear-gradient(90deg,#ef4444,#fca5a5)');
              @endphp
              <tr>
                <td class="px-5 py-3.5 text-xs font-bold text-gray-300">{{ (method_exists($courseProgressRows, 'firstItem') ? $courseProgressRows->firstItem() : 1) + $i }}</td>
                <td class="px-5 py-3.5">
                  <p class="font-semibold text-gray-900">{{ $row->title }}</p>
                  @if(isset($row->level))
                    <p class="text-xs text-gray-400 mt-0.5">{{ ucfirst($row->level) }}</p>
                  @endif
                </td>
                <td class="px-5 py-3.5">
                  <span class="text-sm font-bold text-gray-700">{{ $enrolled }}</span>
                  <span class="text-xs text-gray-400 ml-0.5">students</span>
                </td>
                <td class="px-5 py-3.5">
                  <span class="text-sm font-bold text-green-600">{{ $completed }}</span>
                  <span class="text-xs text-gray-400 ml-0.5">done</span>
                </td>
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-2">
                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden flex-shrink-0">
                      <div class="h-full rounded-full prog-fill" style="{{ $rateColor }}; width:{{ $rate }}%"></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600">{{ $rate }}%</span>
                  </div>
                </td>
                <td class="px-5 py-3.5">
                  <a href="{{ route('department.reports.course.marks', ['course' => $row->course_id ?? 0]) }}" class="text-xs font-bold text-blue-600 hover:underline">View</a>
                </td>
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-2">
                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden flex-shrink-0">
                      <div class="h-full rounded-full prog-fill" style="{{ $apColor }}; width:{{ $ap }}%"></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600">{{ $ap }}%</span>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-5 py-12 text-center">
                  <div class="text-3xl mb-2">📊</div>
                  <p class="text-sm text-gray-400 font-medium">No course progress data found.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(isset($courseProgressRows) && method_exists($courseProgressRows, 'links'))
        <div class="px-5 py-4 border-t border-gray-100">
          {{ $courseProgressRows->links('pagination::tailwind') }}
        </div>
      @endif
    </div>

    {{-- Bottom spacer --}}
    <div class="h-4"></div>
  </div>

</body>
</html>

