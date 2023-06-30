<?php

$botman = app('botman');

$botman->hears('Hi(.*)', function ($bot) {
    $bot->reply('Hello');
});

$botman->hears('How are you(.*)', function ($bot) {
    $bot->reply('I am good, thank you!');
});

$botman->hears('Weather in {location}', function ($bot, $location) {
    $url = 'http://api.weatherstack.com/current?access_key=5df20a985be669cb166bc1688d9e814e&query='.urlencode($location);
    $response = json_decode(file_get_contents($url));

    $bot->reply('The weather in ' .$response->location->name. ', ' .$response->location->country.' is: ');
    $bot->reply($response->current->weather_descriptions[0]);
    $bot->reply('Temperature: '.$response->current->temperature.' Celsius. (Feels like: '.$response->current->feelslike.')');
    $bot->reply('Local time: '.$response->location->localtime);
    $bot->reply('Humidity: '.$response->current->humidity);
});

$botman->fallback(function ($bot) {
    $bot->reply("I'm sorry, I didn't understand that. Can you please rephrase?");
});


