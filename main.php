<html>
<head>
    <title>Heatmaps</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="module" src="./index.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.css" />
</head>
<body>
    <div id="floating-panel">
        <button id="toggle-heatmap">Toggle Heatmap</button>
        <button id="change-gradient">Change gradient</button>
        <button id="change-radius">Change radius</button>
        <button id="change-opacity">Change opacity</button>
    </div>
    <div id="floating-panel1">
        <select id="select_year">
            <option value="0">Избери година</option>
        </select>
        <select id="select_city">
            <option value="0">Избери град</option>
        </select>
        <select id="select_damage">
            <option value="0">Избери щети</option>
        </select>
        <button id="filter">Filter</button>
    </div>
    <div id="map"></div>
    <script async="false" type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=YOUR_MAPS_KEY&libraries=visualization&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        //функция за извикване на опциите години
        function fetch_year(){
            $.ajax({
                url: "fetch_year.php",
                type: "post",
                dataType: "json",
                success: function(data){
                    var yearBody = "";
                    for (var key in data) {
                        yearBody += `<option value="${data[key]['year']}">${data[key]['year']}</option>`;
                    }
                    $("#select_year").append(yearBody);
                }
            });
        }
        fetch_year();
        //функция за извикване на опциите щети
        function fetch_city(){
            $.ajax({
                url: "fetch_city.php",
                type: "post",
                dataType: "json",
                success: function (data) {
                    var cityBody = "";
                    for (var key in data) {
                        cityBody += `<option value="${data[key]['id_city']}">${data[key]['city']}</option>`;
                    }
                    $("#select_city").append(cityBody);
                }
            });
        }
        fetch_city();
        //функция за извикване на опциите щети
        function fetch_damage(){
            $.ajax({
                url: "fetch_damage.php",
                type: "post",
                dataType: "json",
                success: function(data){
                    var damageBody = "";
                    for (var key in data) {
                        damageBody += `<option value="${data[key]['id']}">${data[key]['damage']}</option>`;
                    }
                    $("#select_damage").append(damageBody);
                }
            });
        }
        fetch_damage();

        function fetch1(year, city, damage){
            $.ajax({
                url: "records.php",
                type: "post",
                data: {
                    city: city,
                    year: year,
                    damage: damage
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                }
            });
        }
        fetch1();

    let btn = document.getElementById('filter');
        btn.addEventListener('click', function (e){
            let year = document.getElementById('select_year').value;
            let idCity = document.getElementById('select_city').value;
            let idDmg = document.getElementById('select_damage').value;

            window.getPoints(year, idCity, idDmg);
        })
    </script>
</body>
</html>
