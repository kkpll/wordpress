//タグ除去
$pattern = "/<(\/|)*?(div|p|font).*?>/";

//Hタグ
$pattern = "/<(\/|)(h[1-5]).*?>/";
$replace = "<$1$2>";

//テーブルからクラス除去
$pattern = "/<table(.*?)class\s*=\s*[\\" | '].*?[\\"|'](.*?)>/";
$replace = "<table$1$2>";












