@extends('layouts.app')

@section('title', 'Student Report - ' . ($student->name ?? 'Student'))

@section('content')
<section class="max-w-screen-xl mx-auto px-6 py-8">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-full px-3 py-1 mb-3">
            <span class="text-xs font-bold tracking-widest text-blue-500 uppercase">Student Report</span>
        </div>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-lg font-bold"
                     style="background: linear-gradient(135deg,#4285F4,#34A853)">
                    {{ collect(explode(' ', $student->name ?? 'Student'))->filter()->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('') ?: 'ST' }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $student->name ?? 'Student' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $student->email ?? 'No email available' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Department: {{ $department->code ?? 'N/A' }}</p>
                </div>
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
        $moduleCompletedCount = $moduleTests->whereNotNull('completed_at')->count();
        $moduleAverage = $moduleTests->count()
            ? round($moduleTests->avg(fn ($test) => $test->total_questions ? (($test->score / $test->total_questions) * 100) : 0), 1)
            : 0;
        $diagnosticPercentage = $latestDiagnostic ? round($latestDiagnostic->percentage ?? 0, 2) : 0;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">🧠</div>
                <span class="text-xs font-semibold text-blue-500 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">
                    Diagnostic
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $diagnosticPercentage }}%</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Latest Diagnostic Score</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">✅</div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                    {{ $moduleCompletedCount }} completed
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $moduleTests->count() }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Module Test Attempts</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center text-xl">🎯</div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full">
                    Avg module score
                </span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $moduleAverage }}%</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Average Module Percentage</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-1 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900">Diagnostic Test</h2>
                <p class="text-xs text-gray-400 mt-0.5">Most recent diagnostic assessment result</p>
            </div>

            @if($latestDiagnostic)
                <div class="p-6 space-y-4">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-500">Score</p>
                        <p class="text-2xl font-extrabold text-gray-900 mt-1">
                            {{ $latestDiagnostic->score }} / {{ $latestDiagnostic->total_questions }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">{{ $diagnosticPercentage }}% overall</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-sm text-gray-500">Assigned Level</span>
                            <span class="inline-flex items-center bg-green-50 text-green-700 border border-green-100 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                {{ ucfirst($latestDiagnostic->assigned_level ?? 'N/A') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-sm text-gray-500">Completed On</span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $latestDiagnostic->completed_at ? $latestDiagnostic->completed_at->format('d M Y, h:i A') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center text-2xl mb-4">📝</div>
                    <h3 class="text-lg font-bold text-gray-900">No diagnostic attempt found</h3>
                    <p class="text-sm text-gray-500 mt-2">Diagnostic assessment details will appear here once the student completes the test.</p>
                </div>
            @endif
        </div>

        <div class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-base font-bold text-gray-900">Module Test Scores</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Performance across module-based assessments</p>
                </div>
                <div class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-500">
                    <span>Total Tests</span>
                    <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded-lg">
                        {{ $moduleTests->count() }}
                    </span>
                </div>
            </div>

            @if($moduleTests->isEmpty())
                <div class="px-6 py-14 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center text-2xl mb-4">📚</div>
                    <h3 class="text-lg font-bold text-gray-900">No module tests available</h3>
                    <p class="text-sm text-gray-500 mt-2">Module assessment attempts will appear here after the student takes module tests.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4 text-left">Module</th>
                                <th class="px-6 py-4 text-left">Score</th>
                                <th class="px-6 py-4 text-left">Percentage</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <!-- <th class="px-6 py-4 text-left">Action</th> -->
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($moduleTests as $test)
                                @php
                                    $percentage = $test->total_questions
                                        ? round(($test->score / $test->total_questions) * 100, 2)
                                        : 0;

                                    $progressColor = $percentage >= 75
                                        ? 'bg-green-500'
                                        : ($percentage >= 40 ? 'bg-amber-400' : 'bg-rose-400');
                                @endphp
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $test->module->title ?? 'Module ' . $test->module_id }}</p>
                                            <p class="text-xs text-gray-400 mt-1">Module assessment</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center bg-gray-50 text-gray-700 border border-gray-200 px-3 py-1 rounded-xl font-semibold">
                                            {{ $test->score }} / {{ $test->total_questions }}
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
                                        @if($test->completed_at)
                                            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                In Progress
                                            </span>
                                        @endif
                                    </td>
                                    <!-- <td class="px-6 py-4">
                                        <a
                                            href="{{ route('assessments.adaptive.result', $test) }}"
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
    </div>
</section>
@endsection
