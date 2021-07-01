<?php
 $cmd = 'cd ../storage/app/private && ffmpeg -i motoongen.wav -i ongen.m4a -filter_complex amix=inputs=2:duration=longest output.mp3';
exec($cmd, $opt);
print_r($opt);
?>