<?php
    $conn = require_once('dbconnection.php');

    $searchBy = $_GET['searchBy'] ?? null;
    $q = $_GET['q'] ?? null;

    $books = null;
    if ($q && in_array($searchBy, ['ISBN', 'name', 'author'])) {
        $statement = 'SELECT * FROM Book WHERE '.$searchBy.' LIKE \'%'.$q.'%\'';
        $books = $conn->prepare($statement);
        $books->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>split color</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="index-style.css">
    <script src="index.js"></script>
</head>
<body dataspy="scroll" data-target="#navbarResponsive">
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
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" style="padding: 0px;">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-top: 10px;">
                            <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-right">
                                <div class="collapse navbar-collapse main" id="navbarNav">
                                    <ul>
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="login.php">Staff Login</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </article>
                </nav>
            </header>
        </main>
    </div>


    <div class="row" style="height:700px; ">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 0; position: absolute; top: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <form action="index.php" class="search-bar" style="text-align: center;">
                    <select class="form-control" name="searchBy">
                        <option value="" disabled selected>Search By</option>
                        <option value="name"<?php echo (isset($searchBy) && $searchBy==='name')?' selected':''; ?>>Name</option>
                        <option value="author"<?php echo (isset($searchBy) && $searchBy==='author')?' selected':''; ?>>Author</option>
                        <option value="ISBN"<?php echo (isset($searchBy) && $searchBy==='ISBN')?' selected':''; ?>>ISBN</option>
                    </select>
                    <input class="form-control" type="text" placeholder="Search for a book" name="q" value="<?php echo (isset($q))?$q:''; ?>">
                    <button type="submit"><img width="58%" src="assets/img/search.png"
                    ></button>
                </form>
                <?php if ($books !== null): ?>
                    <?php if($books->rowCount() === 0): ?>
                        <h3>No results</h3>
                    <?php else: ?>
                        <h3>Results:</h3>
                        <ul class="book-results">
                        <?php foreach ($books as $book): ?>
                            <li><?php echo $book['name'].' (ISBN: '.$book['ISBN'].'). Author: '.$book['author']; ?></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 footer">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:50px; ">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="#"> <img class='img-responsive' style='width:70%; margin-top: 10px; margin-left: ' src="assets/img/book.png" alt="booktique logo"></a>
                        <br>
                        <p>[Booktique] is a fictitious brand all products/serivces and people associated with [Booktique] are also fictitious.</p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <h3>Quick Links</h3>
                            <a href="index.php"><strong><i>Home</i></strong></a> <br />
                            <a href="login.php"><strong><i>Staff Login</i></strong></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fa" style="margin-top: 50px;">
                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <a href="https://en-gb.facebook.com//" class="fa fa-facebook"></a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <a href="https://www.instagram.com//" class="fa fa-instagram"></a>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <a href="https://twitter.com/?lang=en-gb/"
                               class="fa fa-twitter"></a>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 10px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h2> Contact us </h2>
                        <br>
                        <form>
                            <div class="form-group">
                                <input class="form-control text-input"  type="email" name="email" id ="email" placeholder="Your email address" style="padding: 20px;">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control contact-input" id="message" name="message" placeholder ="Your message " style="padding: 20px;"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 footer-bottom">
                <span>&copy; Copyright©2022[Booktique]</span>
            </div>

        </div>
    </div>

</div>

</body>
</html>
