<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Cuaca</title>
</head>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: var(--bg-gradient);
        overflow: hidden;
        transition: background 0.5s ease-in-out;
        overflow: scroll;
    }

    :root {
        --bg-gradient: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }

    .container {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 300px;
        position: relative;
        z-index: 2;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
    }

    .weather-card {
        margin-top: 20px;
        padding: 15px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .parallax-container {
    position: fixed;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    perspective: 1000px; /* Efek kedalaman */
}

.layer {
    position: absolute;
    width: 100%;
    height: auto;
    transition: transform 0.1s ease-out;
}

#background {
    top: 0;
    left: 0;
    width: 110%;
}

#sun {
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    width: 150px;
}

#clouds {
    top: 30%;
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
}
</style>

<body>
    <div class="parallax-container">
        <div id="background" class="layer">
            <img src="https://st3.depositphotos.com/1954507/18860/v/450/depositphotos_188607518-stock-illustration-vector-night-starry-sky-background.jpg" alt="Background">
        </div>
        <div id="sun" class="layer">
            <img src="https://pngimg.com/d/sun_PNG13427.png" alt="Sun">
        </div>
        <div id="clouds" class="layer">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/042/725/874/small/soft-clean-fluffy-clouds-shapes-cutout-3d-rendering-file-png.png" alt="Clouds">
        </div> 
    </div>
    <div class="container">
        <h1 class="title">Weather App</h1>
        <input type="text" id="city" placeholder="Enter city name">
        <button onclick="getWeather()">Check Weather</button>
        <div id="result" class="weather-card"></div>
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
