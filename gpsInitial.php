<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
        <script src="https://unpkg.com/aframe-look-at-component@0.8.0/dist/aframe-look-at-component.min.js"></script>
        <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
    </head>

    <body style="margin: 0; overflow: hidden;">
        <div id="ar-container" style="width: 100%; height: 100%; margin: 0 auto;">
        <div id="ar-container" style="width: 100%; height: 100%; margin: 0 auto;">
        <a-scene
            vr-mode-ui="enabled: false"
            embedded
            loading-screen="enabled: false;"
            renderer="logarithmicDepthBuffer: true; alpha: true; antialias: true"
            embedded
            arjs='sourceType: webcam; debugUIEnabled: false;'>
            
            <a-image
                src="displayed_img.png"
                look-at="[gps-camera]"
                scale=".25 .25 .25"
                gps-entity-place="latitude: 42.2906875; longitude: -85.6182001;"
                position="0 0 0"
                id="ar-image"
            ></a-image>
            <a-camera id="cam" gps-camera rotation-reader></a-camera>
        </a-scene>
        </div>
        </div>

        <button id="update-location-button" onclick="changePos()">Update Location</button>
        
        <div id="image-info">
            <?php 
            // displays data from file onclick of image-info-button
                if(array_key_exists('image-info-button', $_POST)) {
                    if (file_exists("imageInfo.txt")) {
                        echo file_get_contents("imageInfo.txt");
                    }
                    else {
                        echo "values haven't been sent yet";
                    }
                }
            ?>
        </div>
        <!-- button to retrieve info from txt file -->
        <form method="post">
            <input 
            type="submit" 
            name="image-info-button" 
            id="image-info-button"
            value="Get Image Info" 
            />
        </form>
        <style>
            #ar-container {
            position: relative;
            }

            #update-location-button {
                position: absolute;
                z-index: 1;
                top: 85%;
                left: 10%;
            }
            #image-info-button {
                position: absolute;
                z-index: 1;
                top: 80%;
                left: 10%;
            }
            #image-info {
                position: absolute;
                z-index: 1;
                top: 75%;
                left: 10%;
            }
        </style>
        <script>
            function changePos() {
                navigator.geolocation.getCurrentPosition(getLocationData);
            }
            function getLocationData(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    var alt = position.coords.altitude;

                    document.getElementById("ar-image").setAttribute("gps-entity-place", "latitude: " + lat + "; longitude: " + lon + ";");
                    alert("New Coordinates: " + "Latitude: " + lat + " Longitude: " + lon);
                }



            //code to simulate gps coordinates for the camera

            // options = {
            //     enableHighAccuracy: true,
            //     timeout: 500,
            //     maximumAge: 0
            // };
            // var t=setInterval(dummyFunc,100);

            // function dummyFunc() {
            //     navigator.geolocation.getCurrentPosition(success, error, options);
            // }
            
            // function success(position) {
            //     var lat = position.coords.latitude;
            //     var lon = position.coords.longitude;

            //     var alt = position.coords.altitude;

            //     document.getElementById("cam").setAttribute("simulateLatitude", lat);
            //     document.getElementById("cam").setAttribute("simulateLongitude", lon);
            // }
            // function error(err) {
            //     console.error(`ERROR(${err.code}): ${err.message}`);
            // }
        </script>
    </body>
</html>
