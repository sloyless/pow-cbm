<?php
  $type = $_GET['type'];
  if ($type) {
    $series_name = filter_input ( INPUT_POST, 'series_name' );
    if ($type == 'issue-search' || $type == 'issue-add' || $type == 'issue-submit') {
      require_once(__ROOT__.'/classes/wikiFunctions.php');
      $series_id = filter_input ( INPUT_POST, 'series_id' );
      $series_vol = filter_input(INPUT_POST, 'series_vol');
      $issue_number = filter_input ( INPUT_POST, 'issue_number' );
    }
    switch ($type) {
      // Runs when the Add Series form has been submitted
      case 'series':
        $publisher = filter_input ( INPUT_POST, 'publisher' );
        $series_vol = filter_input ( INPUT_POST, 'series_vol' );
        $sql = "INSERT INTO series (series_name, series_vol) VALUES ('$series_name', '$series_vol')";
        if (mysqli_query ( $connection, $sql )) {
          $messageNum = 3;
          $seriesSubmitted = true;
          $sqlMessage = '<strong class="text-success">Success</strong>: <code>' . $sql . '</code>';
        } else {
          $sqlMessage = '<strong class="text-danger">Error</strong>: ' . $sql . '<br /><code>' . mysqli_error ( $connection ) . $connection->errno . '</code>';
          $seriesSubmitted = false;
          if ($connection->errno == 1062) {
            $messageNum = 50;
          }
        }
        break;
      // Part one of the single issue process. Displays Wikia results.
      case 'issue-search':
        $issueSearch = true;
        $query = $series_name . ' Vol ' . $series_vol . ' ' . $issue_number;

        $wiki = new wikiQuery();
        $wiki->wikiSearch($query, 50);
        break;
      // Part two of the single issue process. Displays final fields and allows user to change details before adding to collection.
      case 'issue-add':
        $issueAdd = true;
        $wiki_id = filter_input (INPUT_POST, 'wiki_id');
        $comic_id = filter_input(INPUT_POST, 'comic_id');
        $comic = new wikiQuery ();
        $comic->comicCover ( $wiki_id );
        $comic->comicDetails ( $wiki_id );
        
        $sql = new comicSearch ();
        $sql->seriesFind ($series_name);
        if ($sql->series->num_rows > 0) {
          while ( $row = $sql->series->fetch_assoc () ) {
            $series_id = $row ['series_id'];
            $series_vol = $row ['series_vol'];
          }
        }
        break;
      case 'issue-submit':
        $issueSubmit = true;
        $ownerID = $_SESSION['user_id'];
        $comic_id = filter_input ( INPUT_POST, 'comic_id' );
        $wiki_id = filter_input ( INPUT_POST, 'wiki_id' );
        $released_date = filter_input ( INPUT_POST, 'released_date' );
        $story_name = addslashes ( filter_input ( INPUT_POST, 'story_name' ) );
        $plot = addslashes ( filter_input ( INPUT_POST, 'plot' ) );
        $cover_image = filter_input ( INPUT_POST, 'cover_image' );
        $cover_image_file = filter_input ( INPUT_POST, 'cover_image_file' );
        $original_purchase = filter_input ( INPUT_POST, 'original_purchase' );

        if ($released_date == 0000 - 00 - 00) {
          $release_date = "";
        } else {
          $release_date = $released_date;
        }

        if ($cover_image) {
          $path = __ROOT__ . '/images/' . $cover_image_file;
          $wiki = new wikiQuery();
          $wiki->downloadFile ( $cover_image, $path );
        }

        $query = new comicSearch();
        $query->issueCheck($series_id, $issue_number);
        if ($query->issueExists == 1) {
          $sql = "INSERT INTO users_comics (user_id, comic_id) VALUES ('$ownerID', '$query->comic_id')";
          $comic_id = $query->comic_id;
          if (mysqli_query ( $connection, $sql )) {
            $messageNum = 1;
            $sqlMessage = '<strong class="text-success">Success</strong>: Issue was matched to an existing issue in the database and added to the users collection.';
          } else {
            $sqlMessage = '<strong class="text-warning">Error:</strong> ' . $sql . '<br>' . mysqli_error ( $connection );
            $messageNum = 51;
          }
        } else {
          $sql = "INSERT INTO comics (series_id, issue_number, story_name, release_date, plot, cover_image, original_purchase, wiki_id, wikiUpdated)
          VALUES ('$series_id', '$issue_number', '$story_name', '$release_date', '$plot', 'images/$cover_image_file', '$original_purchase', '$wiki_id', 1)";
          if (mysqli_query ( $connection, $sql )) {
            $comic_id = mysqli_insert_id($connection);
            // Add to user_comics table
            $sql_user = "INSERT INTO users_comics (user_id, comic_id) VALUES ('$ownerID', '$comic_id')";
            if (mysqli_query ( $connection, $sql_user )) {
              $messageNum = 1;
              $sqlMessage = '<strong class="text-success">Success</strong>: Issue did not exist in the current database. Issue added to database and users collection.';
            } else {
              $sqlMessage = '<strong class="text-warning">Error</strong>: ' . $sql_user . '<br>' . mysqli_error ( $connection );
            }
          } else {
            $sqlMessage = '<strong class="text-warning">Error</strong>: ' . $sql . '<br>' . mysqli_error ( $connection );
          }
        }
        break;
      case 'range':
        break;
      case 'csv':
        break;
      case 'update':
        break;
    }
  } else {
    // If no type is detected, something is wrong. Display general error message.
    $submitted = 'no';
    $messageNum = 99;
  }
?>