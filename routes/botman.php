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


$botman->hears('(.*)fun fact(.*)', function ($bot) {
    $url = 'https://api.api-ninjas.com/v1/facts?limit=1';

    $apiKey = env('API_KEY');
    $headers = [
        'http' => [
            'header' => "X-Api-Key: $apiKey\r\n",
        ],
    ];

    $context = stream_context_create($headers);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $data = json_decode($response, true);

        if (!empty($data)) {
            $fact = $data[0]['fact'];
            $bot->reply('Here\'s a fun fact for you:');
            $bot->reply($fact);
        } else {
            $bot->reply('No fun facts found.');
        }
    } else {
        $bot->reply('Oops! Something went wrong while fetching the fun fact.');
    }
});

$botman->hears('(.*)joke(.*)', function ($bot) {
    $url = 'https://api.api-ninjas.com/v1/jokes?limit=1';

    $apiKey = env('API_KEY');
    $headers = [
        'http' => [
            'header' => "X-Api-Key: $apiKey\r\n",
        ],
    ];

    $context = stream_context_create($headers);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $data = json_decode($response, true);

        if (!empty($data)) {
            $fact = $data[0]['joke'];;
            $bot->reply('Here\'s a joke for you:');
            $bot->reply($fact);
        } else {
            $bot->reply('No jokes found.');
        }
    } else {
        $bot->reply('Oops! Something went wrong while fetching the joke.');
    }
});

$botman->hears('(.*)hobby(.*)', function ($bot) {
    $url = 'https://api.api-ninjas.com/v1/hobbies?=';

    $apiKey = env('API_KEY');
    $headers = [
        'http' => [
            'header' => "X-Api-Key: $apiKey\r\n",
        ],
    ];

    $context = stream_context_create($headers);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $data = json_decode($response, true);

        if (!empty($data)) {
            $hobby = $data['hobby'];
            $link = $data['link'];
            $bot->reply('Here\'s a hobby for you:');
            $bot->reply($hobby);
            $bot->reply('Learn more about it here: ' . $link);
        } else {
            $bot->reply('No hobbies found.');
        }
    } else {
        $bot->reply('Oops! Something went wrong while fetching the hobby.');
    }
});


$botman->hears('info {name}', function ($bot, $name) {
    $url = 'https://api.api-ninjas.com/v1/celebrity?name=' . urlencode($name);

    $apiKey = env('API_KEY');
    $headers = [
        'http' => [
            'header' => "X-Api-Key: $apiKey\r\n",
        ],
    ];


    $context = stream_context_create($headers);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $data = json_decode($response, true);

        if (!empty($data)) {
            $celebrities = $data;
            $bot->reply('Here\'s information about ' . $celebrities[0]['name'] . ':');
            $bot->reply('Profession: ' . implode(', ', $celebrities[0]['occupation']));
            $bot->reply('Height: ' . $celebrities[0]['height']);
            $bot->reply('Net worth: ' . $celebrities[0]['net_worth']);
        } else {
            $bot->reply('No information found for ' . $name);
        }
    } else {
        $bot->reply('Oops! Something went wrong while fetching the celebrity information.');
    }
});



$botman->fallback(function ($bot) {
    $bot->reply("I'm sorry, I didn't understand that. Can you please rephrase?");
});


