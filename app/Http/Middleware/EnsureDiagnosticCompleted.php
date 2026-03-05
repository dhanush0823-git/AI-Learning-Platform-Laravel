<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDiagnosticCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        $student = auth('student')->user();

        if (! $student) {
            return redirect()->route('login');
        }

        if (! $student->diagnosticAttempts()->exists()) {
            return redirect()
                ->route('diagnostic.test')
                ->with('warning', 'Please complete diagnostic test first.');
        }

        return $next($request);
    }
}
