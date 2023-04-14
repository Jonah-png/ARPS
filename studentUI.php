<!DOCTYPE html>
<html>

<head>
  <style>
    .position {
      position: absolute;
      z-index: 1;
    }

    input[type="number"] {
      width: 50px;
    }
  </style>
</head>
<!--Passes in a-frame components and interaction between a-frame and arjs-->
<script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
<script src="https://unpkg.com/aframe-look-at-component@0.8.0/dist/aframe-look-at-component.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>

<body style="margin: 0px; overflow: hidden">
  <!-- this a-scene works with obs virtual camera -->
  <a-scene embedded vr-mode-ui="enabled: false" arjs='sourceType: webcam; sourceWidth:1280; sourceHeight:960; displayWidth: 1280; displayHeight: 960; debugUIEnabled: false;'>
  <!-- this a-scene works with actual camera -->
  <!-- <a-scene vr-mode-ui="enabled: false" embedded loading-screen="enabled: false;" renderer="logarithmicDepthBuffer: true; alpha: true; antialias: true" embedded arjs='sourceType: webcam; debugUIEnabled: false;'> -->

    <a-marker preset="hiro" id="main">
      <?php
      // displays data from file onclick of image-info-button
      if (array_key_exists('image-info-button', $_POST)) {
        $image = "<a-image";
        $files = glob("images/audience/*");
        if (count($files) == 1) {
          $image .= " src='" . $files[0] . "'";
          // sets the height and width so that it keeps the same aspect ratio
          list($width, $height, $type, $attr) = getimagesize($files[0]);
          $image .= " height='1' width='" . $width / $height . "' ";
          $image .= " position='0 0 0' scale='1 1 1' rotation='-90 0 0'></a-image>";
          echo $image;
        }
      }
      ?>
    </a-marker>
    <!--This last component makes the user device's camera view the background of the scene-->
    <a-entity camera look-controls> </a-entity>
  </a-scene>
  <div class="slider-container position" style="right: 10px; bottom: 10px;">
    <div>Scale (x)</div>
    <div>
      <input type="range" min="0" max="6" step="0.1" value="1" name="scale" id="scale" onchange="matchSlider('scale', 'scale-num')" />
      <input type="number" min="0" max="6" step="0.1" value="1" id="scale-num" onkeyup="validateInput(this)" onchange="matchSlider('scale-num', 'scale')" />
      <input type="button" value="Reset" onclick="updateImage('scale', 'reset')" />
    </div>
    <div>Rotation (°)</div>
    <div>
      <input type="range" min="-270" max="90" value="-90" name="x-rot" id="x-rot" onchange="matchSlider('x-rot', 'x-rot-num')" />
      <input type="number" min="-270" max="90" value="-90" id="x-rot-num" onkeyup="validateInput(this)" onchange="matchSlider('x-rot-num', 'x-rot')" />
      <input type="button" value="Reset" onclick="updateImage('rotation', 'reset')" />
    </div>
  </div>
  <form method="post" class="position" style="left: 10px; bottom: 50px">
    <input type="submit" name="image-info-button" id="image-info-button" value="Update" />
  </form>
  <button class="position" style="left: 10px; bottom: 10px;"><a href="/ARPS/professorUI.php">Professor UI</a></button>
  <script>
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
    // matches the slider to the text value
    // the parameters will either be a slider value or input-number value
    function matchSlider(val1, val2) {
      const input = document.getElementById(val1);
      document.getElementById(val2).value = input.value;

      // call updateImage to make sure the image reflects the changes
      updateImage(val1, input.value);
    }

    // updates the displayedImg to reflect the changes made to scale and rotation
    function updateImage(id, val) {
      const scale = document.getElementById("scale");
      const rotX = document.getElementById("x-rot");
      const displayedImg = document.getElementById("displayed-img");

      if (val == "reset") {
        if (id[0] == "s") {
          scale.value = 1;
          document.getElementById("scale-num").value = 1;
        } else {
          rotX.value = -90;
          document.getElementById("x-rot-num").value = -90;
        }
      }
      // transforms the image
      document.querySelector("a-image").object3D.scale.set(scale.value, scale.value, scale.value);
      document.querySelector("a-image").object3D.rotation.set(rotX.value * Math.PI / 180, 0, 0);
    }
  </script>
</body>

</html>