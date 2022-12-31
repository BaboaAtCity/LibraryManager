<?php
    session_start();
    $conn = require_once('dbconnection.php');

    if (empty($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    $actionMessage = null;

    // Add a book
    $bookTitle = $_POST['booktitle'] ?? null;
    $bookISBN = $_POST['bookISBN'] ?? null;
    $bookAuthor = $_POST['bookauthor'] ?? null;

    if ($bookTitle && $bookISBN && $bookAuthor) {
        $statement = 'INSERT INTO Book (ISBN, name, author) VALUES(?, ?, ?)';
        $userStatement = $conn->prepare($statement);
        $userStatement->execute([$bookISBN, $bookTitle, $bookAuthor]);
        $actionMessage = 'The book was added successfully';
    }

    // Remove a book
    $bookISBNToRemove = $_POST['bookISBNToRemove'] ?? null;

    if ($bookISBNToRemove) {
        $statement = 'DELETE FROM Book WHERE ISBN=?';
        $userStatement = $conn->prepare($statement);
        $userStatement->execute([$bookISBNToRemove]);
        $actionMessage = 'The book was removed successfully';
    }

    // List all books
    $statement = 'SELECT * FROM Book';
    $books = $conn->prepare($statement);
    $books->execute();

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="admin-style.css">
</head>

<body>
<div class="container-fluid">

    <div class="row" style="height: 50px;">
        <main>
            <header>
                <nav>
                    <article class="main">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 logo">
                            <div class="col-xs-8 col-sm-8 col-md-6 col-lg-6" style="float:left; margin-top: 24px;">
                                <a href="index.php"><img width="80%" src="assets/img/book.png" alt="booktique logo"></a>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-6" style="float: right">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="padding: 10px;">
                                    <i class="fa fa-bars fa-2x"></i>
                                </button>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-right">
                                <div class="collapse navbar-collapse main" id="navbarNav">
                                    <ul>
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </article>
                </nav>
            </header>
        </main>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center; color: #998D7C; margin-bottom: 80px;">
            <h1><i class="fa fa-cog	"></i>Admin Panel</h1>
            <?php if ($actionMessage): ?>
            <div class="alert alert-success" role="alert"><?php echo $actionMessage ?></div>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Admin panels -->
    <div class="row" style="margin-left: -30px; margin-right: -30px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 column" onclick="openTab('b1');" style="background:#998D7C;">
                View inventory
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 column" onclick="openTab('b2');" style="background:#998D7C;">
                Add a book
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 column" onclick="openTab('b3');" style="background:#998D7C;">
                Remove a book
            </div>
        </div>
    </div>


    <!-- Extended panels-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="b1" class="containerTab" style="display:none;background:#998D7C">
            <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
            <h3>View information on our books below</h3>
            <table class="table">
                <thead>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo $book['ISBN'] ?></td>
                        <td><?php echo $book['name'] ?></td>
                        <td><?php echo $book['author'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="b2" class="containerTab" style="display:none;background:#998D7C">
            <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
            <h3>Enter the details about the book you would like to add below:</h3>

            <!-- Add book form -->
            <form action="admin.php" method="post">
                <label for="btitle">Book title</label>
                <input type="text" id="btitle" name="booktitle" placeholder="Title of the book">

                <label for="bISBN">Book ISBN</label>
                <input type="text" id="bISBN" name="bookISBN" placeholder="ISBN number of the book">

                <label for="bauthor">Book Author</label>
                <input type="text" id="bauthor" name="bookauthor" placeholder="Authour of the book">

                <input type="submit" value="Submit">
            </form>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="b3" class="containerTab" style="display:none;background:#998D7C">
            <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
            <h3>Enter ISBN of the book you would like to remove below</h3>
            <!-- Remove book form -->
            <form action="admin.php" method="post">

                <label for="bISBN">Book ISBN</label>
                <input type="text" id="ISBN" name="bookISBNToRemove" placeholder="ISBN number of the book">

                <input type="submit" value="Remove book">
            </form>
        </div>
    </div>

</div>


<script>
    function openTab(tabName) {
        console.log(tabName);
        hide();
        document.getElementById(tabName).style.display = "block";
    }
    function hide() {
        $("#b1").css("display", "none");
        $("#b2").css("display", "none");
        $("#b3").css("display", "none");
    }
</script>

</body>

<!-- Footer -->

</html>
