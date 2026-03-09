@extends('layouts.app')

@section('title', 'Assessments - AI Learning Platform')

@section('content')
<section style="max-width: 900px; margin: 32px auto; padding: 0 16px;">
    <h1 style="margin: 0 0 8px;">Assessments</h1>
    <p style="margin: 0 0 18px; color: #6b7280;">Start an adaptive assessment to personalize learning based on your performance.</p>

    @if (session('status'))
        <div style="margin-bottom: 12px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 10px 12px; border-radius: 8px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('assessments.adaptive.start', [], false) }}" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px;">
        @csrf
        <div style="margin-bottom: 12px;">
            <label for="course_id" style="display: block; margin-bottom: 6px; font-weight: 600;">Course (Optional)</label>
            <select id="course_id" name="course_id" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                <option value="">Department-wide assessment</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        <div style="margin-bottom: 12px;">
            <label for="question_count" style="display: block; margin-bottom: 6px; font-weight: 600;">Number of Questions</label>
            <select id="question_count" name="question_count" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
        <button type="submit" style="padding: 10px 14px; background: #2563eb; color: #fff; border: 0; border-radius: 8px; font-weight: 600;">
            Start Adaptive Assessment
        </button>
    </form>
</section>
@endsection
