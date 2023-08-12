<?php
// Получаем случайный заголовок статьи
$randomArticleUrl = "https://ru.wikipedia.org/wiki/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F:%D0%A1%D0%BB%D1%83%D1%87%D0%B0%D0%B9%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0";
$html = file_get_contents($randomArticleUrl);

// Используем DOMDocument для парсинга HTML
$dom = new DOMDocument();
@$dom->loadHTML($html);

// Получаем заголовок и extract
$title = $dom->getElementsByTagName("h1")->item(0)->textContent;
$extract = $dom->getElementById("mw-content-text")->getElementsByTagName("p")->item(0)->textContent;

// Убираем символы [1], [2], и пустоту из текста extract
$extract = preg_replace('/\[\d+\]/', '', $extract);

// Получаем изображения
$images = [];
$imageElements = $dom->getElementById("mw-content-text")->getElementsByTagName("img");

foreach ($imageElements as $imageElement) {
    $imageSrc = $imageElement->getAttribute("src");

    $parsedUrl = parse_url($imageSrc);

    if ($parsedUrl['path'] !== "/wiki/Special:CentralAutoLogin/start") {
        if (
            strpos($imageSrc, ".svg") === false
            && strpos($imageSrc, ".png") === false
            && strpos($imageSrc, ".gif") === false
        ) {
            $images[] = $imageSrc;
        }
    }
}

$data = [
    "title" => $title,
    "extract" => $extract,
    "images" => $images
];

// Выводим JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
