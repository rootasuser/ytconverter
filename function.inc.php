<?php
    
    $web_title = "Youtube MP4/MP3 Converter";

    set_time_limit(300);

    $dlDir = __DIR__ . '/downloads';

    if (!is_dir($dlDir)) mkdir($dlDir, 0755, true);

    $err = [];
    $dlUrl = '';

    $ytDlp = __DIR__ . DIRECTORY_SEPARATOR . 'bin/yt-dlp.exe';
    $ffmpeg = __DIR__ . DIRECTORY_SEPARATOR . 'bin/ffmpeg.exe';


    if (!file_exists($ytDlp)) {
        $err[] = "yt-dlp executable not found!";
    }

    if (!file_exists($ffmpeg)) {
        $err[] = "ffmpeg executable not found!";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($err)) {
       $url = trim($_POST['url'] ?? '');
       $format = ($_POST['format'] ?? 'mp3') === 'mp4' ? 'mp4' : 'mp3';

       if (empty($url) || !preg_match('/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\//', $url)) {
           $err[] = "Please enter a valid YouTube video URL.";
       } else {
           $safeFile = uniqid('yt_', false);
            $opTemp = "$dlDir/{$safeFile}.%(ext)s";

           if ($format === 'mp3') {
                $cmd = "\"$ytDlp\" -x --audio-format mp3 --ffmpeg-location \"$ffmpeg\" -o " 
                    . escapeshellarg($opTemp) . ' ' . escapeshellarg($url) . " 2>&1";
            } else {
                $cmd = "\"$ytDlp\" -f mp4 --ffmpeg-location \"$ffmpeg\" -o "
                    . escapeshellarg($opTemp) . ' ' . escapeshellarg($url) . " 2>&1";
            }


            exec($cmd, $output, $returnCode);


            if ($returnCode === 0) {
                $files = glob("$dlDir/{$safeFile}.*");
                if (!empty($files)) {
                    $finalFile = basename($files[0]);
                    $dlUrl = 'downloads/' . $finalFile;
                    } else {
                        $err[] = "Conversion completed but the file not found.";
                } 
             } else {
              $err[] = "Conversion failed. Output: " . htmlspecialchars(implode("\n", $output));
        }  
    }
}

?>
