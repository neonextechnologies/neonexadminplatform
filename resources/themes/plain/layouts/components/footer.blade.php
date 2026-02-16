{{-- Footer Component (Placeholder) --}}
{{-- Phase 0B: Static footer --}}
{{-- Layer A: Plain Bootstrap markup only --}}

<footer class="bg-light border-top py-3 mt-auto">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-start">
                <p class="text-muted small mb-0">
                    &copy; {{ date('Y') }} {{ config('app.name', 'NeonEx') }}. All rights reserved.
                </p>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end">
                <p class="text-muted small mb-0">
                    <span class="badge bg-success">Phase 0B</span>
                    Laravel {{ app()->version() }} | Bootstrap 5
                </p>
            </div>
        </div>
    </div>
</footer>
