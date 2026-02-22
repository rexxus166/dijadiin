<?php
$ch = curl_init('https://litellm.koboi2026.biz.id/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer sk-IT5ilRNOckB-toa1C7G_RA', 'Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'gemini-2.5-flash-lite',
    'messages' => [['role' => 'user', 'content' => 'hello test']]
]));
echo curl_exec($ch);
