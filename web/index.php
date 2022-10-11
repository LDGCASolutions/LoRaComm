<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="inc/base.css">
    <title>LoRa Command Center</title>
  </head>
  <body>
<?php
include "inc/postgresql.inc.php";

if (!empty($_GET["error"])) {
  if ($_GET["error"] == "1") {
    echo "<script>alert('Invalid Node ID')</script>";
  } else if ($_GET["error"] == "2") {
    echo "<script>alert('Invalid Node Password')</script>";
  } else if ($_GET["error"] == "3") {
    echo "<script>alert('Node ID already exisis')</script>";
  } else if ($_GET["error"] == "4") {
    echo "<script>alert('Node addition failed')</script>";
  } else {
    echo "<script>alert('Something went wrong :-(')</script>";
  }
}

if (!empty($_GET["success"])) {
  if ($_GET["success"] == "1") {
    echo "<script>alert('Node Added')</script>";
  }
}
?>
  <!-- Tab links -->
  <div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Nodes')" id="defaultOpen">Nodes</button>
  <button class="tablinks" onclick="openCity(event, 'Messages')">Messages</button>
  </div>

  <!-- Tab content -->
  <div id="Nodes" class="tabcontent">
    <h3>Registered Nodes</h3>
    <table>
      <tr>
        <th>Node ID</th>
        <th>Node Type</th>
        <th>Description</th>
        <th>Password</th>
        <th>Authenticated</th>
        <th>Last message time</th>
      </tr>
      <?php
        $query = "SELECT * FROM \"Node\"";
        $query = pg_query($db_connection, $query);
        while($row = pg_fetch_row($query)) {
      ?>
      <tr>
        <td><?=$row[0]?></td>
        <td><?=$row[2]?></td>
        <td><?=$row[3]?></td>
        <td><?=$row[1]?></td>
        <td>
          <?php
            $query2 = "SELECT * FROM \"AuthLog\" where \"NodeID\" = '".$row[0]."'";
            $query2 = pg_query($db_connection, $query2);
            if (pg_num_rows($query2)==0) {
              echo "No";
            } else {
              $row2 = pg_fetch_row($query2);
              echo date("Y-m-d H:m:i", $row2[2]);
            }
          ?>
        </td>
        <td>test</td>
      </tr>
      <?php
        }
      ?>
      <tr>
        <form class="" action="submit.php" method="post">
          <td><input type="text" name="nodeID" value="" placeholder="Node ID" pattern="[A-Z0-9]{4,10}" required></td>
          <td><input type="text" name="nodeType" value="" placeholder="Node Type" required></td>
          <td><input type="text" name="nodeDesc" value="" placeholder="Description"></td>
          <td><input type="text" name="nodePass" value="" placeholder="Node Password" pattern="[A-Z0-9]{4,10}" required></td>
          <td><button type="submit" name="action" value="addNode">Add Node</button></td>
        </form>
      </tr>
    </table>

  </div>

  <div id="Messages" class="tabcontent">
    <h3>Paris</h3>
    <p>Paris is the capital of France.</p>
  </div>

  <script type="text/javascript">
    function openCity(evt, cityName) {
      // Declare all variables
      var i, tabcontent, tablinks;

      // Get all elements with class="tabcontent" and hide them
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }

      // Get all elements with class="tablinks" and remove the class "active"
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }

      // Show the current tab, and add an "active" class to the button that opened the tab
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
  </script>
  <script type="text/javascript">
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script>
  </body>
</html>
