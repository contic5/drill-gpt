<?php
declare(strict_types=1);

//Supress all errors that do not result in the program crashing
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

require __DIR__ . '/vendor/autoload.php';

$dotenv = parse_ini_file('generative_ai_keys.env');

$yourApiKey = $dotenv["chat_gpt_key"];
$client = OpenAI::client($yourApiKey);

$messagesJSON=$_GET["messages"];
$messages=json_decode($messagesJSON,false);

$maxtokens=300;
if(isset($_GET["maxtokens"]))
{
    $maxtokens=(int) $_GET["maxtokens"];
}

$result = $client->chat()->create([
    'model' => 'gpt-4o-mini',
    'messages' => $messages,
    'max_tokens'=>$maxtokens
]);

echo $result->choices[0]->message->content; // Hello! How can I assist you today?
?>