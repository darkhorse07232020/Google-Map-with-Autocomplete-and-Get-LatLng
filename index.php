<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete Address Form</title>
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/index.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/index.js"></script>
  </head>
  
  <body>
    <div id="address" class="p-3">

<?php
if (isset($_REQUEST['address'])) {
     $address = urlencode($_REQUEST['address']);
     $url = 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.$address.'&inputtype=textquery&fields=formatted_address,geometry&key=AIzaSyDH1-nya9mZdJpxk2UMZvFh6eXTYb3vQFM';
     $response = file_get_contents($url);
     $res_json = json_decode($response, true);
     if($res_json['status']=='OK'){
 
          // get the important data
          $lat = isset($res_json['candidates'][0]['geometry']['location']['lat']) ? $res_json['candidates'][0]['geometry']['location']['lat'] : "";
          $lng = isset($res_json['candidates'][0]['geometry']['location']['lng']) ? $res_json['candidates'][0]['geometry']['location']['lng'] : "";
          $full_address = isset($res_json['candidates'][0]['formatted_address']) ? $res_json['candidates'][0]['formatted_address'] : "";
           
      }
?>
      <div class="py-2">
          <input class="field" id="route" value="<?php echo $full_address ?>"/>
      </div>
      <div class="row py-2">
        <div class="col-3 text-right">Latitude</div>
        <div class="col-9">
          <input class="field" id="lat" value="<?php echo $lat ?>"/>
        </div>
      </div>
      <div class="row py-2">
        <div class="col-3 text-right">Longitude</div>
        <div class="col-9">
          <input class="field" id="lng" value="<?php echo $lng ?>"/>
        </div>
      </div>
<?php
} else {
?>
      <div class="py-2">
        <input
          id="autocomplete"
          placeholder="Enter your address"
          onFocus=""
          class="field"
          type="text"
        />
      </div>
      <div class="row py-2">
        <div class="col-3 text-nowrap text-right">Street address</div>
        <div class="col-9">
          <input class="field" id="route"/>
        </div>
      </div>
      <div class="row py-2">
        <div class="col-3 text-nowrap text-right">City/State/Zip</div>
        <div class="col-5">
          <input class="field" id="locality"/>
        </div>
        <div class="col-2">
          <input
            class="field"
            id="administrative_area_level_1"
          />
        </div>
        <div class="col-2">
          <input class="field" id="postal_code"/>
        </div>
      </div>
      <div class="row py-2">
        <div class="col-3 text-right">Country</div>
        <div class="col-9">
          <input class="field" id="country"/>
        </div>
      </div>
      <div class="py-2 w-100 d-flex justify-content-center">
        <button id="calc" class="btn btn-primary w-25" onclick="getLatLng()">Get Lat/Lng</button>
      </div>
      <div class="row py-2">
        <div class="col-3 text-right">Latitude</div>
        <div class="col-9">
          <input class="field" id="lat"/>
        </div>
      </div>
      <div class="row py-2">
        <div class="col-3 text-right">Longitude</div>
        <div class="col-9">
          <input class="field" id="lng"/>
        </div>
      </div>
      <?php
}
?>
    </div>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=Your_API_KEY&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script>
  </body>
</html>
