<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Cuaca</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: var(--bg-gradient);
            transition: background 0.5s ease-in-out;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            /* backdrop-filter: blur(10px); */
            /* background: rgba(255, 255, 255, 0.2); */
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); */
            z-index: 100;
        }

        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin-left: 60px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 10px;
            transition: background 0.3s ease-in-out;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
            height: 100%;
            position: relative;
            margin-top: 80px;
        }

        .leftbar {
            margin: 80px 0 0 80px;
            width: 620px;
            height: 100%;
        }

        .leftbar h1 {
            font-size: 5rem;
            color: white;
        }

        .leftbar h6 {
            font-size: 2.1rem;
            color: white;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        .leftbar p {
            font-size: 1.1rem;
            color: white;
            margin-top: 12px;
        }

        .rightbar {
            display: flex;
            flex-direction: column;
            margin: 90px 40px 0 0;
            width: 300px;
            /* height: auto; */
        }
        .rightbar-top {
            display: flex;
            justify-content: space-between;
            height: auto;
        }

        .rightbar-top h1 {
            font-size: 7rem;
            color: white;
            font: 100;
        }

        .left-side {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            height: 200px;
            border-radius: 20px;
            margin-top: 20px;
        }

        .weather-card {
            margin-top: 20px;
            padding: 15px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="logo">☁ Weather App</div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Forecast</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </nav>
    <div>
        <div style="display: flex; justify-content: space-between">
            <div class="leftbar">
                <h1>Stormy</h1>
                <h6>With Heavy Rain</h6>
                <p>Lorem ipsum dolor, sit amet consectetur adipisiUt, obcaecati onsectetur adipisiUt, obcaecationsectetur adipisiUt, obcaecationsectetur adipisiUt, obcaecati onsectetur adipisiUt, obcaecati.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 35px;">
                    <div class="card" style="flex: 1 25%; padding: 10px;">
                        <!-- Konten Card 1 -->
                    </div>
                    <div class="card" style="flex: 1 25%; padding: 10px;">
                        <!-- Konten Card 2 -->
                    </div>
                    <div class="card" style="flex: 1 25%; padding: 10px;">
                        <!-- Konten Card 3 -->
                    </div>
                </div>
                <div class="card" style="height: 180px;">

                </div>
                
            </div>
            <div class="rightbar">
                <div class="rightbar-top">
                    {{-- <input type="text" id="city" placeholder="Enter city name">
                    <button onclick="getWeather()">Check Weather</button>
                    <div id="result" class="weather-card"></div> --}}
                    <div class="left-side">
                        <div class="card" style="width: 60px; height: 30px; border-radius: 100px;"></div>
                        <div>
                            <div class="card" style="width: 60px; height: 30px; border-radius: 100px;"></div>
                            <div class="card" style="width: 60px; height: 30px; border-radius: 100px;"></div>
                        </div>
                        <div class="card" style="width: 100px; height: 60px; border-radius: 20px;"></div>
                    </div>
                    <div>
                        <h1>27</h1>
                        <div class="card" style="width: 100%; height: 100px;"></div>
                    </div>
                    {{-- <div class="card" style="width: 100px;"></div> --}}
                </div>
                <div class="card" style="height: 100%;" id="result"></div>
            </div>

        </div>
    </div>
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const background = document.getElementById("background");
            const sun = document.getElementById("sun");
            const clouds = document.getElementById("clouds");

            // Efek Parallax Saat HP Dimiringkan (3D)
            window.addEventListener("deviceorientation", function(event) {
                let tiltX = event.gamma; // Kemiringan kiri-kanan
                let tiltY = event.beta; // Kemiringan depan-belakang

                let moveX = tiltX * 2; // Gerakan latar ke samping
                let moveY = tiltY * 1.5; // Gerakan latar ke atas/bawah

                background.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.1)`;
                sun.style.transform = `translate(${moveX / 3}px, ${moveY / 3}px)`;
                clouds.style.transform = `translate(${moveX / 2}px, ${moveY / 2}px)`;
            });

            // Efek Parallax Saat Scroll
            window.addEventListener("scroll", function() {
                let scrollY = window.scrollY;

                sun.style.transform = `translateY(${scrollY * -0.5}px)`;
                clouds.style.transform = `translateY(${scrollY * -0.8}px)`;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let currentHour = new Date().getHours();
            updateBackground(currentHour);

            navigator.permissions.query({
                name: 'geolocation'
            }).then(permission => {
                if (permission.state === "granted") {
                    getLocationWeather(); // Langsung ambil cuaca jika izin sudah diberikan
                } else if (permission.state === "prompt") {
                    // Minta izin lokasi (akan muncul pop-up browser)
                    navigator.geolocation.getCurrentPosition(
                        position => getLocationWeather(),
                        error => alert("Izin lokasi diperlukan untuk mendapatkan cuaca!")
                    );
                } else {
                    alert("Lokasi diblokir oleh pengguna. Silakan izinkan di pengaturan browser.");
                }
            });
        });


        function getWeather() {
    let city = document.getElementById("city").value;

    fetch(`http://127.0.0.1:8000/weather/${city}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Menampilkan data dari API ke console untuk debug

            if (data.error) {
                document.getElementById("result").innerHTML = `<p>${data.error}</p>`;
            } else {
                let sunrise = new Date(data.sys.sunrise * 1000).toLocaleTimeString();
                let sunset = new Date(data.sys.sunset * 1000).toLocaleTimeString();
                let timezone = data.timezone / 3600; // Konversi ke jam
                let visibility = data.visibility / 1000;
                let weatherCondition = data.weather && data.weather[0] ? data.weather[0].main : 'Tidak diketahui'; // Menambahkan pengecekan
                let weatherDescription = data.weather && data.weather[0] ? data.weather[0].description : 'Tidak tersedia'; // Menambahkan pengecekan
                let windDirection = getWindDirection(data.wind.deg);

                document.getElementById("result").innerHTML = `
                    <h2>🌤 Cuaca di ${data.name}</h2>
                    <p>🌥️ Kondisi Cuaca: ${weatherCondition} (${weatherDescription})</p>
                    <p>🌡️ Temperatur: ${data.main.temp}°C</p>
                    <p>🤲 Terasa Seperti: ${data.main.feels_like}°C</p>
                    <p>🌡️ Min: ${data.main.temp_min}°C | Max: ${data.main.temp_max}°C</p>
                    <p>💧 Kelembaban: ${data.main.humidity}%</p>
                    <p>💦 Titik Embun: ${calculateDewPoint(data.main.temp, data.main.humidity)}°C</p>
                    <p>🌫️ Jarak Pandang: ${visibility} KM</p>
                    <p>🌬️ Angin: ${data.wind.speed} m/s, Arah: ${windDirection} (${data.wind.deg}°)</p>
                    <p>🌪️ Tekanan Udara: ${data.main.pressure} hPa</p>
                    <p>☁️ Awan: ${data.clouds.all}%</p>
                    <p>🌅 Matahari Terbit: ${sunrise}</p>
                    <p>🌇 Matahari Terbenam: ${sunset}</p>
                    <p>⏳ Zona Waktu: UTC ${timezone >= 0 ? '+' : ''}${timezone}</p>
                    <p>📍 Lokasi: ${data.coord.lat}, ${data.coord.lon}</p>
                    <p>📖 Deskripsi: ${data.weather[0].description}</p>
                    <img src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="Icon Cuaca">
                `;
            }
        })
        .catch(error => console.log("Error:", error));
}


        // Konversi derajat ke arah mata angin
        function getWindDirection(degree) {
            const directions = ["Utara", "Timur Laut", "Timur", "Tenggara", "Selatan", "Barat Daya", "Barat", "Barat Laut"];
            return directions[Math.round(degree / 45) % 8];
        }

        // Menghitung Dew Point (Titik Embun) menggunakan rumus Magnus
        function calculateDewPoint(temp, humidity) {
            let a = 17.27;
            let b = 237.7;
            let alpha = ((a * temp) / (b + temp)) + Math.log(humidity / 100);
            return (b * alpha) / (a - alpha);
        }

        function getLocationWeather() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;

                    fetch(`http://127.0.0.1:8000/weather?lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if (data.error) {
                                document.getElementById("result").innerHTML = `<p>${data.error}</p>`;
                            } else {
                                let sunrise = new Date(data.sys.sunrise * 1000).toLocaleTimeString();
                                let sunset = new Date(data.sys.sunset * 1000).toLocaleTimeString();
                                let timezone = data.timezone / 3600; // Konversi ke jam
                                let visibility = data.visibility / 1000; // Konversi ke KM
                                let windDirection = getWindDirection(data.wind.deg);

                                document.getElementById("result").innerHTML = `
                            <h2>🌤 Cuaca di ${data.name}</h2>
                            <p>🌡️ Temperatur: ${data.main.temp}°C</p>
                            <p>🤲 Terasa Seperti: ${data.main.feels_like}°C</p>
                            <p>🌡️ Min: ${data.main.temp_min}°C | Max: ${data.main.temp_max}°C</p>
                            <p>💧 Kelembaban: ${data.main.humidity}%</p>
                            <p>💦 Titik Embun: ${calculateDewPoint(data.main.temp, data.main.humidity)}°C</p>
                            <p>🌫️ Jarak Pandang: ${visibility} KM</p>
                            <p>🌬️ Angin: ${data.wind.speed} m/s, Arah: ${windDirection} (${data.wind.deg}°)</p>
                            <p>🌪️ Tekanan Udara: ${data.main.pressure} hPa</p>
                            <p>☁️ Awan: ${data.clouds.all}%</p>
                            <p>🌅 Matahari Terbit: ${sunrise}</p>
                            <p>🌇 Matahari Terbenam: ${sunset}</p>
                            <p>⏳ Zona Waktu: UTC ${timezone >= 0 ? '+' : ''}${timezone}</p>
                            <p>📍 Lokasi: ${data.coord.lat}, ${data.coord.lon}</p>
                            <p>📖 Deskripsi: ${data.weather[0].description}</p>
                            <img src="https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png" alt="Icon Cuaca">
                        `;
                            }
                        })
                        .catch(error => console.log("Error fetching location weather:", error));
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }



        function updateBackground(hour) {
            let root = document.documentElement;
            if (hour >= 6 && hour < 12) {
                root.style.setProperty('--bg-gradient', 'linear-gradient(135deg, #FFDD94, #FA897B)');
            } else if (hour >= 12 && hour < 18) {
                root.style.setProperty('--bg-gradient', 'linear-gradient(135deg, #87CEEB, #4682B4)');
            } else if (hour >= 18 && hour < 20) {
                root.style.setProperty('--bg-gradient', 'linear-gradient(135deg, #FF758C, #FF7EB3)');
            } else {
                root.style.setProperty('--bg-gradient', 'linear-gradient(135deg, #2C3E50, #4CA1AF)');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            let currentHour = new Date().getHours();
            updateBackground(currentHour);
        });
    </script>

</body>

</html>
