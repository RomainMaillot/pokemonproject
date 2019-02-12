window
    .fetch('https://api.openweathermap.org/data/2.5/weather?q=Paris&APPID=abcbde13bfd183725897e6da47c8d7c2')
    .then(_response => _response.json())
    .then((_result) =>
    {
        console.log(_result)
    })