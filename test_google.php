<?php
$ch = curl_init('https://generativelanguage.googleapis.com/v1beta/openai/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer AIzaSyB2x523E4oLS64pl4IvF1ZK4GJaDCrnKXw', 'Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'gemini-2.5-flash',
    'messages' => [['role' => 'user', 'content' => 'hello config test']]
]));
echo curl_exec($ch);
