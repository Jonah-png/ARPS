<?php session_start(); /* Starts the session */

if (!isset($_SESSION['UserData']['Username'])) {
  header("location:login.php");
  exit;
}
if (isset($_POST['delete'])) {
  $files = glob("images/*");
  foreach ($files as $file) {
    if (is_file($file)) {
      unlink($file);
    }
  }
  $audFiles = glob("images/audience/*");
  if (count($audFiles) == 2) {
    unlink($audFiles[0]);
    unlink($audFiles[1]);
  }
  $deskFiles = glob("images/desk/*");
  if (count($deskFiles) == 2) {
    unlink($deskFiles[0]);
    unlink($deskFiles[1]);
  }
}
if (isset($_POST['aud'])) {
  $filename = $_POST['dataAud'];
  $files = glob("images/audience/*");
  if (file_exists("images/audience/" . $filename)) {
    unlink("images/audience/" . $filename);
    unlink("images/audience/image.png");
  } else {
    if (count($files) == 2) {
      unlink($files[0]);
      unlink($files[1]);
    }
    copy("images/" . $filename, "images/audience/" . $filename);
    copy("images/" . $filename, "images/audience/image.png");
  }
  if (file_exists("images/desk/" . $filename)) {
    unlink("images/desk/" . $filename);
    unlink("images/desk/image.png");
  }
}
if (isset($_POST['desk'])) {
  $filename = $_POST['dataDesk'];
  $files = glob("images/desk/*");
  if (file_exists("images/desk/" . $filename)) {
    unlink("images/desk/" . $filename);
    unlink("images/desk/image.png");
  } else {
    if (count($files) == 2) {
      unlink($files[0]);
      unlink($files[1]);
    }
    copy("images/" . $filename, "images/desk/" . $filename);
    copy("images/" . $filename, "images/desk/image.png");
  }
  if (file_exists("images/audience/" . $filename)) {
    unlink("images/audience/" . $filename);
    unlink("images/audience/image.png");
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }

    h2 {
      margin-left: 10px;
    }

    #img_list {
      display: flex;
      flex-wrap: wrap;
      list-style: none;
    }

    #img_list li {
      border-radius: 5px;
      margin: 10px;
      max-width: 320px;
    }

    #img_list div {
      padding: 10px 10px 0 10px;
      display: flex;
    }

    #img_list span {
      margin-right: auto;
      display: inline-block;
      width: calc(100% - 60px);
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
    }

    #img_list input[name="desk"] {
      margin-left: 5px;
    }

    #img_list .img {
      width: 300px;
      padding: 10px;
    }

    .not-selected {
      background-color: #f2f2f2;
    }

    .selected-aud {
      background-color: #e5e5ff;
    }

    .selected-desk {
      background-color: #ffe5e5;
    }

    .nav {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #f2f2f2;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1;
      display: flex;
      justify-content: space-between;
    }

    .nav li>* {
      display: block;
      padding: 8px 5px;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <h2>Uploaded Images:</h2>
  <ul id="img_list"></ul>
  <ul class="nav">
    <li><a href="logout.php"><button>Logout</button></a></li>
    <li><a href="audienceMode.html" title="Go to Audience Mode"><button>Audience Mode</button></a></li>
    <li><a href="deskMode.html" title="Go to Desk Mode"><button>Desk Mode</button></a></li>
    <li style="margin-right: auto;">
      <form method="post"><input type="submit" name="delete" value="Delete Images" title="Delete images from server" /></form>
    </li>
    <li>
      <!-- this iframe prevents page from redirecting to a different page onsubmit-->
      <iframe name="frame" style="display: none"></iframe>
      <form id="upload-btn" action="upload.php" method="POST" enctype="multipart/form-data" target="frame">
        <input type="file" id="file-input" name="image" onchange="addImage()" />
      </form>
    </li>
  </ul>
  <script>
    // when a file is chosen, it gets added to the uploaded images section
    function addImage() {
      const input = document.getElementById("file-input");

      // otherwise will throw an error if user clicks cancel instead of choosing file
      if (input.files.length > 0 && input.files[0].type.split("/")[0] == "image") {
        document.getElementById("upload-btn").submit();

        // creates the "Uploaded Files" section
        const list = document.getElementById("img_list");
        const li = document.createElement("li");
        li.className = "not-selected";
        const header = document.createElement("div");
        const span = document.createElement("span");
        const text = document.createTextNode(input.files[0].name);
        const formAud = document.createElement("form");
        formAud.method = "post";
        formAud.target = "frame";
        formAud.className = "form";
        const dataAud = document.createElement("input");
        dataAud.type = "hidden";
        dataAud.name = "dataAud";
        dataAud.value = input.files[0].name;
        const inputAud = document.createElement("input");
        inputAud.type = "submit";
        inputAud.name = "aud";
        inputAud.value = "Audience";
        inputAud.title = "Click to display";

        const formDesk = document.createElement("form");
        formDesk.method = "post";
        formDesk.target = "frame";
        formDesk.className = "form";
        const dataDesk = document.createElement("input");
        dataDesk.type = "hidden";
        dataDesk.name = "dataDesk";
        dataDesk.value = input.files[0].name;
        const inputDesk = document.createElement("input");
        inputDesk.type = "submit";
        inputDesk.name = "desk";
        inputDesk.value = "Desk";
        inputDesk.title = "Click to display";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(input.files[0]);
        img.className = "img";

        list.insertBefore(li, list.children[0]);
        li.appendChild(header);
        header.append(span);
        span.appendChild(text);
        header.appendChild(formAud);
        formAud.appendChild(inputAud);
        formAud.appendChild(dataAud);
        header.appendChild(formDesk);
        formDesk.appendChild(inputDesk);
        formDesk.appendChild(dataDesk);
        li.appendChild(img);

        // highlights the selected image when clicked
        inputAud.onclick = function() {
          if (li.className == "selected-aud") {
            li.className = "not-selected";
          } else {
            const lis = document.querySelectorAll("#img_list li");
            lis.forEach(item => {
              if (item.className == "selected-aud") {
                item.className = "not-selected";
              }
            });
            li.className = "selected-aud";
          }
        };
        inputDesk.onclick = function() {
          if (li.className == "selected-desk") {
            li.className = "not-selected";
          } else {
            const lis = document.querySelectorAll("#img_list li");
            lis.forEach(item => {
              if (item.className == "selected-desk") {
                item.className = "not-selected";
              }
            });
            li.className = "selected-desk";
          }
        };
      }
    }
  </script>
</body>

</html>