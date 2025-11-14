<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Secure Access</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      user-select: none;
    }

    .card {
      width: 100%;
      max-width: 380px;
      border: none;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      animation: fadeIn 0.6s ease-in-out;
    }

    .card-header {
      background-color: #ffffff;
      padding: 1.25rem;
      text-align: center;
    }

    .card-header h5 {
      margin: 0;
      font-weight: 600;
      color: #333;
    }

    .card-body {
      background-color: #fdfdfd;
      padding: 1.5rem;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
      border-color: #667eea;
    }

    .btn-primary {
      background-color: #667eea;
      border-color: #667eea;
    }

    .btn-primary:hover {
      background-color: #5a67d8;
      border-color: #5a67d8;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">
      <h5>Secure Access</h5>
    </div>
    <div class="card-body">
      <form action="backend/auth.php" method="POST">
        <div id="warning" class="alert alert-danger" style="display: none; margin-bottom: 1rem;">
          Incorrect passkey. Please try again.
        </div>
        <div class="mb-3">
          
          <input
            type="password"
            class="form-control"
            id="passkey"
            name="passkey"
            placeholder="Enter your Passkey"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100">Unlock</button>
      </form>
    </div>
  </div>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
      document.getElementById('warning').style.display = 'block';
    }
  </script>
  <!-- Sticky Footer -->
  <footer
    class="text-center py-3 border-top text-muted small fixed-bottom bg-light"
  >
    &copy; 2025
    <a href="https://mdanikbiswas.rf.gd/" class="text-decoration-none text-primary fw-semibold"
      >MD ANIK BISWAS</a
    >. All rights reserved.
  </footer>
</body>
</html>
