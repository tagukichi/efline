# Image Assets

テーマで参照する画像ファイルの配置先です。Figma から書き出して以下のファイル名で保存してください。
ファイルが存在しない場合、テンプレートは CSS グラデーションや SVG プレースホルダーで代替表示します。

## 必要ファイル一覧

| ファイル名 | 用途 | 参照箇所 | 推奨フォーマット |
| --- | --- | --- | --- |
| `logo-mascot.png` | ヘッダー/フッターのロゴキャラクター（イーエフライン君） | `header.php` / `footer.php` | PNG（透過、~160×176px） |
| `hero.jpg` | TOP のヒーロー写真（女の子） | `front-page.php` | JPG（~1648×1392px、~150KB） |
| `product-trainer.png` | EF Line トレーナー製品画像 | `front-page.php` | PNG（透過、~640×480px） |

## Figma 内の対応ノード

| ファイル名 | Figma node-id | Figma frame |
| --- | --- | --- |
| `logo-mascot.png` | `0:119` / `0:88` | TOP PC v2 ヘッダーの image 13 / image 15 |
| `hero.jpg` | `0:39` | TOP PC v2 のヒーロー image 14 |
| `product-trainer.png` | `0:112` | TOP PC v2 の product_efline_img-full |

## 書き出し手順（Figma）

1. Figma を開き、上記ノードを選択
2. 右パネル「Export」セクションで形式・倍率を指定（写真は 2x JPG、ロゴ/装置は 2x PNG）
3. 書き出した画像を本ディレクトリに上記のファイル名で配置
4. WordPress 側のキャッシュ（オブジェクト/CDN）がある場合はクリア

## 命名規則（追加する場合）

- 小文字 + ハイフン区切り (`kebab-case`)
- 拡張子は `.jpg` / `.png` / `.svg` / `.webp`
- 大きい写真は `_2x` などの suffix で高解像度版を用意可
