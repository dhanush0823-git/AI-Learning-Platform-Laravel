<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\DiagnosticTestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CSEDashboardController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{courseId}/modules/{moduleId}/lessons/{lessonId}', [CourseController::class, 'lesson'])
    ->name('courses.lessons.show');
Route::get('/help', [HelpController::class, 'index'])->name('help');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/privacy', function () { return view('privacy'); })->name('privacy');
Route::get('/terms', function () { return view('terms'); })->name('terms');

// Guest Routes
Route::middleware(['guest', 'guest:student'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth:student,web')
    ->name('logout');

// Authenticated Routes
Route::middleware('auth:student')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/diagnostic-test', [DiagnosticTestController::class, 'index'])->name('diagnostic.test');
    Route::post('/diagnostic-test', [DiagnosticTestController::class, 'submit'])->name('diagnostic.submit');
    Route::get('/diagnostic-test/result/{attemptId}', [DiagnosticTestController::class, 'result'])->name('diagnostic.result');
    Route::get('/learn', [LearningPathController::class, 'index'])
        ->middleware('diagnostic.completed')
        ->name('learn');
    Route::get('/learn/course/{id}', [LearningPathController::class, 'course'])
        ->middleware('diagnostic.completed')
        ->name('learn.course');
    Route::get('/learn/course/{courseId}/module/{moduleId}/start', [LearningPathController::class, 'startModule'])
        ->middleware('diagnostic.completed')
        ->name('learn.module.start');
    Route::get('/learn/course/{courseId}/module/{moduleId}/lesson/{lessonId}', [LearningPathController::class, 'lesson'])
        ->middleware('diagnostic.completed')
        ->name('learn.lesson');
    Route::post('/learn/lessons/{lessonId}/track', [LearningPathController::class, 'trackLessonTime'])
        ->middleware('diagnostic.completed')
        ->name('learn.lesson.track');
    Route::post('/learn/course/{courseId}/module/{moduleId}/lesson/{lessonId}/complete', [LearningPathController::class, 'completeLesson'])
        ->middleware('diagnostic.completed')
        ->name('learn.lesson.complete');
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments');
    Route::post('/assessments/submit', [AssessmentController::class, 'submit'])->name('assessments.submit');
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
    Route::get('/chat', [AIChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [AIChatController::class, 'ask'])->name('chat.ask');
});

Route::middleware(['auth', 'department_admin'])->group(function () {
    Route::get('/department-dashboard', [CSEDashboardController::class, 'cseDashboard'])->name('department.dashboard');
});
