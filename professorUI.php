<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      body {
        font-family: Arial, sans-serif;
      }
      .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 65vh;
        border: 3px solid;
        border-radius: 20px;
        margin: 20px;
      }
      .center img {
        max-width: 30%;
        max-height: 30%;
      }
      .first-col h2, .slider-container {
        padding: 0 20px;
      }
      input[type="number"] {
        width: 50px;
      }
      .upload-btn {
        position: fixed;
        bottom: 20px;
      }
      .logout-btn, .send-btn {
        position: relative;
        float: right;
        margin-top: 20px;
        margin-right: 20px;
      }
      .list-container {
        height: 80vh;
        overflow-y: auto;
      }
      ul {
        padding: 0 20px 0 0;
        list-style: none;
      }
      .img_list {
        max-width: 100%;
        padding: 5px 0 10px 0;
      }
    </style>
  </head>
  <body>
    <div style="display: flex">
      <div style="flex: 75%" class="first-col">
        <a href="logout.php"><button class="logout-btn">Logout</button></a>
        <h2>Preview:</h2>
        <div class="center">
          <img id="displayed-img" />
        </div>
        <!-- this iframe prevents page from redirecting to a different page onsubmit-->
        <iframe name="frame" style="display: none"></iframe>
        <form class="sliders" method="post" action="WriteToFile.php" target="frame">
          <input class="send-btn" style="margin-top: 0px" type="submit" value="Send Values" onclick="sentMessage()"/>
          <h2>Options:</h2>
          <div class="slider-container">
            <div>Scale (x)</div>
            <div>
              <input
                type="range"
                min="0"
                max="3"
                step="0.1"
                value="1"
                name="scale"
                id="scale"
                onchange="matchSliderAndNum('scale', 'scale-num')"
              />
              <input
                type="number"
                min="0"
                max="3"
                step="0.1"
                value="1"
                id="scale-num"
                onkeyup="validateInput(this)"
                onchange="matchSliderAndNum('scale-num', 'scale')"
              />
              <input
                type="button"
                value="Reset"
                onclick="updateImage('scale', 'reset')"
              />
            </div>
            <div>Rotation (x?? y?? z??)</div>
            <div>
              <input
                type="range"
                min="-180"
                max="180"
                value="0"
                name="x-rotation"
                id="x-rotation"
                onchange="matchSliderAndNum('x-rotation', 'x-rotation-num')"
              />
              <input
                type="number"
                min="-180"
                max="180"
                value="0"
                id="x-rotation-num"
                onkeyup="validateInput(this)"
                onchange="matchSliderAndNum('x-rotation-num', 'x-rotation')"
              />
              <input
                type="range"
                min="-180"
                max="180"
                value="0"
                name="y-rotation"
                id="y-rotation"
                onchange="matchSliderAndNum('y-rotation', 'y-rotation-num')"
              />
              <input
                type="number"
                min="-180"
                max="180"
                value="0"
                id="y-rotation-num"
                onkeyup="validateInput(this)"
                onchange="matchSliderAndNum('y-rotation-num', 'y-rotation')"
              />
              <input
                type="range"
                min="-180"
                max="180"
                value="0"
                name="z-rotation"
                id="z-rotation"
                onchange="matchSliderAndNum('z-rotation', 'z-rotation-num')"
              />
              <input
                type="number"
                min="-180"
                max="180"
                value="0"
                id="z-rotation-num"
                onkeyup="validateInput(this)"
                onchange="matchSliderAndNum('z-rotation-num', 'z-rotation')"
              />
              <input
                type="button"
                value="Reset"
                onclick="updateImage('rotation', 'reset')"
              />
            </div>
          </div>
        </form>
      </div>
      <div style="flex: 25%">
        <h2>Uploaded Images:</h2>
        <div class="list-container">
          <ul id="recent"></ul>
        </div>
        <form class="upload-btn">
          <input type="file" id="file-input" onchange="replaceImage()" />
        </form>
      </div>
    </div>
    <script>
      // when a file is chosen, it gets displayed as displayedImg, replacing the old one
      // and is added to the "Uploaded Files" section
      function replaceImage() {
        const input = document.getElementById("file-input");

        // otherwise will throw an error if user clicks cancel instead of choosing file
        if (input.files.length > 0) {
          const displayedImg = document.getElementById("displayed-img");
          displayedImg.src = URL.createObjectURL(input.files[0]);

          // creates the "Uploaded Files" section
          const list = document.getElementById("recent");
          const listItem = document.createElement("li");

          const img = document.createElement("img");
          img.src = URL.createObjectURL(input.files[0]);
          img.className = "img_list";
          img.title = "Choose Image";

          listItem.appendChild(document.createTextNode(input.files[0].name));
          listItem.appendChild(img);
          list.insertBefore(listItem, list.children[0]);

          // when an uploaded image is clicked, it becomes the displayedImg
          // currently doesn't change the name of the file next to the "Choose File" button
          listItem.onclick = function () {
            displayedImg.src = img.src;
          };
        }
      }

      // matches the slider to the text value
      // the parameters will either be a slider value or input-number value
      function matchSliderAndNum(val1, val2) {
        const input = document.getElementById(val1);
        document.getElementById(val2).value = input.value;

        // call updateImage to make sure the image reflects the changes
        updateImage(val1, input.value);
      }

      // updates the displayedImg to reflect the changes made to scale and rotation
      function updateImage(id, val) {
        const scale = document.getElementById("scale");
        const rotX = document.getElementById("x-rotation");
        const rotY = document.getElementById("y-rotation");
        const rotZ = document.getElementById("z-rotation");
        const displayedImg = document.getElementById("displayed-img");

        if (val == "reset") {
          if (id[0] == "s") {
            scale.value = 1;
            document.getElementById("scale-num").value = 0;
          } else {
            rotX.value = rotY.value = rotZ.value = 0;
            document.getElementById("x-rotation-num").value = 0;
            document.getElementById("y-rotation-num").value = 0;
            document.getElementById("z-rotation-num").value = 0;
          }
        }

        // transforms the image
        displayedImg.style.transform = `scale(${scale.value}) 
                                        rotateX(${rotX.value}deg) 
                                        rotateY(${rotY.value}deg) 
                                        rotateZ(${rotZ.value}deg)`;
      }

      function sentMessage() {
        alert("Values were sent");
      }
      // makes sure the number that was manually input is within the valid range
      // if it's not, the number will change to the min or max depending on the case
      function validateInput(num) {
        if (num.value != "") {
          if (parseInt(num.value) < parseInt(num.min)) {
            num.value = num.min;
          }
          if (parseInt(num.value) > parseInt(num.max)) {
            num.value = num.max;
          }
        }
      }
    </script>
  </body>
</html>
