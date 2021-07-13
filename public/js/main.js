/*---
itemloop（これも必要なルーディングにだけ配置したい）
---*/
    //マウスオンでメッセージを表示
    for (let step = 1; step <= 6; step++) {

        document.addEventListener('DOMContentLoaded', function () {
            let favorite_trigger = document.getElementById('favorite_trigger' + step)
            let favorite_expert = document.getElementById('favorite_expert' + step)

            //マウスポインターが乗ったタイミングで背景色を変更
            favorite_trigger.addEventListener('mouseover', function () {
                favorite_expert.style.opacity = '1.0'
            }, false)

            //マウスポインターが外れたタイミングで背景色を戻す
            favorite_trigger.addEventListener('mouseout', function () {
                favorite_expert.style.opacity = '0'
            }, false)

            let cart_trigger = document.getElementById('cart_trigger' + step)
            let cart_expert = document.getElementById('cart_expert' + step)

            //マウスポインターが乗ったタイミングで背景色を変更
            cart_trigger.addEventListener('mouseover', function () {
                cart_expert.style.opacity = '1.0'
            }, false)

            //マウスポインターが外れたタイミングで背景色を戻す
            cart_trigger.addEventListener('mouseout', function () {
                cart_expert.style.opacity = '0'
            }, false)
        }, false)
    }


/*htmlを書き換えて未購入商品をダウンロードしようとしたとき*/
function blockDownload(){
    alert('あかんで')
}

