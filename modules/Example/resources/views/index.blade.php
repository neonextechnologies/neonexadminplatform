<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Example Module</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <strong>Success!</strong> Module loader is working correctly.
                </div>
                <p>This page proves that:</p>
                <ul>
                    <li>ModuleServiceProvider discovered the Example module</li>
                    <li>Module routes are loaded correctly</li>
                    <li>Module views are accessible via <code>example::</code> namespace</li>
                </ul>
                <hr>
                <p class="mb-0"><strong>Phase 0A Exit Criteria:</strong> ✅ App boots with module loader loading at least 1 module skeleton</p>
            </div>
        </div>
    </div>
</body>
</html>
