@extends('layouts.app')

@section('title', 'Module Marks - ' . ($course->title ?? 'Course'))

@section('content')
<section class="max-w-screen-xl mx-auto px-6 py-8">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 py-1 mb-3">
            <span class="text-xs font-bold tracking-widest text-blue-500 uppercase">Course Report</span>
        </div>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $course->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Module-wise assessment performance for {{ $department->code ?? 'N/A' }} department students.
                </p>
            </div>
            <a
                href="{{ route('department.reports') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all"
                style="background: linear-gradient(135deg,#4285F4,#34A853)"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back To Reports
            </a>
        </div>
    </div>

    @php
        $completedCount = $moduleAssessments->whereNotNull('completed_at')->count();
        $averagePercentage = $moduleAssessments->count()
            ? round($moduleAssessments->avg(fn ($assessment) => $assessment->total_questions ? (($assessment->score / $assessment->total_questions) * 100) : 0), 1)
            : 0;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">📘</div>
                <span class="text-xs font-semibold text-blue-500 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">
                    {{ $course->total_modules ?? 0 }} modules
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $moduleAssessments->count() }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Total Module Attempts</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">✅</div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                    {{ $completedCount }} completed
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $completedCount }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Finished Assessments</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center text-xl">🎯</div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full">
                    Avg score
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $averagePercentage }}%</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Average Percentage</div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-bold text-gray-900">Student Module Test Marks</h2>
                <p class="text-xs text-gray-400 mt-0.5">Performance across all module assessments in this course</p>
            </div>
            <div class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-500">
                <span>Department</span>
                <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded-lg">
                    {{ $department->code ?? 'N/A' }}
                </span>
            </div>
        </div>

        @if($moduleAssessments->isEmpty())
            <div class="px-6 py-14 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center text-2xl mb-4">📝</div>
                <h3 class="text-lg font-bold text-gray-900">No module test records found</h3>
                <p class="text-sm text-gray-500 mt-2">Student attempts for this course will appear here once module tests are completed.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4 text-left">Student</th>
                            <th class="px-6 py-4 text-left">Module</th>
                            <th class="px-6 py-4 text-left">Score</th>
                            <th class="px-6 py-4 text-left">Percentage</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <!-- <th class="px-6 py-4 text-left">Action</th> -->
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($moduleAssessments as $assessment)
                            @php
                                $percentage = $assessment->total_questions
                                    ? round(($assessment->score / $assessment->total_questions) * 100, 2)
                                    : 0;

                                $progressColor = $percentage >= 75
                                    ? 'bg-green-500'
                                    : ($percentage >= 40 ? 'bg-amber-400' : 'bg-rose-400');

                                $studentName = $assessment->student->name ?? 'Student';
                                $initials = collect(explode(' ', $studentName))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                    ->implode('');
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                             style="background: linear-gradient(135deg,#4285F4,#34A853)">
                                            {{ $initials ?: 'ST' }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 leading-none">{{ $studentName }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $assessment->student->email ?? 'No email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $assessment->module->title ?? 'Module' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Module test</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center bg-gray-50 text-gray-700 border border-gray-200 px-3 py-1 rounded-xl font-semibold">
                                        {{ $assessment->score }} / {{ $assessment->total_questions }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 min-w-[180px]">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $progressColor }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-600 w-12 text-right">{{ $percentage }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($assessment->completed_at)
                                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Open
                                        </span>
                                    @endif
                                </td>
                                <!-- <td class="px-6 py-4">
                                    <a
                                        href="{{ route('assessments.adaptive.result', $assessment) }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 113 12a9 9 0 0118 0z"/>
                                        </svg>
                                        View
                                    </a>
                                </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
