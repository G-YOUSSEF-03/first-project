<?php 
session_start();
include("connexion.php");

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>weaher-App</title>
    <style>
        *{
    margin: 0;
    padding: 0;
    font-family: 'poppins' , sans-serif;
    box-sizing: border-box;
}
body{

    background:linear-gradient(270deg , rgb(5, 101, 126) ,rgb(13, 57, 75));

}
.card{
    width: 100%;
    max-width: 470px;
    background:linear-gradient(135deg , rgb(5, 101, 126) ,rgb(79, 78, 84));
    color: #fff;
    margin: 10px auto 10px;
    border-radius:20px ;
    padding: 40px;
    text-align: center;
}
.search{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.search input{
    border: 0;
    outline: 0;
    background:#ebfffc ;
    color: #555;
    padding: 10px 25px;
    height: 60px;
    border-radius: 30px;
    flex: 1;
    margin-right: 16px;
    font-size: 18px;
}
.search button{
    border: 0;
    outline: 0;
    background:#ebfffc ;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    cursor: pointer;
}
.search button img{
    width: 20px;
}
.weather-icon{
    width: 170px;
    margin-top: 30px;
}
.weather h1{
    font-size:80px ;
    font-weight: 500;
}
.weather h2{
    font-size:45px ;
    font-weight: 400;
    margin-top: -10px;
}
.details{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    margin-top: 50px;
}
.col{
    display: flex;
    align-items: center;
    text-align: left;
}
.col img{
    width: 40px;
    margin-right: 10px;
}
.humidity , .wind{
    font-size:28px ;
    margin-top:-6px ;
}
    </style>
</head>
<body>
    
    <div class="card">
        <div class="search">
            <input type="text" placeholder="Enter City Name" spellcheck="false">
            <button><img src="img/search.png" alt=""></button>
        </div>
        <div class="weather">
            <img src="img/rain.png" class="weather-icon">
            <h1 class="temp">22°C</h1>
            <h2 class="city">New York</h2>
            <div class="details">
                <div class="col">
                    <img src="img/humidity.png">
                    <div>
                        <p class="humidity">50%</p>
                        <p>Humidity</p>
                    </div>
                </div>

                <div class="col">
                    <img src="img/wind.png">
                    <div>
                        <p class="wind">15 <km>
                        <h></h></p>
                        <p>Wind Speed</p>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <script>

        const apikey = "1ea7540c78690c21c2af5448c6eca1d0";
        const apiurl = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=" ;

        const searchBox = document.querySelector('.search input')
        const searchBtn = document.querySelector('.search button')

        const weatherIcon = document.querySelector('.weather-icon')

        async function checkweather(city){
            try{

            const response = await fetch(apiurl + city + `&appid=${apikey}`);
            var data = await response.json();
            console.log(data)

            

            
            document.querySelector('.city').innerHTML = data.name;
            document.querySelector('.temp').innerHTML = Math.round(data.main.temp)  + "°C" ;
            document.querySelector('.humidity').innerHTML = data.main.humidity + "%";
            document.querySelector('.wind').innerHTML = data.wind.speed + "km/h";


            if(data.weather[0].main == "Clouds"){
                weatherIcon.src = "img/clouds.png"
            }else if(data.weather[0].main == "Clear"){
                weatherIcon.src = "img/clear.png"
            }else if(data.weather[0].main == "Rain"){
                weatherIcon.src = "img/rain.png"
            }else if(data.weather[0].main == "Drizzle"){
                weatherIcon.src = "img/drizzle.png"
            }else if(data.weather[0].main == "Mist"){
                weatherIcon.src = "img/mist.png"
            }else if(data.weather[0].main == "Snow"){
                weatherIcon.src = "img/snow.png"
            }





            }catch(error){
                console.error(error)
            }
            
        }
        searchBtn.addEventListener("click" , ()=>{
            checkweather(searchBox.value)
        })



    </script>

</body>
</html>


