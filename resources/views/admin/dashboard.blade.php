<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
      }
    }
  }
</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/x-icon">
<style>
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
</style>

<div class="min-h-screen bg-gray-50" style="font-family: Inter, system-ui, sans-serif;">

  <!-- TOP HEADER -->
  <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between gap-4 flex-wrap">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg,#4285F4,#34A853)">A</div>
        <div>
          <h1 class="text-base font-extrabold text-gray-900 leading-none">Department Admin</h1>
          <p class="text-xs text-gray-400 mt-0.5">AI Learning Platform</p>
        </div>
      </div>
      <div class="flex-1 max-w-md hidden sm:block">
        <div class="relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          <input id="globalSearch" type="text" placeholder="Search students..."
            class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button class="relative w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
        <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
          <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg,#4285F4,#34A853)">AD</div>
          <div class="hidden md:block">
            <p class="text-sm font-semibold text-gray-800 leading-none">{{ $admin->name ?? 'Admin' }}</p>
            <p class="text-xs text-gray-400">{{ $department->code ?? 'No Department' }} Department</p>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="px-3 py-2 rounded-xl text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="max-w-screen-xl mx-auto px-6 py-8">

    <!-- PAGE TITLE -->
    <div class="mb-8">
      <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 py-1 mb-3">
        <span class="text-xs font-bold tracking-widest text-blue-500 uppercase">Dashboard</span>
      </div>
      <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">Department Overview</h2>
      <p class="text-gray-500 text-sm mt-1">Monitor students, courses, and performance across your department.</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between">
          <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">👥</div>
          <span class="text-xs font-semibold text-blue-500 bg-white border border-blue-200 px-2 py-0.5 rounded-full">+12%</span>
        </div>
        <div>
          <div class="text-2xl font-extrabold text-blue-700">{{ $totalStudents }}</div>
          <div class="text-xs text-gray-500 font-medium mt-0.5">Total Students</div>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between">
          <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">📚</div>
          <span class="text-xs font-semibold text-green-500 bg-white border border-green-200 px-2 py-0.5 rounded-full">+3</span>
        </div>
        <div>
          <div class="text-2xl font-extrabold text-green-700">{{ $totalCourses }}</div>
          <div class="text-xs text-gray-500 font-medium mt-0.5">Active Courses</div>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between">
          <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center text-xl">🎯</div>
          <span class="text-xs font-semibold text-amber-500 bg-white border border-amber-200 px-2 py-0.5 rounded-full">+5%</span>
        </div>
        <div>
          <div class="text-2xl font-extrabold text-amber-700">{{ $avgProgress }}%</div>
          <div class="text-xs text-gray-500 font-medium mt-0.5">Avg. Completion</div>
        </div>
      </div>
      <div class="bg-white border border-gray-200 rounded-2xl p-5 flex flex-col gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-start justify-between">
          <div class="w-11 h-11 rounded-xl bg-rose-100 flex items-center justify-center text-xl">✅</div>
          <span class="text-xs font-semibold text-rose-500 bg-white border border-rose-200 px-2 py-0.5 rounded-full">+28</span>
        </div>
        <div>
          <div class="text-2xl font-extrabold text-rose-700">{{ $totalAssessments }}</div>
          <div class="text-xs text-gray-500 font-medium mt-0.5">Assessments Done</div>
        </div>
      </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">

      <!-- STUDENT TABLE -->
      <div class="xl:col-span-2 self-start bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 class="text-base font-bold text-gray-900">Student Details</h3>
            <p class="text-xs text-gray-400 mt-0.5">All enrolled students in your department</p>
          </div>
          <div class="flex items-center gap-2 flex-wrap">
            <!-- <select id="deptFilter" class="text-sm border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-pointer">
              <option value="ALL">All Depts</option>
              <option value="CSE">CSE</option>
              <option value="ECE">ECE</option>
              <option value="MECH">MECH</option>
              <option value="AIML">AIML</option>
              <option value="CIVIL">CIVIL</option>
            </select>
            <select id="statusFilter" class="text-sm border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-pointer">
              <option value="ALL">All Status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select> -->
            <button class="flex items-center gap-1.5 text-sm font-semibold text-white px-4 py-2 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all" style="background: linear-gradient(135deg,#4285F4,#34A853)">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
              Export
            </button>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="px-5 py-3 text-left">Student</th>
                <th class="px-5 py-3 text-left">Dept</th>
                <th class="px-5 py-3 text-left">Enrolled</th>
                <th class="px-5 py-3 text-left">Progress</th>
                <th class="px-5 py-3 text-left">Status</th>
                <th class="px-5 py-3 text-left">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="studentTableBody">

              @php
                $demoStudents = [
                  ['Arjun Sharma',   'arjun.sharma@college.edu',   'CSE',   92, 'active',   5, 'from-blue-400 to-blue-600'],
                  ['Priya Nair',     'priya.nair@college.edu',     'ECE',   68, 'active',   3, 'from-emerald-400 to-emerald-600'],
                  ['Kiran Patel',    'kiran.patel@college.edu',    'MECH',  45, 'active',   6, 'from-violet-400 to-violet-600'],
                  ['Sneha Reddy',    'sneha.reddy@college.edu',    'CSE',   81, 'active',   4, 'from-rose-400 to-rose-600'],
                  ['Rahul Verma',    'rahul.verma@college.edu',    'CIVIL', 22, 'inactive', 2, 'from-amber-400 to-amber-600'],
                  ['Ananya Iyer',    'ananya.iyer@college.edu',    'AIML',  95, 'active',   7, 'from-teal-400 to-teal-600'],
                  ['Dev Krishnan',   'dev.krishnan@college.edu',   'CSE',   57, 'active',   5, 'from-indigo-400 to-indigo-600'],
                  ['Meera Pillai',   'meera.pillai@college.edu',   'ECE',   73, 'inactive', 4, 'from-pink-400 to-pink-600'],
                  ['Rohit Gupta',    'rohit.gupta@college.edu',    'MECH',  38, 'active',   3, 'from-orange-400 to-orange-600'],
                  ['Kavya Menon',    'kavya.menon@college.edu',    'AIML',  88, 'active',   6, 'from-cyan-400 to-cyan-600'],
                  ['Suresh Babu',    'suresh.babu@college.edu',    'CIVIL', 61, 'active',   4, 'from-lime-400 to-lime-600'],
                  ['Lakshmi Das',    'lakshmi.das@college.edu',    'CSE',   49, 'inactive', 3, 'from-fuchsia-400 to-fuchsia-600'],
                ];
                $allStudents = $students ?? collect($demoStudents);
                $useDemoData = false;
              @endphp

              @if($useDemoData)
                @foreach($demoStudents as $i => $s)
                  @php
                    $pg = $s[3];
                    $pgColor = $pg >= 75 ? 'bg-green-500' : ($pg >= 40 ? 'bg-amber-400' : 'bg-rose-400');
                  @endphp
                  <tr class="hover:bg-blue-50/30 transition-colors student-row"
                    data-dept="{{ $s[2] }}" data-status="{{ $s[4] }}" data-name="{{ strtolower($s[0]) }}">
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $s[6] }} flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                          {{ strtoupper(substr($s[0],0,2)) }}
                        </div>
                        <div>
                          <p class="font-semibold text-gray-800 leading-none">{{ $s[0] }}</p>
                          <p class="text-xs text-gray-400 mt-0.5">{{ $s[1] }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold px-2.5 py-1 rounded-lg tracking-wide">{{ $s[2] }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600 text-sm">{{ $s[5] }} courses</td>
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden" style="min-width:60px">
                          <div class="h-full rounded-full {{ $pgColor }}" style="width:{{ $pg }}%"></div>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 w-8 text-right">{{ $pg }}%</span>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      @if($s[4]==='active')
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                          <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 border border-gray-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                          <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Inactive
                        </span>
                      @endif
                    </td>
                    <td class="px-5 py-3.5">
                      <button onclick='openStudentModal({name: @json($s[0]), email: @json($s[1]), dept: @json($s[2]), progress: {{ $s[3] }}, status: @json($s[4]), courses: {{ $s[5] }}, completed: {{ max(0, (int) round($s[5] * $s[3] / 100)) }}, certificates: {{ max(0, (int) round($s[5] * $s[3] / 100)) }}, recent_courses: []})'
                        class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                        View
                      </button>
                    </td>
                  </tr>
                @endforeach
              @else
                @forelse($students as $student)
                  @php
                    $pg = $student->progress ?? 50;
                    $pgColor = $pg >= 75 ? 'bg-green-500' : ($pg >= 40 ? 'bg-amber-400' : 'bg-rose-400');
                    $status = $student->status ?? 'active';
                    $avatarColors = ['from-blue-400 to-blue-600','from-emerald-400 to-emerald-600','from-violet-400 to-violet-600','from-rose-400 to-rose-600','from-amber-400 to-amber-600'];
                    $ac = $avatarColors[$loop->index % count($avatarColors)];
                  @endphp
                  <tr class="hover:bg-blue-50/30 transition-colors student-row"
                    data-dept="{{ $student->department->code ?? 'N/A' }}" data-status="{{ $status }}" data-name="{{ strtolower($student->name ?? '') }}">
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $ac }} flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                          {{ strtoupper(substr($student->name ?? 'S',0,2)) }}
                        </div>
                        <div>
                          <p class="font-semibold text-gray-800 leading-none">{{ $student->name }}</p>
                          <p class="text-xs text-gray-400 mt-0.5">{{ $student->email }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold px-2.5 py-1 rounded-lg tracking-wide">{{ $student->department->code ?? 'N/A' }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-600 text-sm">{{ $student->enrollments_count ?? 0 }} courses</td>
                    <td class="px-5 py-3.5">
                      <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden" style="min-width:60px">
                          <div class="h-full rounded-full {{ $pgColor }}" style="width:{{ $pg }}%"></div>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 w-8 text-right">{{ $pg }}%</span>
                      </div>
                    </td>
                    <td class="px-5 py-3.5">
                      @if($status==='active')
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                          <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active
                        </span>
                      @else
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 border border-gray-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                          <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Inactive
                        </span>
                      @endif
                    </td>
                    <td class="px-5 py-3.5">
                      <button onclick='openStudentModal(@json($student->modal_data ?? []))'
                        class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                        View
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="px-5 py-6 text-sm text-gray-500 text-center">
                      No students found for {{ $department->code ?? 'this' }} department.
                    </td>
                  </tr>
                @endforelse
              @endif

            </tbody>
          </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between flex-wrap gap-3">
          <span class="text-xs text-gray-400" id="tableCount">
            @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator && $students->total() > 0)
              Showing {{ $students->firstItem() }}&ndash;{{ $students->lastItem() }} of {{ $students->total() }} students
            @else
              Showing all students
            @endif
          </span>
          @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator && $students->lastPage() > 1)
            <div class="flex items-center gap-1">
              @if($students->onFirstPage())
                <span class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center cursor-not-allowed">‹</span>
              @else
                <a href="{{ $students->previousPageUrl() }}" class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">‹</a>
              @endif

              @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                @if($page == $students->currentPage())
                  <span class="w-10 h-10 rounded-xl text-white text-sm font-bold flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg,#4285F4,#34A853)">{{ $page }}</span>
                @else
                  <a href="{{ $url }}" class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100 text-sm font-semibold flex items-center justify-center transition-colors">{{ $page }}</a>
                @endif
              @endforeach

              @if($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}" class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">›</a>
              @else
                <span class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center cursor-not-allowed">›</span>
              @endif
            </div>
          @endif
        </div>
      </div>

      <!-- RIGHT SIDEBAR -->
      <div class="flex flex-col gap-5">

        <!-- Dept Breakdown -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
          <h3 class="text-sm font-bold text-gray-900 mb-4">Department Summary</h3>
          <div class="space-y-3">
            <div>
              <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span><span class="text-xs font-semibold text-gray-700">{{ $department->code ?? 'N/A' }}</span></div>
                <span class="text-xs text-gray-400">{{ $totalStudents }} students</span>
              </div>
              <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full rounded-full bg-blue-500" style="width:100%"></div></div>
            </div>
            <div>
              <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500"></span><span class="text-xs font-semibold text-gray-700">Courses</span></div>
                <span class="text-xs text-gray-400">{{ $totalCourses }} total</span>
              </div>
              <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full rounded-full bg-green-500" style="width:100%"></div></div>
            </div>
            <div>
              <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400"></span><span class="text-xs font-semibold text-gray-700">Avg. Progress</span></div>
                <span class="text-xs text-gray-400">{{ $avgProgress }}%</span>
              </div>
              <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full rounded-full bg-amber-400" style="width:{{ max(5, $avgProgress) }}%"></div></div>
            </div>
          </div>
        </div>

        <!-- Top Performers -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
          <h3 class="text-sm font-bold text-gray-900 mb-4">Top Performers</h3>
          <div class="space-y-3">
            @forelse($topPerformers as $performer)
              @php
                $avatarColors = ['from-purple-400 to-purple-600','from-blue-400 to-blue-600','from-cyan-400 to-cyan-600','from-rose-400 to-rose-600'];
                $ac = $avatarColors[$loop->index % count($avatarColors)];
              @endphp
              <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-300 w-4">#{{ $loop->iteration }}</span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $ac }} flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                  {{ strtoupper(substr($performer->name ?? 'S', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0"><p class="text-xs font-semibold text-gray-800 leading-none truncate">{{ $performer->name }}</p><p class="text-xs text-gray-400">{{ $performer->department->code ?? 'N/A' }}</p></div>
                <span class="text-xs font-bold text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">{{ (int) ($performer->progress ?? 0) }}%</span>
              </div>
            @empty
              <p class="text-xs text-gray-400">No student performance data available.</p>
            @endforelse
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
          <h3 class="text-sm font-bold text-gray-900 mb-4">Quick Actions</h3>
          <div class="grid grid-cols-2 gap-2.5">
            <button class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold transition-colors">
              <span class="text-xl">➕</span>Add Student
            </button>
            <button class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 text-xs font-semibold transition-colors">
              <span class="text-xl">📧</span>Send Notice
            </button>
            <a href="{{ route('department.reports') }}" class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 text-xs font-semibold transition-colors"><span class="text-xl">&#128202;</span>View Reports</a>
            <button class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 text-xs font-semibold transition-colors">
              <span class="text-xl">📋</span>Manage Courses
            </button>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
          <h3 class="text-sm font-bold text-gray-900 mb-4">Recent Activity</h3>
          <div class="space-y-3">
            @forelse($recentDepartmentActivity as $activity)
              <div class="flex items-start gap-2.5">
                <span class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $activity->dot ?? 'bg-gray-400' }}"></span>
                <div><p class="text-xs text-gray-700 leading-snug">{{ $activity->message }}</p><p class="text-xs text-gray-400 mt-0.5">{{ $activity->time }}</p></div>
              </div>
            @empty
              <p class="text-xs text-gray-400">No recent activity found.</p>
            @endforelse
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- STUDENT MODAL -->
<div id="studentModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeStudentModal()"></div>
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
    <div class="h-1.5" style="background:linear-gradient(90deg,#4285F4,#34A853)"></div>
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
      <h3 class="text-base font-bold text-gray-900">Student Profile</h3>
      <button onclick="closeStudentModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 text-xl leading-none transition-colors">&times;</button>
    </div>
    <div class="px-6 py-5 space-y-5">
      <div class="flex items-center gap-4">
        <div id="modal-avatar" class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold flex-shrink-0" style="background:linear-gradient(135deg,#4285F4,#34A853)"></div>
        <div>
          <p id="modal-name" class="text-lg font-extrabold text-gray-900 leading-none"></p>
          <p id="modal-email" class="text-sm text-gray-400 mt-1"></p>
          <div class="flex items-center gap-2 mt-2">
            <span id="modal-dept" class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded-lg"></span>
            <span id="modal-status-badge" class="text-xs font-semibold px-2.5 py-0.5 rounded-full"></span>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 rounded-xl p-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-semibold text-gray-600">Overall Progress</span>
          <span id="modal-progress-text" class="text-sm font-extrabold text-blue-600"></span>
        </div>
        <div class="h-2.5 bg-gray-200 rounded-full overflow-hidden">
          <div id="modal-progress-bar" class="h-full rounded-full transition-all duration-700" style="width:0%; background:linear-gradient(90deg,#4285F4,#34A853)"></div>
        </div>
      </div>
      <div class="grid grid-cols-3 gap-3">
        <div class="bg-gray-50 rounded-xl p-3 text-center"><div class="text-lg">&#128218;</div><div id="modal-courses-count" class="text-lg font-extrabold text-gray-800 mt-1">0</div><div class="text-xs text-gray-400">Courses</div></div>
        <div class="bg-gray-50 rounded-xl p-3 text-center"><div class="text-lg">&#9989;</div><div id="modal-completed-count" class="text-lg font-extrabold text-gray-800 mt-1">0</div><div class="text-xs text-gray-400">Completed</div></div>
        <div class="bg-gray-50 rounded-xl p-3 text-center"><div class="text-lg">&#127941;</div><div id="modal-certificates-count" class="text-lg font-extrabold text-gray-800 mt-1">0</div><div class="text-xs text-gray-400">Certificates</div></div>
      </div>
      <div>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Recent Courses</p>
        <div id="modal-recent-courses" class="space-y-2"></div>
      </div>
    </div>
    <div class="px-6 py-4 border-t border-gray-100 flex gap-3">
      <button onclick="closeStudentModal()" class="flex-1 py-2.5 text-sm font-semibold text-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all" style="background:linear-gradient(135deg,#4285F4,#34A853)">Close</button>
      <!-- <button onclick="closeStudentModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Close</button> -->
    </div>
  </div>
</div>

<script>
function filterTable() {
  const search = (document.getElementById('globalSearch')?.value || '').toLowerCase();
  const dept   = document.getElementById('deptFilter')?.value || 'ALL';
  const status = document.getElementById('statusFilter')?.value || 'ALL';
  const rows   = document.querySelectorAll('.student-row');
  let visible  = 0;
  rows.forEach(row => {
    const ok = row.dataset.name.includes(search)
      && (dept   === 'ALL' || row.dataset.dept   === dept)
      && (status === 'ALL' || row.dataset.status === status);
    row.style.display = ok ? '' : 'none';
    if (ok) visible++;
  });
  const el = document.getElementById('tableCount');
  if (el) el.textContent = 'Showing ' + visible + ' student' + (visible !== 1 ? 's' : '');
}
document.getElementById('globalSearch')?.addEventListener('input', filterTable);
document.getElementById('deptFilter')?.addEventListener('change', filterTable);
document.getElementById('statusFilter')?.addEventListener('change', filterTable);

function openStudentModal(data) {
  const name = data?.name || 'Student';
  const email = data?.email || '';
  const dept = data?.dept || 'N/A';
  const progress = Number(data?.progress || 0);
  const status = data?.status || 'inactive';
  const courses = Number(data?.courses || 0);
  const completed = Number(data?.completed || 0);
  const certificates = Number(data?.certificates || 0);
  const recentCourses = Array.isArray(data?.recent_courses) ? data.recent_courses : [];

  document.getElementById('modal-avatar').textContent = name.slice(0,2).toUpperCase();
  document.getElementById('modal-name').textContent = name;
  document.getElementById('modal-email').textContent = email;
  document.getElementById('modal-dept').textContent = dept;
  document.getElementById('modal-courses-count').textContent = String(courses);
  document.getElementById('modal-completed-count').textContent = String(completed);
  document.getElementById('modal-certificates-count').textContent = String(certificates);

  const recentCoursesEl = document.getElementById('modal-recent-courses');
  if (recentCourses.length === 0) {
    recentCoursesEl.innerHTML = '<p class="text-xs text-gray-400">No recent course data.</p>';
  } else {
    recentCoursesEl.innerHTML = recentCourses.map((course) => {
      const courseProgress = Number(course.progress || 0);
      const barColor = courseProgress >= 75 ? 'bg-green-500' : (courseProgress >= 40 ? 'bg-blue-500' : 'bg-amber-400');
      return `
        <div class="flex items-center gap-3 p-2.5 bg-gray-50 rounded-xl">
          <div class="text-base">${course.icon || '&#128218;'}</div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-gray-700 truncate">${course.title || 'Course'}</p>
            <div class="h-1 bg-gray-200 rounded-full mt-1 overflow-hidden"><div class="h-full rounded-full ${barColor}" style="width:${courseProgress}%"></div></div>
          </div>
          <span class="text-xs font-bold text-gray-500">${courseProgress}%</span>
        </div>
      `;
    }).join('');
  }

  const pb = document.getElementById('modal-progress-bar');
  document.getElementById('modal-progress-text').textContent = progress + '%';
  pb.style.width = '0%';
  setTimeout(() => pb.style.width = progress + '%', 60);
  const sb = document.getElementById('modal-status-badge');
  if (status === 'active') {
    sb.textContent = '� Active';
    sb.className = 'text-xs font-semibold px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 border border-green-200';
  } else {
    sb.textContent = '� Inactive';
    sb.className = 'text-xs font-semibold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200';
  }
  const m = document.getElementById('studentModal');
  m.classList.remove('hidden');
  m.classList.add('flex');
}
function closeStudentModal() {
  const m = document.getElementById('studentModal');
  m.classList.add('hidden');
  m.classList.remove('flex');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeStudentModal(); });
</script>

</body>
</html>
