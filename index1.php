<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Live Search Mahasiswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    .fade-in {
      opacity: 0;
      transform: translateY(10px);
      animation: fadeIn 0.4s ease-out forwards;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Live Search Mahasiswa (AJAX + MySQL)</h2>
    
    <input type="text" id="search" class="form-control mb-3" placeholder="Ketik nama atau NIM...">

    <!-- Spinner loading -->
    <div id="loading" class="text-center mb-3" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div>Mencari data...</div>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Jurusan</th>
        </tr>
      </thead>
        <tbody id="result">
        <?php
            include 'db.php';

            $query = "SELECT * FROM mahasiswa";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>${row['nim']}</td>
                        <td>${row['nama']}</td>
                        <td>${row['jurusan']}</td>
                    </tr>";
                }
            } else {
                echo "Data mahasiswa ga ada, cuy!";
            }
        ?>
        </tbody>
    </table>
  </div>

  <script>
    const searchBox = document.getElementById("search");
    const result = document.getElementById("result");
    const loading = document.getElementById("loading");

    searchBox.addEventListener("keyup", function () {
      const keyword = searchBox.value.trim();

      if (keyword.length === 0) {
        result.innerHTML = "";
        return;
      }

      loading.style.display = "block";

      fetch("search.php?keyword=" + encodeURIComponent(keyword))
        .then(res => res.json())
        .then(data => {
          loading.style.display = "none";
          result.innerHTML = "";

          if (data.length === 0) {
            result.innerHTML = "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
          } else {
            data.forEach(row => {
              const rowHTML = `
                <tr class="fade-in">
                  <td>${row.nim}</td>
                  <td>${row.nama}</td>
                  <td>${row.jurusan}</td>
                </tr>`;
              result.innerHTML += rowHTML;
            });
          }
        });
    });
  </script>
</body>
</html>
