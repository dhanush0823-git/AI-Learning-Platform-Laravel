@extends('layouts.app')

@section('title', 'Courses - AI Learning Platform')

@section('content')
<section style="max-width: 1100px; margin: 32px auto; padding: 0 16px;">
    <div style="display: flex; justify-content: space-between; gap: 16px; align-items: flex-end; flex-wrap: wrap; margin-bottom: 18px;">
        <div>
            <h1 style="margin: 0 0 6px;">Courses</h1>
            <p style="margin: 0; color: #6b7280;">Browse courses by department and level.</p>
        </div>
        <form method="GET" action="{{ route('courses', [], false) }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <select name="department" style="padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                <option value="ALL">All Departments</option>
                @foreach($departments as $department)
                    <option value="{{ $department->code }}" @selected(request('department') === $department->code)>
                        {{ $department->code }} - {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <select name="difficulty" style="padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                @foreach($difficulties as $difficulty)
                    <option value="{{ $difficulty->value }}" @selected(request('difficulty', 'ALL') === $difficulty->value)>
                        {{ $difficulty->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" style="padding: 10px 14px; background: #2563eb; color: white; border: 0; border-radius: 8px; font-weight: 600;">Apply</button>
        </form>
    </div>

    <div style="margin-bottom: 16px; color: #4b5563;">
        Showing {{ $courses->count() }} course(s)
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
        @forelse($courses as $course)
            <article style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; gap: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                    <span style="font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 9999px; background: #eef2ff; color: #3730a3;">
                        {{ strtoupper($course->difficulty) }}
                    </span>
                    <span style="font-size: 12px; color: #6b7280;">{{ $course->duration ?? 'Self-paced' }}</span>
                </div>
                <h3 style="margin: 0;">{{ $course->title }}</h3>
                <p style="margin: 0; color: #6b7280;">{{ $course->description }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                    <span style="font-size: 13px; color: #4b5563;">
                        {{ $course->department->code ?? 'N/A' }}
                    </span>
                    <a href="{{ route('courses.show', $course->id) }}" style="font-weight: 600; color: #2563eb; text-decoration: none;">
                        View Details
                    </a>
                </div>
            </article>
        @empty
            <div style="grid-column: 1 / -1; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                No courses found for selected filters.
            </div>
        @endforelse
    </div>
</section>
@endsection
