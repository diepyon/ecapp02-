<?php
        //watermark(作成中、モデルに書いた方が美しいと思う)
        //create Image from file
        $img = Image::make('image/a.jpg');
        

        // write text
        $img->text('The quick brown fox jumps over the lazy dog.');

        // write text at position
        $img->text('The quick brown fox jumps over the lazy dog.', 120, 100);

        // use callback to define details
        $img->text('foo', 0, 0, function ($font) {
            $font->file('fonts/localfont/uzura.ttf');
            $font->size(24);
            $font->color('#fdf6e3');
            $font->align('center');
            $font->valign('top');
            $font->angle(45);
        });

        // draw transparent text
        $img->text('foo', 0, 0, function ($font) {
        $font->color(array(255, 255, 255, 0.5));
        }
    );
        return $img;
        //watermark終わり
