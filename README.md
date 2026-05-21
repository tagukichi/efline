# efline — こどもの矯正 WordPress テーマ

口腔機能訓練装置「efline トレーナー」と取扱いクリニックを紹介するクラシックテーマ。
Figma デザイン（[Z9Dx4Z90GlLVmxMnh1WBr2](https://www.figma.com/design/Z9Dx4Z90GlLVmxMnh1WBr2/)）をベースにゼロから構築。

## 開発状況

| フェーズ | 内容 | 状態 |
| --- | --- | --- |
| 1 | テーマ骨格 + デザイントークン | ✅ 完了 |
| 2 | ACF フィールド定義（clinic CPT） | ✅ 完了 |
| 3 | TOP ページ実装 | 未着手 |
| 4 | クリニック紹介 一覧 / 詳細 | 未着手 |
| 5 | こどもの歯並び / EF の使い方 / Q&A | 未着手 |
| 6 | お問い合わせ（Contact Form 7） | 未着手 |
| 7 | SP 調整 + ブラウザ確認 | 未着手 |

## ローカルセットアップ

1. WordPress 6.4+ / PHP 8.0+ の環境を用意
2. このリポジトリを `wp-content/themes/efline/` として配置
3. 必須プラグインを有効化
   - **Advanced Custom Fields (ACF Pro)** — クリニック紹介のカスタムフィールド
   - **Contact Form 7** — お問い合わせフォーム
4. 管理画面 → 外観 → テーマで「efline - こどもの矯正」を有効化
5. パーマリンク設定を保存して書き換えルールを更新（CPT `clinic` のため）

## ディレクトリ構成

```
efline/
├── style.css              # テーマヘッダ
├── functions.php          # bootstrap
├── index.php              # フォールバック
├── front-page.php         # TOP
├── page.php / singular.php
├── archive-clinic.php     # クリニック一覧
├── single-clinic.php      # クリニック詳細
├── header.php / footer.php
├── inc/
│   ├── setup.php          # add_theme_support / メニュー登録
│   ├── enqueue.php        # CSS/JS エンキュー
│   ├── cpt-clinic.php     # CPT clinic 登録
│   └── acf.php            # ACF JSON sync 設定
├── acf-json/              # ACF フィールド定義（自動同期）
├── assets/
│   ├── css/
│   │   ├── tokens.css     # デザイントークン (CSS変数)
│   │   ├── base.css       # リセット + タイポ
│   │   └── main.css       # コンポーネント
│   ├── js/main.js
│   └── images/
└── README.md
```

## デザイントークン

すべての色・タイポ・余白は `assets/css/tokens.css` の CSS 変数で管理。変更はこのファイルに集約してください。

### カラー

| トークン | 値 | 用途 |
| --- | --- | --- |
| `--color-primary` | `#49bce3` | CTA・アクセント |
| `--color-heading` | `#395562` | 見出し |
| `--color-text` | `#333333` | 本文 |
| `--color-border` | `#dddddd` | 区切り線 |

### フォント

| トークン | 値 | 備考 |
| --- | --- | --- |
| `--font-sans` | M PLUS 1, Noto Sans JP | Google Fonts 配信。本文・ナビ |
| `--font-display` | A-OTF UD Shin Go Pro → M PLUS 1 | 商用フォント。Web配信不可のためフォールバック |
| `--font-logo` | Keifont → M PLUS 1 | ロゴ「こどもの矯正」。**画像書き出し推奨** |

> **注意**: Keifont / A-OTF UD Shin Go Pro は商用フォントのため Web 配信できません。デザインで使用されている箇所（ロゴ、製品名等）は Figma から画像（SVG / PNG）として書き出し、`assets/images/` に配置する運用とします。

## カスタム投稿タイプ

### `clinic` — クリニック紹介

- アーカイブ: `/clinics/`
- 詳細: `/clinics/{slug}/`
- サポート: タイトル / アイキャッチ / リビジョン / ページ属性
- 一般公開: あり

**ACF フィールド（フェーズ2 で定義）**
- 基本情報（名称・住所・電話・診療時間）
- WEB 予約リンク
- 診療内容
- 説明文（見出し + 本文）
- アクセスマップ（Google Map）

## メニュー位置

| 位置 | スロット |
| --- | --- |
| `primary` | グローバルナビ（こどものはならび / 装置の使い方 / Q&A / 取扱いクリニック） |
| `footer` | フッターナビ |
