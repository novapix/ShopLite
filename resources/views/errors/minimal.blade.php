<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <style>
        html,body{margin:0;padding:0;height:100%;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#f9fafb;color:#1a202c;display:flex;align-items:center;justify-content:center}.error-container{text-align:center;max-width:600px;padding:2rem;background-color:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.05)}.error-code{font-size:6rem;font-weight:700;color:#6366f1}.error-title{font-size:1.75rem;margin-top:.5rem;color:#4b5563;text-transform:uppercase}.error-message{margin-top:1rem;font-size:1rem;color:#6b7280}.error-actions{margin-top:2rem}.btn{display:inline-block;padding:.75rem 1.5rem;background-color:#6366f1;color:#fff;border-radius:8px;text-decoration:none;font-weight:500;transition:background-color .3s}.btn:hover{background-color:#4f46e5}@media (prefers-color-scheme:dark){html,body{background-color:#1a202c;color:#edf2f7}.error-container{background-color:#2d3748}.error-code{color:#f87171}.error-title{color:#e2e8f0}.error-message{color:#cbd5e0}.btn{background-color:#f87171}.btn:hover{background-color:#ef4444}}
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">@yield('code')</div>
        <div class="error-title">@yield('title')</div>
        <div class="error-message">@yield('message')</div>
        <div class="error-actions">
            @yield('action')
        </div>
    </div>
</body>
</html>
