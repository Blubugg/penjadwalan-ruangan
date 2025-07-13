<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Aksi User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #1f2937; /* text-gray-800 */
            padding: 2rem;
            margin: 0;
        }
        .header {
            background: linear-gradient(to right, #1e3a8a, #2563eb); /* from-blue-900 to-blue-600 */
            color: white;
            padding: 1.5rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .content {
            background-color: #f9fafb; /* gray-50 */
            padding: 2rem;
            border-radius: 0 0 0.5rem 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #4b5563; /* text-gray-600 */
            text-align: center;
        }
        .btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #facc15; /* yellow-400 */
            color: #1e3a8a; /* blue-900 */
            font-weight: 600;
            text-decoration: none;
            border-radius: 0.375rem;
        }
        .btn:hover {
            background-color: #fde047; /* yellow-300 */
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Notifikasi Sistem – LokaSana</h2>
    </div>

    <div class="content">
        <p>Hai Admin,</p>
        <p>User <strong>{{ $user->name }}</strong> telah melakukan aksi: <strong>{{ $action }}</strong>.</p>
        <p>Silakan cek dashboard untuk detail lebih lanjut.</p>
        <a href="{{ url('/admin/pesanan') }}" class="btn">Lihat Dashboard</a>
        <p>Salam,<br><strong>LokaSana</strong></p>
    </div>

    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
    </div>

</body>
</html>
