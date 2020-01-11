<?php

use Discord\Parts\User\Game;

include __DIR__.'/vendor/autoload.php';

$discord = new \Discord\Discord([
    'token' => getenv('TOKEN'),
]);

$game = $discord->factory(Game::class, [
    'name' => 'i am playing a game!',
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;

    // Listen for events here
    $discord->on('message', function ($message) {
        echo "Recieved a message from {$message->author->username}: {$message->content}", PHP_EOL;
    });
});

$discord->on('ready', function ($discord) {
    // Listen for events here
    $botUser = $discord->user;
    $discord->on('message', function ($message) use ($botUser) {

        if ($message->author->user->id !== $botUser->id) { //Botからのメンションを除外

            if (isset($message->mentions[$botUser->id])) { //メンションが飛んできたとき

                if ($message->channel_id == 663054096894394371) { //マイクラチャンネルの時

                    $chackCmd = "ps ax| grep server.jar | grep -v grep  | awk '{print $1}'";
                    $startCmd = "./../../citMine.sh";

                    if (ltrim($message->content, '<@!663705232399925249> ') === 'start') {
                        if (exec($chackCmd) != '') {
                            $message->reply('もう起動してるよ{PID =>' . exec($chackCmd) . '}');
                        } else {
                            echo exec($startCmd);
                            $message->reply('サーバを起動したよ{PID =>' . exec($chackCmd) . '}');
                        }
                    }

                    if (ltrim($message->content, '<@!663705232399925249> ') === 'down') {
                        exec("kill" . exec($cmd));
                        $message->reply('サーバを終了したよ');
                    }
                }

                if ($message->channel_id == 582114497641054208) { //lolチャンネルの時

                        $base_url = 'https://qiita.com';
                        $tag = 'PHP';

                        $curl = curl_init();

                        curl_setopt($curl, CURLOPT_URL, $base_url . '/api/v2/tags/' . $tag . '/items');
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HEADER, true);   // ヘッダーも出力する

                        $response = curl_exec($curl);
                        // ステータスコード取得
                        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                        // header & body 取得
                        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); // ヘッダサイズ取得
                        $header = substr($response, 0, $header_size); // headerだけ切り出し
                        $body = substr($response, $header_size); // bodyだけ切り出し

                        // json形式で返ってくるので、配列に変換
                        $result = json_decode($body, true);

                        // ヘッダから必要な要素を取得
                        preg_match('/Total-Count: ([0-9]*)/', $header, $matches); // 取得記事要素数
                        $total_count = $matches[1];

                        curl_close($curl);
                }
            }
        }
    });
});

$discord->run();