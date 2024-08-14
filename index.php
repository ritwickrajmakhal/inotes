<?php
require_once __DIR__ . "/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $note_title = $_POST['note_title'];
  $note_desc = $_POST['note_desc'];
  $stmt = $conn->prepare('INSERT INTO ' . DATABASE_NAME . '.notes (title, description) VALUES (:title, :description)');
  $stmt->bindParam(':title', $note_title, PDO::PARAM_STR);
  $stmt->bindParam(':description', $note_desc, PDO::PARAM_STR);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>iNotes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />

</head>

<body>
  <!-- Modal Start -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form Start -->
        <form action="edit.php" method="POST" target="_self">
          <input id="modalNoteId" type="hidden" name="id" />
          <div class="modal-body">
            <div class="mb-3">
              <label for="modalNoteTitle" class="form-label">Note Title</label>
              <input name="note_title" type="text" id="modalNoteTitle" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="modalNoteDesc" class="form-label">Note Description</label>
              <textarea name="note_desc" rows="5" class="form-control" id="modalNoteDesc"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
  <!-- Modal End -->

  <!-- NavBar Start -->
  <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <i class="fa-brands fa-php fa-2xl"></i>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-success" type="submit">
            Search
          </button>
        </form>
      </div>
    </div>
  </nav>
  <!-- NavBar End -->

  <!-- Alert Start -->
  <div style="min-height: 70px" id="alert">

  </div>
  <!-- Alert End -->

  <div class="container">
    <!-- Form Start -->
    <form action="index.php" method="POST" target="_self">
      <h1>Add a Note to iNotes</h1>
      <div class="mb-3">
        <label for="noteTitle" class="form-label">Note Title</label>
        <input name="note_title" type="text" id="noteTitle" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="noteDesc" class="form-label">Note Description</label>
        <textarea name="note_desc" rows="5" class="form-control" id="noteDesc"></textarea>
      </div>
      <button type="submit" <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' ? 'onclick="insertAlert()"' : ''; ?>
        class="btn btn-primary mb-3">
        Add Note
      </button>
    </form>
    <!-- Form End -->

    <!-- Table Start -->
    <?php
    $stmt = $conn->prepare('SELECT * FROM ' . DATABASE_NAME . '.notes');
    $stmt->execute();
    $notes = $stmt->fetchAll();
    ?>

    <div class="table-responsive">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th>S.No</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notes as $index => $note) { ?>
            <tr id=<?php echo $note['id'] ?>>
              <td><?php echo $index + 1 ?></td>
              <td><?php echo $note['title'] ?></td>
              <td>
                <span class="text-truncate-custom"><?php echo $note['description'] ?></span>
              </td>
              <td>
                <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                  class="edit btn btn-sm btn-primary">Edit</button>
                <button class="delete btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Table End -->
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
  <script src="script.js"></script>
</body>

</html>