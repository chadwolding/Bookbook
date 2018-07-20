<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=1">Bookbook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=1">World's Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="controllers/myCircleController.php">My Circle</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="controllers/newPostController.php">New Post</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="controllers/accountController.php"><?php echo ucwords($_SESSION['username']) ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="models/logout.php">Logout</a>
                </li>
                <!--
                <form class="form-inline my-2 my-lg-0 ml-lg-3">
                    <input class="form-control mr-sm-2" type="search" id='search' placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                -->
            </ul>
        </div>
    </div>
</nav>
<script>
    $(document).ready( function () {
        $('#search').keyup(function() {
            var searchItems = $('#search').val();
            $.ajax({
                type: 'POST',
                url: 'models/getSearchResults.php',
                //datatype: "json",
                data: {searchItems : searchItems},
                success: function(data) {
                    alert(data);
                },
                error: function () {
                    alert('error');
                }
            });
        });
    });

</script>